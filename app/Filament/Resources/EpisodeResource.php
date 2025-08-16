<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EpisodeResource\Pages;
use App\Filament\Resources\EpisodeResource\RelationManagers;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EpisodeResource extends Resource
{
    protected static ?string $model = Episode::class;

    protected static ?string $navigationLabel = 'قسمت ها';
    protected static ?string $pluralModelLabel = 'قسمت ها';
    protected static ?string $modelLabel = 'قسمت';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('اطلاعات سریال و فصل')
                    ->schema([
                        Select::make('series_id')
                            ->label('سریال')
                            ->options(fn() => \App\Models\Series::pluck('title', 'id'))
                            ->reactive()
                            ->required(fn() => request()->routeIs('filament.admin.resources.episodes.create'))
//                            ->visible(fn() => request()->routeIs('filament.admin.resources.episodes.create'))
                            ->disabled(fn() => request()->routeIs('filament.admin.resources.episodes.edit')),

                        Select::make('season_id')
                            ->label('فصل')
                            ->options(fn($get) => \App\Models\Season::where('series_id', $get('series_id'))
                                ->pluck('season_number', 'id')
                            )
                            ->required()
                            ->reactive()
                            ->required(fn() => request()->routeIs('filament.admin.resources.episodes.create'))
//                            ->visible(fn() => request()->routeIs('filament.admin.resources.episodes.create'))
                            ->disabled(fn() => request()->routeIs('filament.admin.resources.episodes.edit')),

                    ])->columns(2),
                Section::make('اطلاعات قسمت')
                    ->schema([
                        TextInput::make('title')->label('عنوان')->required(),
                        TextInput::make('episode_number')
                            ->label('شماره قسمت')
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
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEpisodes::route('/'),
            'create' => Pages\CreateEpisode::route('/create'),
            'edit' => Pages\EditEpisode::route('/{record}/edit'),
        ];
    }
}
