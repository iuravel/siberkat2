<?php

namespace App\Filament\Resources\GajiBerkalaMiliterResource\Pages;

use App\Exports\GajiBerkalaMiliterExport;
use App\Filament\Resources\GajiBerkalaMiliterResource;
use App\Imports\GajiBerkalaMiliterImport;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ListGajiBerkalaMiliter extends ListRecords
{
    protected static string $resource = GajiBerkalaMiliterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('importGajiBerkalaMiliter')
            ->label('Import')
            ->slideOver()
            ->form([
                FileUpload::make('lampiran2')
            ])
            ->action(function (array $data) {
                
                DB::table('gaji_berkala_militer')->truncate();
                $file = public_path('storage/'.$data['lampiran2']);
                Excel::import(new GajiBerkalaMiliterImport, $file);
                \Filament\Notifications\Notification::make()
                    ->title('Data berhasil diimpor.')
                    ->success()
                    ->send();
            }),
            
            //Export
            Action::make('exportGajiBerkalaMiliter')
            ->label('Export')
            ->form([
                ToggleButtons::make('download')
            ])
            ->action(function (array $data) {
                \Filament\Notifications\Notification::make()
                    ->title('Data berhasil diexport.')
                    ->success()
                    ->send();
                
                return new GajiBerkalaMiliterExport();
            })->modalHidden(),
        ];
    }
}
