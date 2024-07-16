<?php

namespace App\Filament\Resources\GapokMiliterResource\Pages;

use App\Exports\GapokMiliterExport;
use App\Filament\Resources\GapokMiliterResource;
use App\Imports\GapokMiliterImport;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\Exports\Downloaders\Contracts\Downloader;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\ButtonAction;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ListGapokMiliter extends ListRecords
{
    protected static string $resource = GapokMiliterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            //Import
            Action::make('importGapokMiliter')
                ->label('Import')
                ->slideOver()
                ->form([
                    FileUpload::make('lampiran')
                ])
                ->action(function (array $data) {
                    DB::table('gapok_militer')->truncate();
                    $file = public_path('storage/'.$data['lampiran']);
                    Excel::import(new GapokMiliterImport, $file);
                    \Filament\Notifications\Notification::make()
                        ->title('Data berhasil diimpor.')
                        ->success()
                        ->send();
                }),
            //Export
            Action::make('exportGapokMiliter')
            ->label('Export')
            ->form([
                ToggleButtons::make('download')
            ])
            ->action(function (array $data) {
                \Filament\Notifications\Notification::make()
                    ->title('Data berhasil diexport.')
                    ->success()
                    ->send();
                return new GapokMiliterExport();
            })
            ->modalHidden(),
        ];
    }
}
