<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Tickets;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketResource extends Resource
{
    protected static ?string $model = Tickets::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'تیکت‌ها';


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('user.name')->label('کاربر')->searchable(),
                TextColumn::make('subject')->label('موضوع')->limit(40)->searchable(),
                BadgeColumn::make('status')->label('وضعیت')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'answered',
                        'danger'  => 'closed',
                        'primary' => 'open',
                    ])->sortable(),
                TextColumn::make('updated_at')->label('بروزرسانی')->since()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'open'     => 'باز',
                        'pending'  => 'درحال بررسی',
                        'answered' => 'پاسخ داده‌شده',
                        'closed'   => 'بسته',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('چت'),  // لینک به صفحه چت
                Tables\Actions\Action::make('close')->label('بستن')
                    ->action(fn (Tickets $record) => $record->update(['status' => 'closed']))
                    ->requiresConfirmation()
                    ->visible(fn (Tickets $r) => $r->status !== 'closed'),
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
            'index' => Pages\ListTickets::route('/'),
            'view'  => Pages\ViewTicket::route('/{record}'),
        ];
    }
}
