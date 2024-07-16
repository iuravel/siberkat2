<?php

namespace App\Filament\Resources\KorpResource\Pages;

use App\Filament\Resources\KorpResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKorp extends EditRecord
{
    protected static string $resource = KorpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
