<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Milon\Barcode\DNS1D;

class BarcodeService
{
    /**
     * Generate a barcode from a UUID and save it as an image.
     *
     * @param string $uuid
     * @return string
     */
    public function generateBarcode(string $uuid): string
    {
        // Create an instance of DNS1D
        $barcodeGenerator = new DNS1D();

        // Generate barcode as PNG (base64)
        $barcodeImage = $barcodeGenerator->getBarcodePNG($uuid, 'C39');

        // Convert base64 image data to actual image content
        $barcodeBinary = base64_decode($barcodeImage);

        // Define storage path
        $barcodePath = "barcodes/{$uuid}.png";

        // Store barcode in the public disk
        Storage::disk('public')->put($barcodePath, $barcodeBinary);

        // Return barcode path
        return $barcodePath;
    }
}