<?php

namespace App\Filament\Resources\Images\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('category')
                    ->label('Kategori')
                    ->options([
                        'Baby & Kids'   => 'Baby & Kids',
                        'Birthday'      => 'Birthday',
                        'Maternity'     => 'Maternity',
                        'Prewed'        => 'Prewed',
                        'Graduation'    => 'Graduation',
                        'Family'        => 'Family',
                        'Group'         => 'Group',
                        'Couple'        => 'Couple',
                        'Personal'      => 'Personal',
                        'Pas Foto'      => 'Pas Foto',
                        'Print & Frame' => 'Print & Frame',
                    ])
                    ->required(),

                FileUpload::make('url_image')
                    ->label('Upload Foto')
                    ->image()
                    ->required()
                    ->disk('cloudinary') 
                    // Set a non-dot directory so Cloudinary public_id doesn't become "./..."
                    ->directory('images')
                    ->getUploadedFileNameForStorageUsing(fn ($file) => uniqid('img_').'.'.$file->getClientOriginalExtension()),
            ]);
    }
}
