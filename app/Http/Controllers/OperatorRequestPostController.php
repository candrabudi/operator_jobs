<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PostingReport;
use App\Models\PostingReportMedia;
use App\Models\ReportRequestPost;
use App\Models\RequestBoost;
use App\Models\RequestPost;
use App\Models\RequestPosting;
use App\Models\SocialMediaEngagement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class OperatorRequestPostController extends Controller
{
    public function index()
    {
        return view('operator.posts.index');
    }

    public function list()
    {
        $user = Auth::user();
        $requestPosts = RequestPost::with('media', 'platform')
            ->paginate(25);

        return response()->json($requestPosts);
    }

    public function report($a)
    {
        $requestPostID = $a;
        $requestPost = RequestPost::where('id', $a)
            ->first();

        return view('operator.posts.report', compact('requestPostID', 'requestPost'));

    }

    public function storeReport(Request $request, $a) 
    {
        $report_content_array = explode("\r\n", $request->report_content);
        
        $requestPost = RequestPost::where('id', $a)->first();
        
        $store = new ReportRequestPost();
        $store->request_post_id = $a;
        $store->notes = $request->report_content;
        $store->created_by = Auth::user()->id;
        $store->save();
    
        $operators = User::where('role', 'operator_boosting')->get();
        
        $engagements = SocialMediaEngagement::whereIn('engagement_type', ['Like', 'Comment'])->get();
    
        foreach ($operators as $op) {
            $message = "MOHON BANTUANNYA UNTUK MELAKUKAN POSTING MENGENAI REQUEST DARI PUSAT\n\n";
            
            foreach ($report_content_array as $rca) {
                foreach ($engagements as $egg) {
                    $message .= "LINK POSTING: *{$rca}*\n";
                    $message .= "PLATFORM: *{$requestPost->platform->social_media_name}*\n";
                    $message .= "ACTION: *{$egg->engagement_type}*\n\n";
    
                    $storeBoost = new RequestBoost();
                    $storeBoost->created_by = Auth::user()->id;
                    $storeBoost->social_media_platform_id = $requestPost->platform->id;
                    $storeBoost->social_media_engagement_id = $egg->id;
                    $storeBoost->link_post = $rca;
                    $storeBoost->status = "pending";
                    $storeBoost->save();
                }
            }
            
            Http::get('https://whatsapp.xn--v3cud6b6c.systems/send-message', [
                'api_key' => 'YelYqpUlZjESa077DpL3PP2kjyIBL1',
                'sender' => '6285229931237',
                'number' => $op->phone_number,
                'message' => $message,
            ]);
        }
        return redirect()->route('system.operator.request.posts.index');
    }
}
