<?php

namespace App\Filament\Resources\GapokAsnResource\Pages;

use App\Exports\GapokAsnExport;
use App\Filament\Resources\GapokAsnResource;
use App\Imports\GapokAsnImport;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ListGapokAsn extends ListRecords
{
    protected static string $resource = GapokAsnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('importGapokAsn')
            ->label('Import')
            ->slideOver()
            ->form([
                FileUpload::make('lampiran')
            ])
            ->action(function (array $data) {
                DB::table('gapok_asn')->truncate();
                $file = public_path('storage/'.$data['lampiran']);
                Excel::import(new GapokAsnImport, $file);
                \Filament\Notifications\Notification::make()
                    ->title('Data berhasil diimpor.')
                    ->success()
                    ->send();
            }),
            
            //Export
            Action::make('exportGapokAsn')
            ->label('Export')
            ->form([
                ToggleButtons::make('download')
            ])
            ->action(function (array $data) {
                \Filament\Notifications\Notification::make()
                    ->title('Data berhasil diexport.')
                    ->success()
                    ->send();
                return new GapokAsnExport();
            })->modalHidden(),

        ];
    }
}
