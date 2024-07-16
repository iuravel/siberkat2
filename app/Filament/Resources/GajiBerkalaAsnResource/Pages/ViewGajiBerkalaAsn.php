<?php

namespace App\Filament\Resources\GajiBerkalaAsnResource\Pages;

use App\Filament\Resources\GajiBerkalaAsnResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewGajiBerkalaAsn extends ViewRecord
{
    protected static string $resource = GajiBerkalaAsnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Kembali')
                ->url(fn (): string => route('filament.siberkat.resources.kgb-asn.index')),
            Actions\EditAction::make(),
        ];
    }
}
