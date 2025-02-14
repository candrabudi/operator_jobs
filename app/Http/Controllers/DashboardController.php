<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RequestBoosting;
use App\Models\RequestPosting;
use App\Models\SocialMediaPlatform;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingPostRequests = RequestPosting::where('status', 'pending')
            ->get();
        
        $pendingBoostRequests = RequestBoosting::where('status', 'pending')
            ->get();

        return view('dashboard.index', compact( 'pendingPostRequests', 'pendingBoostRequests'));
    }
    // public function index()
    // {
    //     $socialMediaPlatforms = SocialMediaPlatform::with('requestPost', 'requestBoost')
    //         ->get();

    //     $requestPostPending = RequestPosting::where('status', 'pending')
    //         ->count();
        
    //     $requestBoostPending = RequestBoosting::where('status', 'pending')
    //         ->count();

    //     return view('dashboard.index', compact('socialMediaPlatforms', 'requestPostPending', 'requestBoostPending'));
    // }
}
