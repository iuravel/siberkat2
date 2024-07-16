<?php

namespace App\Filament\Resources\GajiBerkalaMiliterResource\Pages;

use App\Filament\Resources\GajiBerkalaMiliterResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewGajiBerkalaMiliter extends ViewRecord
{
    protected static string $resource = GajiBerkalaMiliterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Kembali')->url(fn (): string => route('filament.siberkat.resources.kgb-militer.index')),
            Actions\EditAction::make(),
        ];
    }
}
