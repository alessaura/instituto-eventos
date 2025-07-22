<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PessoaResource\Pages;
use App\Models\Pessoa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PessoaResource extends Resource
{
    protected static ?string $model = Pessoa::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Participantes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('telefone'),
                Forms\Components\TextInput::make('empresa'),
                Forms\Components\TextInput::make('cargo'),
                Forms\Components\TextInput::make('cidade'),
                Forms\Components\TextInput::make('estado')
                    ->maxLength(2),
                Forms\Components\Textarea::make('observacoes'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('empresa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telefone'),
                Tables\Columns\TextColumn::make('cidade'),
                Tables\Columns\TextColumn::make('participacoes_count')
                    ->label('Eventos')
                    ->getStateUsing(fn ($record) => $record->participacoes->count()),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePessoas::route('/'),
        ];
    }
}