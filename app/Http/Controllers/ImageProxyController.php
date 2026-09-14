<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ImageProxyController extends Controller
{
    public function show(string $path)
    {
        $disk = Storage::disk('b2');

        if (! $disk->exists($path)) {
            abort(404, 'Gambar tidak ditemukan.');
        }

        $fileContent = $disk->get($path);
        $mimeType = $disk->mimeType($path) ?? 'image/jpeg';

        return Response::make($fileContent, 200, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
