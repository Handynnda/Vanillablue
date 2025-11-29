<?php

namespace App\Filament\Resources\Bundlings\Pages;

use App\Filament\Resources\Bundlings\BundlingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBundling extends EditRecord
{
    protected static string $resource = BundlingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
