<?php

namespace App\Filament\Resources\GajiBerkalaMiliterResource\Pages;

use App\Filament\Resources\GajiBerkalaMiliterResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\EditRecord;

class EditGajiBerkalaMiliter extends EditRecord
{
    protected static string $resource = GajiBerkalaMiliterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Batal')
                ->url(fn (): string => route('filament.siberkat.resources.kgb-militer.index')),
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    
}
