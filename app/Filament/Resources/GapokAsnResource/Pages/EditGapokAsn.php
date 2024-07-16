<?php

namespace App\Filament\Resources\GapokAsnResource\Pages;

use App\Filament\Resources\GapokAsnResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGapokAsn extends EditRecord
{
    protected static string $resource = GapokAsnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
