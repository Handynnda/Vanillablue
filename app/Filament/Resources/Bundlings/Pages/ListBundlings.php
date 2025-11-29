<?php

namespace App\Filament\Resources\Bundlings\Pages;

use App\Filament\Resources\Bundlings\BundlingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBundlings extends ListRecords
{
    protected static string $resource = BundlingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
