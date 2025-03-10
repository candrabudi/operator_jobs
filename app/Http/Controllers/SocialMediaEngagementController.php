<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SocialMediaEngagement;
use Illuminate\Http\Request;

class SocialMediaEngagementController extends Controller
{
    public function index()
    {
        return view('engagements.index');
    }

    public function list()
    {
        $engagements = SocialMediaEngagement::all();
        return response()->json($engagements);
    }

    public function store(Request $request)
    {
        $request->validate([
            'engagement_type' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9_]+$/',
                'unique:social_media_engagements,engagement_type'
            ],
        ]);

        $engagement = SocialMediaEngagement::create($request->only('engagement_type'));

        return response()->json(['message' => 'Engagement created successfully', 'engagement' => $engagement]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'engagement_type' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9_]+$/',
                'unique:social_media_engagements,engagement_type,' . $id,
            ],
        ]);

        $engagement = SocialMediaEngagement::find($id);
        if ($engagement) {
            $engagement->update($request->only('engagement_type'));
            return response()->json(['message' => 'Engagement updated successfully', 'engagement' => $engagement]);
        }
        return response()->json(['message' => 'Engagement not found'], 404);
    }



    public function destroy($id)
    {
        $engagement = SocialMediaEngagement::find($id);
        if ($engagement) {
            $engagement->delete();
            return response()->json(['message' => 'Topic deleted successfully']);
        }
        return response()->json(['message' => 'Topic not found'], 404);
    }
}
