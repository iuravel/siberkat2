<?php

namespace App\Filament\Resources\GajiBerkalaAsnResource\Pages;

use App\Filament\Resources\GajiBerkalaAsnResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditGajiBerkalaAsn extends EditRecord
{
    protected static string $resource = GajiBerkalaAsnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Batal')
                ->url(fn (): string => route('filament.siberkat.resources.kgb-asn.index')),
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
