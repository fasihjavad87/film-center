<?php

namespace App\Filament\Resources;

use App\Enums\UserStatus;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'کاربران';
    protected static ?string $pluralModelLabel = 'کاربران';
    protected static ?string $modelLabel = 'کاربر';
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([

                TextInput::make('name')
                    ->label('نام')
                    ->required(),

                TextInput::make('email')
                    ->label('ایمیل')
                    ->email()
                    ->required()
                    ->unique(User::class, 'email', ignoreRecord: true),

                Select::make('status')
                    ->label('وضعیت')
                    ->options(collect(UserStatus::cases())->mapWithKeys(fn($case) => [
                        $case->value => $case->label()
                    ]))
                    ->required(),

                Toggle::make('is_admin')
                    ->label('ادمین؟')
                    ->inline(false),


                TextInput::make('password')
                    ->label('رمز عبور')
                    ->password()
                    ->nullable()
                    ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                    ->dehydrated(fn($state, $get) => filled($state) || $get('remove_password')),

                Toggle::make('remove_password')
                    ->label('رمز عبور حذف شود؟')
                    ->inline(false)
                    ->reactive()
                    ->afterStateUpdated(fn($state, $set) => $state ? $set('password', null) : null),

                FileUpload::make('avatar')
                    ->label('تصویر')
                    ->image()
                    ->disk('filament')
                    ->directory('avatars')
                    ->visibility('public')
                    ->imagePreviewHeight('100')
                    ->maxSize(700)
                    ->imageResizeMode('contain')
                    ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg']),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')->label('تصویر')->disk('filament')->circular(),
                TextColumn::make('name')->label('نام')->searchable(),
                TextColumn::make('email')->label('ایمیل')->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->label('وضعیت')
                    ->formatStateUsing(fn($state, $record) => $record->statusLabel())
                    ->color(fn(string $state): string => match ($state) {
                        'verified' => 'info',
                        'unverified' => 'warning',
                        'active' => 'success',
                        'banned' => 'danger',
                        default => 'secondary'
                    }),
                TextColumn::make('is_admin')
                    ->label('نقش')
                    ->badge()
                    ->formatStateUsing(fn($state, $record) => $record->roleLabel())
                    ->color(fn($state) => match ((int)$state) {
                        1 => 'success',   // ادمین → سبز
                        0 => 'info',      // کاربر → آبی
                        default => 'secondary'
                    }),
                TextColumn::make('created_at')
                    ->label('تاریخ ثبت‌نام')
                    ->formatStateUsing(fn($state) => (new Verta($state))->format('Y/m/d'))
                    ->sortable(),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(), // حذف کامل از دیتابیس
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
