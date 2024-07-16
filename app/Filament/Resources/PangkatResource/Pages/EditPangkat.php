<?php

namespace App\Filament\Resources\PangkatResource\Pages;

use App\Filament\Resources\PangkatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPangkat extends EditRecord
{
    protected static string $resource = PangkatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
