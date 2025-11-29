<?php

namespace App\Filament\Resources\Bundlings;

use App\Filament\Resources\Bundlings\Pages\CreateBundling;
use App\Filament\Resources\Bundlings\Pages\EditBundling;
use App\Filament\Resources\Bundlings\Pages\ListBundlings;
use App\Filament\Resources\Bundlings\Schemas\BundlingForm;
use App\Filament\Resources\Bundlings\Tables\BundlingsTable;
use App\Models\Bundling;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BundlingResource extends Resource
{
    protected static ?string $model = Bundling::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return BundlingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BundlingsTable::configure($table);
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
            'index' => ListBundlings::route('/'),
            'create' => CreateBundling::route('/create'),
            'edit' => EditBundling::route('/{record}/edit'),
        ];
    }
}
