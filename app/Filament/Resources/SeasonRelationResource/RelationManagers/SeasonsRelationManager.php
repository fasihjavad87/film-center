<?php

namespace App\Filament\Resources\SeasonRelationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SeasonsRelationManager extends RelationManager
{
    protected static string $relationship = 'seasons';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->label('عنوان')->required(),
                TextInput::make('season_number')
                    ->label('عدد فصل')
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
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('season_number')
            ->columns([
                TextColumn::make('title')->label('عنوان')->searchable(),
                TextColumn::make('season_number')->label('عدد فصل'),
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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Action::make('editInResource')
                    ->label('ویرایش کامل')
                    ->icon('heroicon-o-pencil-square')
                    ->url(fn ($record) => route('filament.admin.resources.seasons.edit', ['record' => $record->id]))
                    ->openUrlInNewTab(),
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
