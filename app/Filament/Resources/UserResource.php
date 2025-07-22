<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Usuários';
    protected static ?string $modelLabel = 'Usuário';
    protected static ?string $pluralModelLabel = 'Usuários';
    protected static ?int $navigationSort = 10;
    protected static ?string $navigationGroup = 'Administração';

    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dados do Usuário')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('password')
                            ->label('Senha')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->minLength(8)
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                            ->helperText('Deixe em branco para manter a senha atual'),

                        Forms\Components\Select::make('role')
                            ->label('Função')
                            ->options([
                                'admin' => 'Administrador',
                                'organizador' => 'Organizador', 
                                'visualizador' => 'Visualizador',
                            ])
                            ->required()
                            ->default('visualizador'),

                        Forms\Components\Toggle::make('ativo')
                            ->label('Usuário Ativo')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                Tables\Columns\BadgeColumn::make('role')
                    ->label('Função')
                    ->colors([
                        'danger' => 'admin',
                        'warning' => 'organizador',
                        'success' => 'visualizador',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'admin' => 'Administrador',
                        'organizador' => 'Organizador',
                        'visualizador' => 'Visualizador',
                        default => 'Indefinido',
                    }),

                Tables\Columns\IconColumn::make('ativo')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Função')
                    ->options([
                        'admin' => 'Administrador',
                        'organizador' => 'Organizador',
                        'visualizador' => 'Visualizador',
                    ]),

                Tables\Filters\Filter::make('ativo')
                    ->label('Apenas Ativos')
                    ->query(fn ($query) => $query->where('ativo', true))
                    ->default(),
            ])
            ->actions([
                Tables\Actions\Action::make('toggle_status')
                    ->label(fn (User $record) => $record->ativo ? 'Desativar' : 'Ativar')
                    ->icon(fn (User $record) => $record->ativo ? 'heroicon-o-lock-closed' : 'heroicon-o-lock-open')
                    ->color(fn (User $record) => $record->ativo ? 'danger' : 'success')
                    ->action(function (User $record) {
                        $record->update(['ativo' => !$record->ativo]);
                    })
                    ->requiresConfirmation()
                    ->visible(fn (User $record) => $record->id !== auth()->id()),

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn (User $record) => $record->id !== auth()->id()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    // ===== SEM PÁGINAS SEPARADAS - USA O MODAL PADRÃO =====
    public static function getPages(): array
    {
        return [];
    }
}
