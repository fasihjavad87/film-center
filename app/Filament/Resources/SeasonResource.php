<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EpisodeRelationResource\RelationManagers\EpisodesRelationManager;
use App\Filament\Resources\SeasonResource\Pages;
use App\Filament\Resources\SeasonResource\RelationManagers;
use App\Models\Season;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SeasonResource extends Resource
{
    protected static ?string $model = Season::class;

    protected static ?string $navigationLabel = 'فصل ها';
    protected static ?string $pluralModelLabel = 'فصل ها';
    protected static ?string $modelLabel = 'فصل';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('اطلاعات فصل')
                    ->schema([
                        Select::make('series_id')
                            ->label('سریال')
                            ->relationship('series', 'title')
                            ->searchable()
                            ->visible(fn (Component $component) =>
                            ! str($component->getContainer()->getLivewire()::class)->contains('RelationManagers')
                            )
                            ->required(fn (Component $component) =>
                                $component->getContainer()->getLivewire() instanceof CreateRecord
                            ),
                        TextInput::make('title')->label('عنوان')->required(),
                        TextInput::make('season_number')
                            ->label('شماره فصل')
                            ->numeric()
                            ->type('number')
                            ->minValue(0)
                            ->required()
                            ->columnSpan(1),
                        textarea::make('description')
                            ->label('توضیحات')
                            ->required(),
                        Select::make('status')
                            ->label('وضعیت')
                            ->options([
                                'ongoing' => 'در حال پخش',
                                'ended' => 'پایان یافته',
                            ])
                            ->default('ongoing')
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('series.title')
                    ->label('نام سریال')
                    ->searchable(),
                TextColumn::make('title')->label('عنوان')->searchable(),
                TextColumn::make('season_number')->label('شماره فصل'),
                TextColumn::make('status')
                    ->badge()
                    ->label('وضعیت')
                    ->formatStateUsing(fn($state, $record) => $record->statusLabel())
                    ->color(fn(string $state): string => match ($state) {
                        'ended' => 'success',
                        'ongoing' => 'warning',
                        default => 'secondary'
                    }),
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
            EpisodesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSeasons::route('/'),
            'create' => Pages\CreateSeason::route('/create'),
            'edit' => Pages\EditSeason::route('/{record}/edit'),
        ];
    }
}
