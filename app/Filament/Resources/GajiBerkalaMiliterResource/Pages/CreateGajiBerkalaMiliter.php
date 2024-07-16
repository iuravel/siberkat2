<?php

namespace App\Filament\Resources\GajiBerkalaMiliterResource\Pages;

use App\Filament\Resources\GajiBerkalaMiliterResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateGajiBerkalaMiliter extends CreateRecord
{
    protected static string $resource = GajiBerkalaMiliterResource::class;
    //protected static bool $canCreateAnother = false;

    // protected function getCreateFormAction(): Action
    // {
    //     return Action::make('create')
    //         ->label(__('filament-panels::'))
    //         ->submit('create')
    //         ->keyBindings(['mod+s']);
    // }

}