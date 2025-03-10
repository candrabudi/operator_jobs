<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SocialMediaAccount;
use App\Models\SocialMediaAccountPlatformAssign;
use App\Models\SocialMediaAccountTopic;
use App\Models\SocialMediaPlatform;
use App\Models\Topic;
use Illuminate\Http\Request;

class SocialMediaAccountController extends Controller
{
    public function index()
    {
        $topics = Topic::all();
        $platforms = SocialMediaPlatform::all();
        return view('accounts.index', compact('platforms', 'topics'));
    }

    public function list()
    {
        $socialMediaAccounts = SocialMediaAccount::with('socialMediaAccountTopic', 'socialMediaAccountPlatformAssign')
            ->get();

        return response()->json($socialMediaAccounts);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_username' => 'required|string|max:255',
            'account_password' => 'required|string',
            'account_email' => 'required|string|email|max:255',
            'account_email_password' => 'required|string',
            'topics' => 'array',
            'platforms' => 'array',
        ]);

        $socialMediaAccount = SocialMediaAccount::create([
            'account_username' => $validated['account_username'],
            'account_password' => $validated['account_password'],
            'account_email' => $validated['account_email'],
            'account_email_password' => $validated['account_email_password'],
        ]);

        foreach ($validated['topics'] as $topicId) {
            SocialMediaAccountTopic::create([
                'social_media_account_id' => $socialMediaAccount->id,
                'topic_id' => $topicId,
            ]);
        }

        foreach ($validated['platforms'] as $platformId) {
            SocialMediaAccountPlatformAssign::create([
                'social_media_account_id' => $socialMediaAccount->id,
                'social_media_platform_id' => $platformId,
            ]);
        }

        return response()->json([
            'message' => 'Social media account added successfully!',
            'account' => $socialMediaAccount,
        ], 200);
    }

    public function update(Request $request, $id)
{
    $socialMediaAccount = SocialMediaAccount::findOrFail($id);

    // Validate only the fields that are present in the request
    $validated = $request->validate([
        'account_username' => 'sometimes|string|max:255',
        'account_password' => 'sometimes|string',
        'account_email' => 'sometimes|string|email|max:255',
        'account_email_password' => 'sometimes|string',
        'topics' => 'sometimes|array',
        'platforms' => 'sometimes|array',
    ]);

    // Use the existing values for any missing fields
    $socialMediaAccount->update([
        'account_username' => $validated['account_username'] ?? $socialMediaAccount->account_username,
        'account_password' => $validated['account_password'] ?? $socialMediaAccount->account_password,
        'account_email' => $validated['account_email'] ?? $socialMediaAccount->account_email,
        'account_email_password' => $validated['account_email_password'] ?? $socialMediaAccount->account_email_password,
    ]);

    // Update topics only if provided
    if (isset($validated['topics'])) {
        SocialMediaAccountTopic::where('social_media_account_id', $socialMediaAccount->id)->delete();
        foreach ($validated['topics'] as $topicId) {
            SocialMediaAccountTopic::create([
                'social_media_account_id' => $socialMediaAccount->id,
                'topic_id' => $topicId,
            ]);
        }
    }

    // Update platforms only if provided
    if (isset($validated['platforms'])) {
        SocialMediaAccountPlatformAssign::where('social_media_account_id', $socialMediaAccount->id)->delete();
        foreach ($validated['platforms'] as $platformId) {
            SocialMediaAccountPlatformAssign::create([
                'social_media_account_id' => $socialMediaAccount->id,
                'social_media_platform_id' => $platformId,
            ]);
        }
    }

    return response()->json([
        'message' => 'Social media account updated successfully!',
        'account' => $socialMediaAccount,
    ], 200);
}


    public function destroy($id)
    {
        $socialMediaAccount = SocialMediaAccount::findOrFail($id);

        // Delete associated topics and platforms
        SocialMediaAccountTopic::where('social_media_account_id', $socialMediaAccount->id)->delete();
        SocialMediaAccountPlatformAssign::where('social_media_account_id', $socialMediaAccount->id)->delete();

        // Delete the social media account itself
        $socialMediaAccount->delete();

        return response()->json([
            'message' => 'Social media account deleted successfully!'
        ], 200);
    }


}
