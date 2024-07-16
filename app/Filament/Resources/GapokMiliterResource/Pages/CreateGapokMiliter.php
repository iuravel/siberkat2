<?php

namespace App\Filament\Resources\GapokMiliterResource\Pages;

use App\Filament\Resources\GapokMiliterResource;
use App\Models\GapokMiliter;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateGapokMiliter extends CreateRecord
{
    protected static string $resource = GapokMiliterResource::class;
    
}
