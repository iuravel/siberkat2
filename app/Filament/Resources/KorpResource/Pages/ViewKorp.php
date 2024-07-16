<?php

namespace App\Filament\Resources\KorpResource\Pages;

use App\Filament\Resources\KorpResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewKorp extends ViewRecord
{
    protected static string $resource = KorpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
