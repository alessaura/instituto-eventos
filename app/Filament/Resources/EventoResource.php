<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventoResource\Pages;
use App\Models\Evento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EventoResource extends Resource
{
    protected static ?string $model = Evento::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Eventos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('descricao'),
                Forms\Components\DatePicker::make('data_evento')
                    ->required(),
                Forms\Components\TextInput::make('local'),
                Forms\Components\Select::make('status')
                    ->options([
                        'ativo' => 'Ativo',
                        'finalizado' => 'Finalizado',
                        'cancelado' => 'Cancelado',
                    ])
                    ->default('ativo'),
                Forms\Components\Select::make('tipo_evento')
                    ->options([
                        'presencial' => 'Presencial',
                        'online' => 'Online',
                        'hibrido' => 'Híbrido',
                    ])
                    ->default('presencial'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('data_evento')
                    ->date('d/m/Y'),
                Tables\Columns\TextColumn::make('local')
                    ->limit(30),
                Tables\Columns\BadgeColumn::make('status'),
                Tables\Columns\TextColumn::make('participacoes_count')
                    ->label('Inscritos')
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
            'index' => Pages\ManageEventos::route('/'),
        ];
    }
}