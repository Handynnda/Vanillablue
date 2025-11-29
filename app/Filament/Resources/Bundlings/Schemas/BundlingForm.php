<?php

namespace App\Filament\Resources\Bundlings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BundlingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_bundling')
                    ->required(),
                TextInput::make('price_bundling')
                    ->required()
                    ->numeric(),
                Textarea::make('description_bundling')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('category')
                    ->options([
            'Baby & Kids' => 'Baby& kids',
            'Birthday' => 'Birthday',
            'Maternity' => 'Maternity',
            'Prewed' => 'Prewed',
            'Graduation' => 'Graduation',
            'Family' => 'Family',
            'Group' => 'Group',
            'Couple' => 'Couple',
            'Personal' => 'Personal',
            'Pas Foto' => 'Pas foto',
            'Print & Frame' => 'Print& frame',
        ])
                    ->default(null),
            ]);
    }
}
