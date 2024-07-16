<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GapokMiliterResource\Pages;
use App\Filament\Resources\GapokMiliterResource\RelationManagers;
use App\Models\GapokMiliter;
use App\Models\Pangkat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GapokMiliterResource extends Resource
{
    protected static ?string $model = GapokMiliter::class;

    protected static ?string $slug = 'gaji-pokok-militer';
    protected static ?string $navigationGroup = 'Daftar Gaji Pokok';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('pangkat_id')
                    ->label('Pangkat')
                    ->options(Pangkat::all()->pluck('nama', 'id'))
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
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('No.')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('pangkat.nama')
                    ->label('Pangkat')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('masa_kerja')
                ->label('Masa Kerja')
                    ->searchable()
                    ->suffix(' Tahun')
                    ->sortable(),
                Tables\Columns\TextColumn::make('gaji')
                    ->label('Gaji Pokok')
                    //->prefix('Rp. ')
                    ->formatStateUsing(function ($state) {
                        return 'Rp. ' . number_format($state, 0, ',', '.');
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('pangkat_id', 'desc')
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
            'index' => Pages\ListGapokMiliter::route('/'),
            //'create' => Pages\CreateGapokMiliter::route('/create'),
            //'view' => Pages\ViewGapokMiliter::route('/{record}'),
            //'edit' => Pages\EditGapokMiliter::route('/{record}/edit'),
        ];
    }
}
