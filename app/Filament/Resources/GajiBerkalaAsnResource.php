<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GajiBerkalaAsnResource\Pages;
use App\Filament\Resources\GajiBerkalaAsnResource\RelationManagers;
use App\Models\GajiBerkalaAsn;
use App\Models\GapokAsn;
use App\Models\Golongan;
use App\Models\JenisKelamin;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GajiBerkalaAsnResource extends Resource
{
    protected static ?string $model = GajiBerkalaAsn::class;

    protected static ?string $slug = 'kgb-asn';
    protected static ?string $navigationGroup = 'Kenaikan Gaji Berkala';
    protected static ?string $modelLabel = 'KGB ASN';  
    protected static ?string $navigationLabel = 'KGB ASN';
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
                            TextInput::make('nip')->label('nip')->integer()->mask('9999999999999999999999999')->required()
                            ->columnSpan(2),
                            TextInput::make('karpeg')->label('Karpeg')->maxLength(255)->required()
                            ->columnSpan(1)
                        ]),
                        Grid::make(6)->schema([
                            Radio::make('jenis_kelamin_id')->label('Jenis Kelamin')->inline()->inlineLabel(false)
                            ->options(JenisKelamin::all()->pluck('nama', 'id'))->required()
                            ->columnSpan(2),
                            TextInput::make('tempat_lahir')->label('Tempat Lahir')->maxLength(255)->required()
                            ->columnSpan(1),
                            DatePicker::make('tanggal_lahir')->label('Tanggal Lahir')->prefixIcon('heroicon-m-calendar')->native(false)->displayFormat('d-m-Y')->required()
                            ->columnSpan(2)
                        ]),
                        Grid::make(6)->schema([
                            DatePicker::make('tmt_cpns')->label('TMT CPNS')->prefixIcon('heroicon-m-calendar')->displayFormat('d-m-Y')->native(false)->required()
                            ->columnSpan(2),
                            DatePicker::make('tmt_golongan')->required()->label('TMT Golongan')->prefixIcon('heroicon-m-calendar')->displayFormat('d-m-Y')->native(false)->required()
                            ->columnSpan(2),
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
                            Select::make('golongan_lama_id')->label('Golongan')->placeholder('')->searchable()
                                ->options(Golongan::query()->orderBy('id','asc')->pluck('nama', 'id'))
                                ->columnSpan(2)
                                ->live(),
                            TextInput::make('skep_lama')->label('SKEP Terakhir')->maxLength(255)
                                ->columnSpan(2),
                            DatePicker::make('tmt_skep_lama')->label('TMT SKEP')->prefixIcon('heroicon-m-calendar')->native(false)->displayFormat('d-m-Y')
                                ->columnSpan(2),
                            ]),
                        Grid::make(6)->schema([
                            TextInput::make('tahun_mks_lama')->label('MKS')->maxLength(255)->integer()->mask('99')->suffix('Thn')
                                ->extraAttributes(['style'=>'border-top-right-radius:0!important;border-bottom-right-radius:0!important;padding-right:0!important;margin-right:-10px!important;'])
                                ->live()
                                ->afterStateUpdated(function ($state, callable $set, Get $get) {
                                    $result = GapokAsn::where('masa_kerja', $state)->where('golongan_id', $get('golongan_lama_id'))->first();
                                    $gaji = $result ? $result->gaji : null;
                                    $set('gaji_pokok_lama', $gaji);
                                })
////////////??????????????????????????????????? RUMUS
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
                            DatePicker::make('tmt_kgb_yad_lama')->label('TMT Y.A.D')->prefixIcon('heroicon-m-calendar')->native(false)->displayFormat('d-m-Y')
                                ->columnSpan(2)
                            ])
                        ]
                    ),


                    Section::make('Keadaan Baru')
                    ->columnSpanFull()
                    ->id('keadaanBaru')
                    ->icon('heroicon-m-battery-50')
                    ->iconColor('warning')
                    ->collapsible()
                    //->collapsed()
                    ->schema (
                        [
                        Grid::make(6)->schema([
                            Select::make('golongan_baru_id')->label('Golongan')->placeholder('')->searchable()
                                ->options(Golongan::query()->orderBy('id','asc')->pluck('nama', 'id'))
                                ->columnSpan(2)
                                ->live(),
                            TextInput::make('skep_baru')->label('SKEP Baru')->maxLength(255)
                                ->columnSpan(2),
                            DatePicker::make('tmt_skep_baru')->label('TMT SKEP')->prefixIcon('heroicon-m-calendar')->native(false)->displayFormat('d-m-Y')
                                ->columnSpan(2),
                            ]),
                        Grid::make(6)->schema([
                            TextInput::make('tahun_mks_baru')->label('MKS')->maxLength(255)->integer()->mask('99')->suffix('Thn')
                                ->extraAttributes(['style'=>'border-top-right-radius:0!important;border-bottom-right-radius:0!important;padding-right:0!important;margin-right:-10px!important;'])
                                ->live()
                                ->afterStateUpdated(function ($state, callable $set, Get $get) {
                                    $result = GapokAsn::where('masa_kerja', $state)->where('golongan_id', $get('golongan_baru_id'))->first();
                                    $gaji = $result ? $result->gaji : null;
                                    $set('gaji_pokok_baru', $gaji);
                                })
////////////??????????????????????????????????? RUMUS
                                ->columnSpan(1),
                            TextInput::make('bulan_mks_baru')->label(',')->maxLength(255)->integer()->mask('99')->suffix('Bln')
                                ->extraAttributes(['style'=>'border-top-left-radius:0;border-bottom-left-radius:0;padding-left:0!important;margin-left:-10px!important;'])
                                ->columnSpan(1),
                            TextInput::make('tahun_mkg_baru')->label('MKG')->maxLength(255)->integer()->mask('99')->suffix('Thn')
                                ->extraAttributes(['style'=>'border-top-right-radius:0!important;border-bottom-right-radius:0!important;padding-right:0!important;margin-right:-10px!important;'])
                                ->columnSpan(1),
                            TextInput::make('bulan_mkg_baru')->label(',')->maxLength(255)->integer()->mask('99')->suffix('Bln')
                                ->extraAttributes(['style'=>'border-top-left-radius:0;border-bottom-left-radius:0;padding-left:0!important;margin-left:-10px!important;'])
                                ->columnSpan(1),
                            TextInput::make('gaji_pokok_baru')->label('Gaji Pokok')->maxLength(255)->integer()->mask('9999999999999999999999999')
                                ->columnSpan(2)
                                ->live()
                            ]),
                        Grid::make(6)->schema([
                            DatePicker::make('tmt_kgb_yad_baru')->label('TMT Y.A.D')->prefixIcon('heroicon-m-calendar')->native(false)->displayFormat('d-m-Y')
                                ->columnSpan(2),
                            ]),
                        Grid::make(6)->schema([
                            DatePicker::make('tanggal_terbit')->label('Tanggal Terbit Surat')->prefixIcon('heroicon-m-calendar')->native(false)->displayFormat('d-m-Y')->default(now())
                                ->columnSpan(2),
                            Textarea::make('keterangan')->label('Keterangan')
                                ->columnSpan(4)
                            ]),
                        ]
                    ),
                
//END SCHEMA
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ]);
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
                    TextColumn::make('nama')->label('NAMA')->searchable()->sortable(),
                    TextColumn::make('nip')->label('NIP'),
                    TextColumn::make('karpeg')->label('KARPEG')->searchable()->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('jabatan')->label('JABATAN')->searchable()->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('kesatuan')->label('KESATUAN')->searchable()->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('tanggal_lahir')->date('d-m-Y')->label('TGL LAHIR')->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('tmt_cpns')->date('d-m-Y')->label('TMT CPNS')->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('tmt_golongan')->date('d-m-Y')->label('TMT GOL')->toggleable(isToggledHiddenByDefault: true),
                ])->alignment(Alignment::Center),
                ColumnGroup::make('KEADAAN LAMA', [
                    TextColumn::make('golonganLama.nama')->label('GOL')
                        ->sortable(),
                    TextColumn::make('full_mks_lama')->label('MKS')
                        ->formatStateUsing(fn ($record) => "{$record->tahun_mks_lama}".' Thn, '."{$record->tahun_mks_lama}".' Bln'),
                    TextColumn::make('full_mkg_lama')->label('MKG')
                        ->formatStateUsing(fn ($record) => "{$record->tahun_mkg_lama}".' Thn, '."{$record->tahun_mkg_lama}".' Bln'),
                    TextColumn::make('gaji_pokok_lama')->label('GAJI POKOK')
                        ->numeric(),
                    TextColumn::make('tmt_skep_lama')->label('TMT SKEP')
                        ->date('d-m-Y')->date('d-m-Y')
                        ->sortable(),
                    TextColumn::make('skep_lama')->label('SKEP LAMA')->toggleable(isToggledHiddenByDefault: false),
                    TextColumn::make('tmt_kgb_yad_lama')->label('TMT YAD')
                        ->date('d-m-Y')->date('d-m-Y')->toggleable(isToggledHiddenByDefault: false)
                        ->sortable(),
                ])->alignment(Alignment::Center),
                
                ColumnGroup::make('KEADAAN BARU', [
                    TextColumn::make('golonganBaru.nama')->label('GOL')
                        ->sortable(),
                    TextColumn::make('full_mks_baru')->label('MKS')
                        ->formatStateUsing(fn ($record) => "{$record->tahun_mks_baru}".' Thn, '."{$record->tahun_mks_baru}".' Bln'),
                    TextColumn::make('full_mkg_baru')->label('MKG')
                        ->formatStateUsing(fn ($record) => "{$record->tahun_mkg_baru}".' Thn, '."{$record->tahun_mkg_baru}".' Bln'),
                    TextColumn::make('gaji_pokok_baru')->label('GAJI POKOK')
                        ->numeric(),
                    TextColumn::make('tmt_skep_baru')->label('TMT SKEP')
                        ->date('d-m-Y')->date('d-m-Y')
                        ->sortable(),
                    TextColumn::make('skep_baru')->label('SKEP BARU')->toggleable(isToggledHiddenByDefault: false),
                    TextColumn::make('tmt_kgb_yad_baru')->label('TMT YAD')
                        ->date('d-m-Y')->date('d-m-Y')->toggleable(isToggledHiddenByDefault: false)
                        ->sortable(),
                    TextColumn::make('keterangan')->label('KET')->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('tanggal_terbit')->label('TGL SURAT')->date('d-m-Y')->toggleable(isToggledHiddenByDefault: true),
                ])->alignment(Alignment::Center),

              
            ])
            ->filters([
                //
            ])
            ->actions([
                
                Tables\Actions\ViewAction::make()->hiddenLabel(),
                Tables\Actions\Action::make('edit')
                    ->icon('heroicon-m-pencil-square')
                    ->iconButton()
                    ->action(fn (GajiBerkalaAsn $record) => redirect()->route('filament.siberkat.resources.kgb-asn.edit', ['record' => $record]))
                    //->url(fn (GajiBerkalaAsn $record): string => route('filament.siberkat.resources.kgb-asn.edit', $record))
                
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
            'index' => Pages\ListGajiBerkalaAsn::route('/'),
            'create' => Pages\CreateGajiBerkalaAsn::route('/create'),
            //'view' => Pages\ViewGajiBerkalaAsn::route('/{record}'),
            //'edit' => Pages\EditGajiBerkalaAsn::route('/{record}/edit'),
        ];
    }
    public static function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->schema([
            TextEntry::make('nama'),
            TextEntry::make('nip'),
        ]);
}
}
