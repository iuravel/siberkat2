<?php

namespace App\Filament\Resources\GapokAsnResource\Pages;

use App\Filament\Resources\GapokAsnResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGapokAsn extends ViewRecord
{
    protected static string $resource = GapokAsnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
