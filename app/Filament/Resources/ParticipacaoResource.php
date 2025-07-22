<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParticipacaoResource\Pages;
use App\Models\Participacao;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ParticipacaoResource extends Resource
{
    protected static ?string $model = Participacao::class;
    protected static ?string $navigationIcon = 'heroicon-o-check-badge';
    protected static ?string $navigationLabel = 'Participações';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('evento_id')
                    ->relationship('evento', 'nome')
                    ->required(),
                Forms\Components\Select::make('pessoa_id')
                    ->relationship('pessoa', 'nome')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'inscrito' => 'Inscrito',
                        'presente' => 'Presente',
                        'ausente' => 'Ausente',
                    ])
                    ->default('inscrito'),
                Forms\Components\DateTimePicker::make('data_inscricao')
                    ->default(now()),
                Forms\Components\DateTimePicker::make('data_participacao'),
                Forms\Components\Textarea::make('observacoes'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pessoa.nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('evento.nome')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status'),
                Tables\Columns\TextColumn::make('data_inscricao')
                    ->dateTime('d/m/Y H:i'),
                Tables\Columns\TextColumn::make('data_participacao')
                    ->dateTime('d/m/Y H:i'),
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
            'index' => Pages\ManageParticipacoes::route('/'),
        ];
    }
}