<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SocialMediaEngagement;
use App\Models\SocialMediaLimit;
use App\Models\SocialMediaPlatform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlatformController extends Controller
{
    public function index()
    {
        if(Auth::user()->role != "superadmin") {
            return view('error.403');
        }
        $engagements = SocialMediaEngagement::all();
        return view('platforms.index', compact('engagements'));
    }

    public function list()
    {
        if(Auth::user()->role != "superadmin") {
            return view('error.403');
        }
        $platforms = SocialMediaPlatform::with('limits')
            ->paginate(10);
        return response()->json($platforms);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'social_media_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'platform_type' => 'required|array',
            'min' => 'required|array',
            'max' => 'required|array',
        ]);

        try {
            // Buat entri untuk platform sosial media
            $platform = SocialMediaPlatform::create([
                'social_media_name' => $validated['social_media_name'],
                'description' => $validated['description'] ?? null,
            ]);

            // Simpan limit untuk setiap boost type yang dikirim
            foreach ($validated['platform_type'] as $index => $type) {
                SocialMediaLimit::create([
                    'social_media_platform_id' => $platform->id,
                    'platform_type' => $type,
                    'min' => $validated['min'][$index],
                    'max' => $validated['max'][$index],
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Platform and limits successfully created!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create platform and limits! '.$e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        $platform = SocialMediaPlatform::with('limits')->findOrFail($id);

        return response()->json([
            'success' => true,
            'platform' => $platform
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'social_media_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'platform_type' => 'required|array',
            'min' => 'required|array',
            'max' => 'required|array',
        ]);

        try {
            $platform = SocialMediaPlatform::findOrFail($id);

            $platform->update([
                'social_media_name' => $validated['social_media_name'],
                'description' => $validated['description'] ?? null,
            ]);

            $platform->limits()->delete();
            foreach ($validated['platform_type'] as $index => $type) {
                SocialMediaLimit::create([
                    'social_media_platform_id' => $platform->id,
                    'platform_type' => $type,
                    'min' => $validated['min'][$index],
                    'max' => $validated['max'][$index],
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Platform and limits successfully updated!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update platform and limits! '.$e->getMessage(),
            ], 500);
        }
    }

    public function destroy($a)
    {
        SocialMediaPlatform::where('id', $a)
            ->delete();
        
        SocialMediaLimit::where('social_media_platform_id', $a)
            ->delete();

        return response()
            ->json([
                'status' => 'success', 
                'code' => 200, 
                'message' => 'Success destroy platform',
            ]);
    }
}
