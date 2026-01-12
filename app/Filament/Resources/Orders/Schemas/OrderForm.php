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
                Select::make('customer_id')
                    ->label('Customer')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('bundling_id')
                    ->label('Paket')
                    ->relationship('bundling', 'name_bundling')
                    ->searchable()
                    ->preload()
                    ->required(),
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
                    ->options(['confirmed' => 'Confirmed', 'completed' => 'Completed', 'pending' => 'Pending', 'failed' => 'Failed'])
                    ->default('pending')
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
