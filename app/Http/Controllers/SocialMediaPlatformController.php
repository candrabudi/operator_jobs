<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SocialMediaPlatform;
use App\Models\EngagementType;
use App\Models\SocialMediaEngagement;
use App\Models\SocialMediaPlatformEngagement;
use Illuminate\Http\Request;

class SocialMediaPlatformController extends Controller
{
    // Display all platforms
    public function index()
    {
        $engagements = SocialMediaEngagement::all();
        return view('platforms.index', compact('engagements'));
    }
    
    public function list()
    {
        $platforms = SocialMediaPlatform::with('socialMediaPlatformEngagement')
            ->get();

        return response()->json($platforms);
    }

    public function store(Request $request)
    {
        $request->validate([
            'social_media_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'engagement_types' => 'array'
        ]);

        $platform = SocialMediaPlatform::create([
            'social_media_name' => $request->social_media_name,
            // 'description' => $request->description
        ]);

        if ($request->has('engagement_types')) {
            foreach ($request->engagement_types as $engagementId) {
                SocialMediaPlatformEngagement::create([
                    'social_media_platform_id' => $platform->id,
                    'engagement_type_id' => $engagementId
                ]);
            }
        }

        return response()->json(['message' => 'Platform added successfully!']);
    }

    public function edit($id)
    {
        $platform = SocialMediaPlatform::with('engagementTypes')->findOrFail($id);
        $engagements = SocialMediaEngagement::all();

        return response()->json([
            'platform' => $platform,
            'engagements' => $engagements
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'social_media_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'engagement_types' => 'array'
        ]);

        $platform = SocialMediaPlatform::findOrFail($id);
        $platform->update([
            'social_media_name' => $request->social_media_name,
            'description' => $request->description
        ]);

        SocialMediaPlatformEngagement::where('social_media_platform_id', $platform->id)->delete();
        if ($request->has('engagement_types')) {
            foreach ($request->engagement_types as $engagementId) {
                SocialMediaPlatformEngagement::create([
                    'social_media_platform_id' => $platform->id,
                    'engagement_type_id' => $engagementId
                ]);
            }
        }

        return response()->json(['message' => 'Platform updated successfully!']);
    }

    public function destroy($id)
    {
        $platform = SocialMediaPlatform::findOrFail($id);

        SocialMediaPlatformEngagement::where('social_media_platform_id', $platform->id)->delete();
        $platform->delete();

        return response()->json(['message' => 'Platform deleted successfully!']);
    }
}
