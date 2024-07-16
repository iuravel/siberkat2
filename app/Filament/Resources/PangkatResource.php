<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PangkatResource\Pages;
use App\Filament\Resources\PangkatResource\RelationManagers;
use App\Models\GapokMiliter;
use App\Models\Grup;
use App\Models\Pangkat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PangkatResource extends Resource
{
    protected static ?string $model = Pangkat::class;
    protected static ?string $slug = 'pangkat';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->label('Nama Pangkat')
                    ->maxLength(255),
                Forms\Components\TextInput::make('uraian')
                    ->maxLength(255),
                Forms\Components\Select::make('grup_id')
                    ->label('Grup')
                    ->options(Grup::all()->pluck('nama', 'id'))
                    //->native(false)
                    ->required()
                    ->default(1)
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes())
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Pangkat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('uraian')
                    ->searchable(),
                Tables\Columns\TextColumn::make('grup.nama')
                    ->label('Grup')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->striped()
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->hiddenLabel(),
                Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                    ->before(
                        function ($records, Tables\Actions\DeleteBulkAction $action) {
                            $ids = $records->pluck('id')->toArray();
                            $exists = GapokMiliter::whereIn('pangkat_id', $ids)->exists();
                            if ($exists) {
                                Notification::make()
                                    ->title('Error!')
                                    ->body("Anda tidak dapat menghapus pangkat ini karena masih terikat data gaji pokok militer.")
                                    ->status('danger')
                                    ->send();
                                $action->cancel();
                            }
                        }
                    ),
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
            'index' => Pages\ListPangkat::route('/'),
            //'create' => Pages\CreatePangkat::route('/create'),
            //'view' => Pages\ViewPangkat::route('/{record}'),
            //'edit' => Pages\EditPangkat::route('/{record}/edit'),
        ];
    }
    
}
