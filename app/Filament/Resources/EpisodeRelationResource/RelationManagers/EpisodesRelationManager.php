<?php

namespace App\Filament\Resources\EpisodeRelationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EpisodesRelationManager extends RelationManager
{
    protected static string $relationship = 'episodes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('اطلاعات قسمت')
                    ->schema([
                        TextInput::make('title')->label('عنوان')->required(),
                        TextInput::make('episode_number')
                            ->label('عدد قسمت')
                            ->numeric()
                            ->type('number')
                            ->minValue(0)
                            ->required()
                            ->columnSpan(1),
                        TextInput::make('runtime')
                            ->numeric()
                            ->label('مدت زمان')
                            ->suffix('دقیقه')
                            ->required(),
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
                                if ($record && $record->episode_url) {
                                    $component->state('url');
                                } // اگر رکورد وجود دارد و movie_file مقدار دارد
                                elseif ($record && $record->episode_file) {
                                    $component->state('file');
                                }
                            }),

                        TextInput::make('episode_url')
                            ->label('لینک قسمت')
                            ->visible(fn($get) => $get('source_type') === 'url')
                            ->nullable(),

                        FileUpload::make('episode_file')
                            ->label('اپلود قسمت')
                            ->visible(fn($get) => $get('source_type') === 'file')
                            ->disk('filament')
                            ->directory('series_episode')
                            ->nullable()
                            ->dehydrated(fn($state) => $state !== null),
                    ])->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('episode_number')
            ->columns([
                TextColumn::make('season.series.title')
                    ->label('نام سریال')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('season.season_number')
                    ->label('شماره فصل')
                    ->sortable(),
                TextColumn::make('title')->label('عنوان')->searchable(),
                TextColumn::make('episode_number')->label('شماره قسمت'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
