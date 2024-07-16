<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GapokAsnResource\Pages;
use App\Filament\Resources\GapokAsnResource\RelationManagers;
use App\Models\GapokAsn;
use App\Models\Golongan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GapokAsnResource extends Resource
{
    protected static ?string $model = GapokAsn::class;

    protected static ?string $slug = 'gaji-pokok-asn';
    protected static ?string $navigationGroup = 'Daftar Gaji Pokok';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('golongan_id')
                    ->label('Golongan')
                    ->options(Golongan::all()->pluck('nama', 'id'))
                    ->searchable()
                    //->native(false) 
                    ->required(),
                Forms\Components\TextInput::make('masa_kerja')
                    ->label('Masa Kerja')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('gaji')
                    ->label('Gaji Pokok')
                    ->required()
                    ->numeric(),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')
                    ->label('No.')
                    ->rowIndex()
                    ->sortable(),
                TextColumn::make('golongan.nama')
                    ->label('Golongan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('golongan.uraian')
                    ->label('Uraian')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('masa_kerja')
                    ->label('Masa Kerja')
                    ->numeric()
                    ->sortable()
                    ->suffix(' Tahun'),
                TextColumn::make('gaji')
                    ->label('Gaji Pokok')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return 'Rp. ' . number_format($state, 0, ',', '.');
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('golongan_id', 'desc')
            ->striped()
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->hiddenLabel(),
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
            'index' => Pages\ListGapokAsn::route('/'),
            //'create' => Pages\CreateGapokAsn::route('/create'),
            //'view' => Pages\ViewGapokAsn::route('/{record}'),
            //'edit' => Pages\EditGapokAsn::route('/{record}/edit'),
        ];
    }
}
