<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeasonRelationResource\RelationManagers\SeasonsRelationManager;
use App\Filament\Resources\SeriesResource\Pages;
use App\Filament\Resources\SeriesResource\RelationManagers;
use App\Filament\Resources\TrailerRelationResource\RelationManagers\TrailersRelationManager;
use App\Models\Series;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class SeriesResource extends Resource
{
    protected static ?string $model = Series::class;

    protected static ?string $navigationLabel = 'سریال ها';
    protected static ?string $pluralModelLabel = 'سریال ها';
    protected static ?string $modelLabel = 'سریال';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('اطلاعات فیلم')
                ->schema([
                    TextInput::make('title')->label('عنوان')->required(),
                    TextInput::make('e_name')->label('نام انگلیسی')
                        ->live(debounce: 1000)
                        ->afterStateUpdated(function ($state, Forms\Set $set) {
                            $set('slug', Str::slug($state));
                        })
                        ->required(),
                    TextInput::make('slug')->label('Slug')
                        ->unique(ignoreRecord: true)
                        ->hint('به صورت خودکار از نام انگلیسی تولید می‌شود')
                        ->required(),
                    textarea::make('description')
                        ->label('توضیحات')
                        ->required(),
                ])->columns(2),
            Section::make('دسته بندی و کشور')
                ->schema([
                    Select::make('categories')
                        ->label('دسته‌بندی‌ها')
                        ->multiple()
                        ->searchable()
                        ->relationship('categories', 'name') // ستون name جدول categories
                        ->required()
                        ->preload(),// برای لود اولیه گزینه‌ها
                    Select::make('countries')
                        ->label('کشورها')
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->required()
                        ->relationship('countries', 'name_fa'),
                ])->columns(2),
            Section::make('اطلاعات تکمیلی')
                ->relationship('details')
                ->schema([
                    TextInput::make('imdb_id')->label('IMDb ID')->required(),
                    TextInput::make('imdb_rating')
                        ->label('امتیاز IMDB')
                        ->numeric()
                        ->type('number')
                        ->step(0.1)
                        ->minValue(0)
                        ->maxValue(10)
                        ->required()
                        ->suffix('/۱۰')
                        ->hint('عدد بین ۰ تا ۱۰ با یک رقم اعشار')
                        ->columnSpan(1),
                    Select::make('release_year')
                        ->label('سال انتشار')
                        ->options(
                            range(1970, now()->addYears(6)->year) // از ۱۹۷۰ تا ۶ سال بعد
                        )
                        ->required()
                        ->columnSpan(1),
                    TextInput::make('language')->label('زبان')->required(),
                    TextInput::make('age_rating')->label('رده سنی')->required(),
                    FileUpload::make('poster')
                        ->label('پوستر')
                        ->image()
                        ->disk('filament')
                        ->directory('poster_series')
                        ->visibility('public')
                        ->required()
                        ->imagePreviewHeight('100')
                        ->maxSize(1000)
                        ->imageResizeMode('contain')
                        ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/webp']),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('عنوان')->searchable(),
                TextColumn::make('e_name')->label('نام انگلیسی')->searchable(),
                TextColumn::make('slug')->label('نشانی'),
                TextColumn::make('created_at')->label('تاریخ ایجاد')
                    ->formatStateUsing(fn($state) => (new Verta($state))->format('Y/m/d'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            SeasonsRelationManager::class,
            TrailersRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSeries::route('/'),
            'create' => Pages\CreateSeries::route('/create'),
            'edit' => Pages\EditSeries::route('/{record}/edit'),
        ];
    }
}
