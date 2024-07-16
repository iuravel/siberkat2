<?php

namespace App\Filament\Resources\GajiBerkalaAsnResource\Pages;

use App\Filament\Resources\GajiBerkalaAsnResource;
use App\Imports\GajiBerkalaAsnImport;
use App\Imports\GapokAsnImport;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ListGajiBerkalaAsn extends ListRecords
{
    protected static string $resource = GajiBerkalaAsnResource::class;

    protected function getHeaderActions(): array
    {
        return [
             Actions\CreateAction::make(),
            // Action::make('importGajiBerkalaAsn')
            // ->label('Import')
            // ->slideOver()
            // ->form([
            //     FileUpload::make('lampiran')
            // ])
            // ->action(function (array $data) {
            //     DB::table('gaji_berkala_asn')->truncate();
            //     $file = public_path('storage/'.$data['lampiran']);
            //     Excel::import(new GajiBerkalaAsnImport, $file);
            //     \Filament\Notifications\Notification::make()
            //         ->title('Data berhasil diimpor.')
            //         ->success()
            //         ->send();
            // }),
            
            //Export
            // Action::make('exportGapokAsn')
            // ->label('Export')
            // ->form([
            //     ToggleButtons::make('download')
            // ])
            // ->action(function (array $data) {
            //     \Filament\Notifications\Notification::make()
            //         ->title('Data berhasil diexport.')
            //         ->success()
            //         ->send();
            //     return new GapokAsnExport();
            // })->modalHidden(),

        ];
    }
}
