<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RequestPost;
use App\Models\RequestPosting;
use App\Models\RequestPostingMedia;
use App\Models\RequestPostMedia;
use App\Models\SocialMediaEngagement;
use App\Models\SocialMediaPlatform;
use App\Models\Topic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RequestPostingController extends Controller
{
    public function index()
    {

        return view('super.request.index');
    }

    public function list()
    {
        $requestPosts = RequestPost::with('media', 'platform', 'updatedBy')
        ->paginate(25);

        return response()->json($requestPosts);
    }

    public function create()
    {
        $operators = User::whereNotIn('role', ['superadmin', 'admin'])
            ->get();

        $socialMedias = SocialMediaPlatform::all();
        $topics = Topic::all();
        return view('super.request.create', compact('operators', 'socialMedias', 'topics'));
    }   

    public function getAssignedAccounts($topicId)
    {
        $accounts = DB::table('social_media_accounts')
            ->join('social_media_account_topics', 'social_media_accounts.id', '=', 'social_media_account_topics.social_media_account_id')
            ->where('social_media_account_topics.topic_id', $topicId)
            ->select('social_media_accounts.id', 'social_media_accounts.account_username')
            ->get();

        return response()->json(['accounts' => $accounts]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'social_media_platform_id' => 'required|exists:social_media_platforms,id',
            'topic_id' => 'required|exists:topics,id',
            'title' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'content' => 'required|string',
            'mediaFiles.*' => 'file|max:10240|mimes:jpg,jpeg,png,gif,mp4,mov,doc,docx,pdf,webp',
        ]);

        $requestPosting = new RequestPost();
        $requestPosting->social_media_platform_id = $validated['social_media_platform_id'];
        $requestPosting->topic_id = $validated['topic_id'];
        $requestPosting->title = $validated['title'];
        $requestPosting->content = $validated['content'];
        $requestPosting->status = 'pending';
        $requestPosting->created_by = Auth::user()->id;
        $requestPosting->save();

        $dateRequest = Carbon::parse($requestPosting->created_at)->format('Y/m/d H:i:s');
        $socialMediaPlatform = SocialMediaPlatform::where('id', $validated['social_media_platform_id'])->first();

        $status = strtoupper($requestPosting->status);

        $operators = User::where('role', 'operator_posting')
            ->get();

        $topic = Topic::where('id', $validated['topic_id'])
            ->first();

        foreach($operators as $op) {
            $message = "
                JUDUL POSTING: *{$requestPosting->title}*
                TOPIC: *{$topic->topic_name}*
                OPERATOR: *{$op->full_name}* 
                TIPE REQUEST: *POSTING* 
                TOTAL ACCOUNT: *{$requestPosting->total_account}* 
                SOCIAL MEDIA: *{$socialMediaPlatform->social_media_name}* 
                TANGGAL REQUEST: *{$dateRequest}* 
                STATUS: *{$status}* 
                \n\nMOHON BANTUANNYA UNTUK MELAKUKAN POSTING MENGENAI REQUEST DARI PUSAT
            ";

            Http::get('https://whatsapp.xn--v3cud6b6c.systems/send-message', [
                'api_key' => 'YelYqpUlZjESa077DpL3PP2kjyIBL1',
                'sender' => '6285229931237',
                'number' => $op->phone_number,
                'message' => $message,
            ]);
            
            
            Http::get('https://whatsapp.xn--v3cud6b6c.systems/send-message', [
                'api_key' => 'YelYqpUlZjESa077DpL3PP2kjyIBL1',
                'sender' => '6285229931237',
                'number' => $op->phone_number,
                'message' => $validated['content'],
            ]);
        } 

        if ($request->hasFile('mediaFiles')) {
            foreach ($request->file('mediaFiles') as $file) {
                $filePath = $file->store('uploads/media', 'public');
                $fileExt = $file->getClientOriginalExtension();
                $fileSize = $file->getSize();

                $fileType = 'doc';
                if (in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $apiKey = 'YelYqpUlZjESa077DpL3PP2kjyIBL1';
                    $senderNumber = '6285229931237';
                    
                    $mediaType = 'image';
                    $imageCaption = '';
                    $imageUrl = asset('/storage/'.$filePath);
                    
                    foreach($operators as $opi) {
                        $recipientNumber = $opi->phone_number;
                        Http::get('https://whatsapp.xn--v3cud6b6c.systems/send-media', [
                            'api_key' => $apiKey,
                            'sender' => $senderNumber,
                            'number' => $recipientNumber,
                            'media_type' => $mediaType,
                            'caption' => $imageCaption,
                            'url' => $imageUrl,
                        ]);
                    }

                    $fileType = 'image';
                } elseif (in_array($fileExt, ['mp4', 'mov'])) {

                    $apiKey = 'YelYqpUlZjESa077DpL3PP2kjyIBL1';
                    $senderNumber = '6285229931237';
                    
                    $mediaType = 'video';
                    $imageCaption = '';
                    $videoUrl = asset('/storage/'.$filePath);

                    foreach($operators as $opv) {
                        $recipientNumber = $opv->phone_number;
                        Http::get('https://whatsapp.xn--v3cud6b6c.systems/send-media', [
                            'api_key' => $apiKey,
                            'sender' => $senderNumber,
                            'number' => $recipientNumber,
                            'media_type' => $mediaType,
                            'caption' => $imageCaption,
                            'url' => $videoUrl,
                        ]);
                    }

                    $fileType = 'video';
                }

                $media = new RequestPostMedia();
                $media->request_posting_id = $requestPosting->id;
                $media->file_path = $filePath;
                $media->file_ext = $fileExt;
                $media->save();
            }
        }

        return redirect()->back()->with('success', 'Post request created successfully!');
    }

    public function edit($id)
    {
        $post = RequestPost::with('requestMediaPosts')->findOrFail($id);
        $operators = User::whereNotIn('role', ['superadmin', 'admin'])->get();
        $socialMedias = SocialMediaPlatform::all();

        return view('super.request.edit', compact('post', 'operators', 'socialMedias'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'total_account' => 'required|integer',
            'user_id' => 'required|exists:users,id',
            'social_media_platform_id' => 'required|exists:social_media_platforms,id',
            'title' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'content' => 'required|string',
            'mediaFiles.*' => 'file|max:10240|mimes:jpg,jpeg,png,gif,mp4,mov,doc,docx,pdf',
        ]);

        $requestPosting = RequestPost::findOrFail($id);
        $requestPosting->user_id = $validated['user_id'];
        $requestPosting->social_media_platform_id = $validated['social_media_platform_id'];
        $requestPosting->title = $validated['title'];
        // $requestPosting->notes = $validated['notes'] ?? null;
        $requestPosting->content = $validated['content'];
        $requestPosting->total_account = $validated['total_account'];
        // $requestPosting->status = $requestPosting->status;
        $requestPosting->save();

        // Handle new media files
        if ($request->hasFile('mediaFiles')) {
            foreach ($request->file('mediaFiles') as $file) {
                $filePath = $file->store('uploads/media', 'public');
                $fileExt = $file->getClientOriginalExtension();
                $fileSize = $file->getSize();

                $fileType = 'doc';
                if (in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $fileType = 'image';
                } elseif (in_array($fileExt, ['mp4', 'mov'])) {
                    $fileType = 'video';
                }

                $media = new RequestPostMedia();
                $media->request_posting_id = $requestPosting->id;
                $media->file_path = $filePath;
                $media->file_ext = $fileExt;
                $media->file_size = $fileSize;
                $media->file_type = $fileType;
                $media->save();
            }
        }

        return redirect()->back()->with('success', 'Post request updated successfully!');
    }

    public function destroy($a)
    {
        RequestPosting::where('id', $a)
            ->delete();

        RequestPostingMedia::where('request_posting_id', $a)
            ->delete();

        return response()
            ->json([
                'status' => 'success',
                'code' => 200,
                'message' => 'Success destroy request post',
            ]);
    }

}
