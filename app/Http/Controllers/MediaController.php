<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RequestPostingMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function destroy($id)
    {
        $media = RequestPostingMedia::findOrFail($id);

        // Hapus file dari storage
        if (Storage::exists($media->file_path)) {
            Storage::delete($media->file_path);
        }

        // Hapus dari database
        $media->delete();

        return response()->json(['message' => 'Media deleted successfully'], 200);
    }
}
