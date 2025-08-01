<?php

namespace App\Filament\Resources\TrailerRelationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrailersRelationManager extends RelationManager
{

    protected static ?string $navigationLabel = 'تیزر ها';
    protected static ?string $pluralModelLabel = 'تیزر ها';
    protected static ?string $modelLabel = 'تیزر';
    protected static string $relationship = 'trailers';

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')->label('عنوان تیزر'),

            Radio::make('source_type')
                ->label('نوع تیزر')
                ->options([
                    'url' => 'لینک ویدیو',
                    'file' => 'آپلود فایل',
                ])
                ->default('url')
                ->inline()
                ->required()
                ->live(),

            TextInput::make('video_url')
                ->label('لینک ویدیو')
                ->visible(fn($get) => $get('source_type') === 'url')
                ->nullable()
                ->hidden(fn ($get) => $get('source_type') !== 'url'),

            FileUpload::make('video_file_path')
                ->label('فایل تیزر')
                ->visible(fn($get) => $get('source_type') === 'file')
                ->hidden(fn ($get) => $get('source_type') !== 'file')
                ->disk('filament')
                ->directory('trailers')
                ->nullable(),

            TextInput::make('duration')->numeric()->label('مدت (ثانیه)'),
            TextInput::make('order')->numeric()->default(1)->label('ترتیب نمایش'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')->label('عنوان'),
                TextColumn::make('video_url')->label('لینک'),
                TextColumn::make('video_file_path')->label('فایل'),
                TextColumn::make('duration')->label('مدت'),
                TextColumn::make('order')->label('ترتیب'),
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
