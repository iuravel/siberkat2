<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GajiBerkalaMiliterResource\Pages;
use App\Models\GajiBerkalaMiliter;
use App\Models\GapokMiliter;
use App\Models\JenisKelamin;
use App\Models\Korp;
use App\Models\Pangkat;;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;

class GajiBerkalaMiliterResource extends Resource
{
    protected static ?string $model = GajiBerkalaMiliter::class;

    protected static ?string $slug = 'kgb-militer';
    protected static ?string $navigationGroup = 'Kenaikan Gaji Berkala';
    protected static ?string $modelLabel = 'KGB Militer';  
    protected static ?string $navigationLabel = 'KGB MILITER';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
//start schema
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    Grid::make(['default' => 1,'sm' => 2,'md' => 3,'lg' => 4,'xl' => 6,'2xl' => 8,]), //set default
                    Section::make('Data Personel')
                    ->columnSpanFull()
                    ->id('dataPersonel')
                    ->iconColor('info')
                    ->icon('heroicon-m-user')
                    ->schema([
                        Grid::make(6)->schema([
                            TextInput::make('nama')->label('Nama')->maxLength(255)->required()
                            ->columnSpan(2),
                            TextInput::make('nrp')->label('NRP')->mask('9999999999999999999999999')->required()
                            ->columnSpan(2),
                        ]),
                        Grid::make(6)->schema([
                            Radio::make('jenis_kelamin_id')->label('Jenis Kelamin')->inline()->inlineLabel(false)
                            ->options(JenisKelamin::all()->pluck('nama', 'id'))->required()
                            ->columnSpan(2),
                            DatePicker::make('tanggal_lahir')->label('Tanggal Lahir')->prefixIcon('heroicon-m-calendar')->native(false)->displayFormat('d-m-Y')
                            ->columnSpan(2)
                        ]),
                        Grid::make(6)->schema([
                            DatePicker::make('tmt_tni')->label('TMT TNI')->prefixIcon('heroicon-m-calendar')->displayFormat('d-m-Y')->native(false)->required()
                            ->columnSpan(2),
                            DatePicker::make('tmt_pangkat')->required()->label('TMT Pangkat')->prefixIcon('heroicon-m-calendar')->displayFormat('d-m-Y')->native(false)->required()
                            ->columnSpan(2),
                            Select::make('korp_id')->label('Korp')->placeholder('')->searchable()
                            //->relationship(name: 'korp', titleAttribute: 'nama')->native(false)->preload()
                            ->options(Korp::query()->orderBy('id','asc')->pluck('nama', 'id'))
                            ->columnSpan(1)
                        ]),
                        Grid::make(6)->schema([
                            TextInput::make('jabatan')->label('Jabatan')->maxLength(255)
                            ->columnSpan(4),
                            TextInput::make('kesatuan')->label('Kesatuan')->maxLength(255)->default('Paldam III/Slw')->readOnly()
                            ->columnSpan(2)
                        ])
                    ]),
    
                    Section::make('Keadaan Lama')
                        ->columnSpanFull()
                        ->id('keadaanLama')
                        ->icon('heroicon-m-battery-50')
                        ->iconColor('warning')
                        ->collapsible()
                        //->collapsed()
                        ->schema (
                            [
                            Grid::make(6)->schema([
                                Select::make('pangkat_lama_id')->label('Pangkat Lama')->placeholder('')->searchable()
                                ->options(Pangkat::query()->orderBy('id','asc')->pluck('nama', 'id'))
                                ->columnSpan(2)
                                ->live()
                                ]),
                            Grid::make(6)->schema([
                                TextInput::make('tahun_mks_lama')->label('M K S')->maxLength(255)->integer()->mask('99')->suffix('Thn')
                                    ->extraAttributes(['style'=>'border-top-right-radius:0!important;border-bottom-right-radius:0!important;padding-right:0!important;margin-right:-10px!important;'])
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set, Get $get) {
                                        $result = GapokMiliter::where('masa_kerja', $state)->where('pangkat_id', $get('pangkat_lama_id'))->first();
                                        $gaji = $result ? $result->gaji : null;
                                        $set('gaji_pokok_lama', $gaji);
                                    })
////////////???????????????????????????????????
                                    ->columnSpan(1),
                                TextInput::make('bulan_mks_lama')->label(',')->maxLength(255)->integer()->mask('99')->suffix('Bln')
                                    ->extraAttributes(['style'=>'border-top-left-radius:0;border-bottom-left-radius:0;padding-left:0!important;margin-left:-10px!important;'])
                                    ->columnSpan(1),
                                TextInput::make('tahun_mkg_lama')->label('MKG')->maxLength(255)->integer()->mask('99')->suffix('Thn')
                                    ->extraAttributes(['style'=>'border-top-right-radius:0!important;border-bottom-right-radius:0!important;padding-right:0!important;margin-right:-10px!important;'])
                                    ->columnSpan(1),
                                TextInput::make('bulan_mkg_lama')->label(',')->maxLength(255)->integer()->mask('99')->suffix('Bln')
                                    ->extraAttributes(['style'=>'border-top-left-radius:0;border-bottom-left-radius:0;padding-left:0!important;margin-left:-10px!important;'])
                                    ->columnSpan(1),
                                TextInput::make('gaji_pokok_lama')->label('Gaji Pokok')->maxLength(255)->integer()->mask('9999999999999999999999999')
                                    ->columnSpan(2)
                                    ->live()
                                ]),
                            Grid::make(6)->schema([
                                DatePicker::make('tmt_kgb_lama')->label('TMT Berlaku')->prefixIcon('heroicon-m-calendar')->native(false)->displayFormat('d-m-Y')
                                    ->columnSpan(2),
                                DatePicker::make('tmt_kgb_yad_lama')->label('TMT Y.A.D')->prefixIcon('heroicon-m-calendar')->native(false)->displayFormat('d-m-Y')
                                    ->columnSpan(2)
                                ])
                            ]
                        ),
    
                    Section::make('Keadaan Baru')
                        ->columnSpanFull()
                        ->id('keadaanBaru')
                        ->iconColor('success')
                        ->icon('heroicon-m-battery-100')
                        ->collapsible()
                        //->collapsed()
                        ->schema([
                            Grid::make(6)->schema([
                                Select::make('pangkat_baru_id')->label('Pangkat Baru')->placeholder('')->searchable()
                                //->relationship(name: 'gapokMiliter.pangkat', titleAttribute: 'nama')
                                ->options(Pangkat::query()->orderBy('id','asc')->pluck('nama', 'id'))
                                ->columnSpan(2),
                            ]),
                            Grid::make(6)->schema([
                                TextInput::make('tahun_mks_baru')->label('M K S')->maxLength(255)->integer()->mask('99')->suffix('Thn')
                                    ->extraAttributes(['style'=>'border-top-right-radius:0!important;border-bottom-right-radius:0!important;padding-right:0!important;margin-right:-10px!important;'])
                                    ->columnSpan(1),
                                TextInput::make('bulan_mks_baru')->label(',')->maxLength(255)->integer()->mask('99')->suffix('Bln')
                                    ->extraAttributes(['style'=>'border-top-left-radius:0;border-bottom-left-radius:0;padding-left:0!important;margin-left:-10px!important;'])
                                    ->columnSpan(1),
                                TextInput::make('tahun_mkg_baru')->label('M K G')->maxLength(255)->integer()->mask('99')->suffix('Thn')
                                    ->extraAttributes(['style'=>'border-top-right-radius:0!important;border-bottom-right-radius:0!important;padding-right:0!important;margin-right:-10px!important;'])
                                    ->columnSpan(1),
                                TextInput::make('bulan_mkg_baru')->label(',')->maxLength(255)->integer()->mask('99')->suffix('Bln')
                                    ->extraAttributes(['style'=>'border-top-left-radius:0;border-bottom-left-radius:0;padding-left:0!important;margin-left:-10px!important;'])
                                    ->columnSpan(1),
                                TextInput::make('gaji_pokok_baru')->label('Gaji Pokok')->maxLength(255)->integer()->mask('9999999999999999999999999')
                                    ->columnSpan(2)
                            ]),
                            Grid::make(6)->schema([
                                DatePicker::make('tmt_kgb_baru')->label('TMT Berlaku')->prefixIcon('heroicon-m-calendar')->native(false)->displayFormat('d-m-Y')
                                    ->columnSpan(2),
                                DatePicker::make('tmt_kgb_yad_baru')->label('TMT Y.A.D')->prefixIcon('heroicon-m-calendar')->native(false)->displayFormat('d-m-Y')
                                    ->columnSpan(2)
                            ]),
                            Grid::make(6)->schema([
                                DatePicker::make('tanggal_terbit')->label('Tanggal Terbit Surat')->prefixIcon('heroicon-m-calendar')->native(false)->displayFormat('d-m-Y')->default(now())
                                    ->columnSpan(2),
                                Textarea::make('keterangan')->label('Keterangan')
                                    ->columnSpan(4)
                            ])
                    ]),
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                ]); //end schema
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->emptyStateIcon('heroicon-o-bookmark')
            ->emptyStateHeading('No posts yet')
            ->actions([], position: ActionsPosition::BeforeColumns)
            ->columns([
                ColumnGroup::make('PERSONEL', [
                    TextColumn::make('nama')->label('NAMA')->weight(FontWeight::Bold)->searchable()->sortable(),
                    TextColumn::make('nrp')->label('NRP'),
                    //TextColumn::make('jenisKelamin.nama')->label('JK')->sortable(),
                    TextColumn::make('jabatan')->label('JABATAN')->searchable()->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('kesatuan')->label('KESATUAN')->searchable()->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('tanggal_lahir')->date('d-m-Y')->label('TGL LAHIR')->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('tmt_tni')->date('d-m-Y')->label('TMT TNI')->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('tmt_pangkat')->date('d-m-Y')->label('TMT PKT')->toggleable(isToggledHiddenByDefault: true),
                ])->alignment(Alignment::Center),
                ColumnGroup::make('KEADAAN LAMA', [
                    TextColumn::make('pangkat_lama_id')->label('Pangkat')
                    ->formatStateUsing(function ($record) {
                        $is_kowad = ($record->jenis_kelamin_id == 2) ? '(K)' : null;
                        $korp = (isset($record->korp_id)) ? ' '.$record->korp->nama : null;
                        return $record->pangkatLama->nama .' '.$is_kowad.''.$korp;
                    })->sortable(),
                    TextColumn::make('full_mks_lama')->label('MKS')
                    ->formatStateUsing(fn ($record) => "{$record->tahun_mks_lama}".' Thn, '."{$record->tahun_mks_lama}".' Bln'),
                    TextColumn::make('full_mkg_lama')->label('MKG')
                        ->formatStateUsing(fn ($record) => "{$record->tahun_mkg_lama}".' Thn, '."{$record->tahun_mkg_lama}".' Bln'),
                    TextColumn::make('gaji_pokok_lama')->label('GAJI POKOK')
                        ->numeric(),
                    TextColumn::make('tmt_kgb_lama')->label('TMT KGB')
                        ->date('d-m-Y')->date('d-m-Y')->toggleable(isToggledHiddenByDefault: false)
                        ->sortable(),
                    TextColumn::make('tmt_kgb_yad_lama')->label('TMT YAD')
                        ->date('d-m-Y')->date('d-m-Y')->toggleable(isToggledHiddenByDefault: false)
                        ->sortable(),
                ])->alignment(Alignment::Center),
                
                ColumnGroup::make('KEADAAN BARU', [
                    TextColumn::make('pangkatBaru.nama')->label('PANGKAT')
                        ->formatStateUsing(function ($record) {
                            $is_kowad = ($record->jenis_kelamin_id == 2) ? '(K)' : null;
                            $korp = (isset($record->korp_id)) ? ' '.$record->korp->nama : null;
                            return $record->pangkatBaru->nama .' '.$is_kowad.''.$korp;
                        })
                        ->sortable(),
                    TextColumn::make('full_mks_baru')->label('MKS')
                        ->formatStateUsing(fn ($record) => "{$record->tahun_mks_baru}".' Thn, '."{$record->bulan_mks_baru}".' Bln'),
                    TextColumn::make('full_mkg_baru')->label('MKG')
                            ->formatStateUsing(fn ($record) => "{$record->tahun_mkg_baru}".' Thn, '."{$record->bulan_mkg_baru}".' Bln'),
                    TextColumn::make('gaji_pokok_baru')->label('GAJI POKOK')
                        ->numeric(),
                    TextColumn::make('tmt_kgb_baru')->label('TMT KGB')
                        ->date('d-m-Y')->date('d-m-Y')->toggleable(isToggledHiddenByDefault: FALSE)
                        ->sortable(),
                    TextColumn::make('tmt_kgb_yad_baru')->label('TMT YAD')
                        ->date('d-m-Y')->date('d-m-Y')->toggleable(isToggledHiddenByDefault: FALSE)
                        ->sortable(),
                    TextColumn::make('keterangan')->label('KET')->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('tanggal_terbit')->label('TGL SURAT')->date('d-m-Y')->toggleable(isToggledHiddenByDefault: true),
                ])->alignment(Alignment::Center),
                
                
                // Tables\Columns\TextColumn::make('deleted_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGajiBerkalaMiliter::route('/'),
            'create' => Pages\CreateGajiBerkalaMiliter::route('/create'),
            'view' => Pages\ViewGajiBerkalaMiliter::route('/{record}'),
            'edit' => Pages\EditGajiBerkalaMiliter::route('/{record}/edit'),
        ];
    }
    // public static function infolist(Infolist $infolist): Infolist
    // {
    //     return $infolist
    //         ->schema([
    //             TextEntry::make('nama'),
    //             TextEntry::make('nrp'),
    //         ]);
    // }
    
    
}
