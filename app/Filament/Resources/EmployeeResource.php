<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\City;
use Filament\Tables;
use App\Models\State;
use App\Models\Country;
use App\Models\Employee;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EmployeeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Office Managment';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('first_name'),
                        TextInput::make('last_name'),
                        TextInput::make('addres'),
                        Select::make('department_id')->relationship('department', 'name'),
                        Select::make('country_id')
                            ->label('Country')
                            ->options(Country::all()->pluck('name', 'id')->toArray())
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('state_id', null)),
                        Select::make('state_id')
                            ->label('State')
                            ->options(
                                function (callable $get) {
                                    $country = Country::find($get('country_id'));
                                    if (!$country) {
                                        return State::all()->pluck('name', 'id');
                                    }
                                    return $country->state->pluck('name', 'id');
                                }
                            ),
                            // ->afterStateUpdated(fn (callable $set) => $set('city_id', null)),
                        Select::make('city_id')
                            ->label('City')
                            ->options(
                                // function (callable $get) {
                                //     $state = State::find($get('state_id'));
                                //     if (!$state) {
                                //         return City::all()->pluck('name', 'id');
                                //     }
                                //     return $state->cities->pluck('name', 'id');
                                // }
                                function (callable $get) {
                                    $state = State::find($get('state_id'));
                                    if (!$state) {
                                        return City::all()->pluck('name', 'id');
                                    }
                                    return $state->city->pluck('name', 'id');
                                }
                            ),
                        TextInput::make('zip_code'),
                        DatePicker::make('birth_date'),
                        DatePicker::make('date_hired'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('first_name')->searchable(),
                TextColumn::make('last_name')->searchable(),
                TextColumn::make('department.name'),
                // TextColumn::make('country.name'), 
                // TextColumn::make('state.name'), 
                // TextColumn::make('city.name'), 
                TextColumn::make('birth_date'),
                TextColumn::make('date_hired'),
            ])
            ->filters([
                SelectFilter::make('department')
                    ->relationship('department', 'name')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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

    public static function getWidgets(): array{
        return [
            EmployeeResource\Widgets\EmployeeOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
