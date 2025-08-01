<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovieResource\Pages;
use App\Filament\Resources\MovieResource\RelationManagers;
use App\Models\Movie;
use App\Models\Movies;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class MovieResource extends Resource
{
    protected static ?string $model = Movies::class;

    protected static ?string $navigationLabel = 'فیلم ها';
    protected static ?string $pluralModelLabel = 'فیلم ها';
    protected static ?string $modelLabel = 'فیلم';
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
                    Select::make('status')
                        ->label('وضعیت')
                        ->options([
                            'active' => 'فعال',
                            'inactive' => 'غیرفعال',
                        ])
                        ->default('active')
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
            Section::make('منبع فیلم')
                ->schema([
                    Radio::make('source_type')
                        ->label('نوع منبع')
                        ->options([
                            'url' => 'لینک',
                            'file' => 'آپلود فایل',
                        ])
                        ->default('url')
                        ->inline()
                        ->reactive()
                        ->afterStateHydrated(function (Radio $component, $state, $record) {
                            // اگر رکورد وجود دارد و movie_url مقدار دارد
                            if ($record && $record->movie_url) {
                                $component->state('url');
                            }
                            // اگر رکورد وجود دارد و movie_file مقدار دارد
                            elseif ($record && $record->movie_file) {
                                $component->state('file');
                            }
                        }),

                    TextInput::make('movie_url')
                        ->label('لینک فیلم')
                        ->visible(fn($get) => $get('source_type') === 'url')
                        ->nullable(),

                    FileUpload::make('movie_file')
                        ->label('آپلود فیلم')
                        ->visible(fn($get) => $get('source_type') === 'file')
                        ->disk('filament')
                        ->directory('movies')
                        ->nullable()
                        ->dehydrated(fn($state) => $state !== null),
                ]),

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
//                    TextInput::make('release_date')
//                        ->numeric()
//                        ->label('سال انتشار')
//                        ->required(),
//                    DatePicker::make('release_date')
//                        ->label('تاریخ انتشار')
//                        ->displayFormat('d/m/Y') // فرمت نمایش: 26/08/2024
//                        ->minDate(now()->setYear(1970)) // حداقل سال: 1970
//                        ->maxDate(now()->addYears(6))  // حداکثر سال: 10 سال بعد از امروز
//                        ->required()
//                        ->displayFormat('Y/m/d') // فرمت جدید: 2025/07/25
//                        ->format('Y-m-d') // فرمت ذخیره در دیتابیس (اختیاری)
//                        ->columnSpan(1),
                    Select::make('release_year')
                        ->label('سال انتشار')
                        ->options(
                            range(1970, now()->addYears(6)->year) // از ۱۹۷۰ تا ۶ سال بعد
                        )
                        ->required()
                        ->columnSpan(1),
                    TextInput::make('language')->label('زبان')->required(),
                    TextInput::make('runtime')
                        ->numeric()->label('مدت زمان')
                        ->suffix('دقیقه')
                        ->required(),
                    TextInput::make('age_rating')->label('رده سنی')->required(),
                    FileUpload::make('poster')
                        ->label('پوستر')
                        ->image()
                        ->disk('filament')
                        ->directory('poster_movies')
                        ->visibility('public')
                        ->required()
                        ->imagePreviewHeight('100')
                        ->maxSize(1000)
                        ->imageResizeMode('contain')
                        ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg' , 'image/webp' ]),
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
                TextColumn::make('status')
                    ->badge()
                    ->label('وضعیت')
                    ->formatStateUsing(fn($state, $record) => $record->statusLabel())
                    ->color(fn(string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        default => 'secondary'
                    }),
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
            \App\Filament\Resources\TrailerRelationResource\RelationManagers\TrailersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMovies::route('/'),
            'create' => Pages\CreateMovie::route('/create'),
            'edit' => Pages\EditMovie::route('/{record}/edit'),
        ];
    }
}
