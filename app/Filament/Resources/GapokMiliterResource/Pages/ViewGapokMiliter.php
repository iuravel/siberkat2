<?php

namespace App\Filament\Resources\GapokMiliterResource\Pages;

use App\Filament\Resources\GapokMiliterResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGapokMiliter extends ViewRecord
{
    protected static string $resource = GapokMiliterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
