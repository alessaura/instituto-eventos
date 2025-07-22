<?php

namespace App\Filament\Resources\ParticipacaoResource\Pages;

use App\Filament\Resources\ParticipacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageParticipacoes extends ManageRecords 
{
    protected static string $resource = ParticipacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
