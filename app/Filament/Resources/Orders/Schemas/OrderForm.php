<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('customer.name')
                    ->required()
                    ->numeric(),
                TextInput::make('bundling.name_bundling')
                    ->required()
                    ->numeric(),
                DatePicker::make('book_date')
                    ->required(),
                TimePicker::make('book_time')
                    ->required(),
                Select::make('location')
                    ->options(['indoor' => 'Indoor', 'outdoor' => 'Outdoor'])
                    ->default('indoor')
                    ->required(),
                TextInput::make('note')
                    ->default(null),
                Select::make('order_status')
                    ->options(['unpaid' => 'Unpaid', 'paid' => 'Paid', 'pending' => 'Pending', 'failed' => 'Failed'])
                    ->default('unpaid')
                    ->required(),
                TextInput::make('total_price')
                    ->required()
                    ->numeric()
                    ->prefix('IDR'),
                TextInput::make('sum_order')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }
}
