<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RequestPosting;
use App\Models\RequestPostingMedia;
use App\Models\SocialMediaPlatform;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class RequestPostingController extends Controller
{
    public function index()
    {
        return view('super.request.index');
    }

    public function list()
    {
        $requestPosts = RequestPosting::with('requestMediaPosts', 'platform')
            ->paginate(25);

        return response()->json($requestPosts);
    }

    public function create()
    {
        $operators = User::whereNotIn('role', ['superadmin', 'admin'])
            ->get();

        $socialMedias = SocialMediaPlatform::all();

        return view('super.request.create', compact('operators', 'socialMedias'));
    }


    public function store(Request $request)
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

        $requestPosting = new RequestPosting();
        $requestPosting->user_id = $validated['user_id'];
        $requestPosting->social_media_platform_id = $validated['social_media_platform_id'];
        $requestPosting->trx_post = strtoupper(uniqid('trx_'));
        $requestPosting->title = $validated['title'];
        $requestPosting->notes = $validated['notes'] ?? null;
        $requestPosting->content = $validated['content'];
        $requestPosting->total_account = $validated['total_account'];
        $requestPosting->status = 'pending';
        $requestPosting->save();

        $operator = User::where('id', $validated['user_id'])->first();

        $dateRequest = Carbon::parse($requestPosting->created_at)->format('Y/m/d H:i:s');
        $socialMediaPlatform = SocialMediaPlatform::where('id', $validated['social_media_platform_id'])->first();

        $status = strtoupper($requestPosting->status);

        $message = "JUDUL POSTING: *{$requestPosting->title}* \nNOMOR TRX: *{$requestPosting->trx_post}* \nOPERATOR: *{$operator->full_name}* \nTIPE REQUEST: *POSTING* \nTOTAL ACCOUNT: *{$requestPosting->total_account}* \nSOCIAL MEDIA: *{$socialMediaPlatform->social_media_name}* \nTANGGAL REQUEST: *{$dateRequest}* \nSTATUS: *{$status}* \n\nMOHON BANTUANNYA UNTUK MELAKUKAN POSTING MENGENAI REQUEST DARI PUSAT";

        Http::get('https://whatsapp.xn--v3cud6b6c.systems/send-message', [
            'api_key' => 'YelYqpUlZjESa077DpL3PP2kjyIBL1',
            'sender' => '6285229931237',
            'number' => $operator->phone_number,
            'message' => $message,
        ]);
        
        
        Http::get('https://whatsapp.xn--v3cud6b6c.systems/send-message', [
            'api_key' => 'YelYqpUlZjESa077DpL3PP2kjyIBL1',
            'sender' => '6285229931237',
            'number' => $operator->phone_number,
            'message' => $validated['content'],
        ]);


        if ($request->hasFile('mediaFiles')) {
            foreach ($request->file('mediaFiles') as $file) {
                $filePath = $file->store('uploads/media', 'public');
                $fileExt = $file->getClientOriginalExtension();
                $fileSize = $file->getSize();

                $fileType = 'doc';
                if (in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $apiKey = 'YelYqpUlZjESa077DpL3PP2kjyIBL1';
                    $senderNumber = '6285229931237';
                    $recipientNumber = $operator->phone_number;
                    $mediaType = 'image';
                    $imageCaption = 'from api';
                    $imageUrl = asset('/storage/'.$filePath);
                    
                    $response = Http::get('https://whatsapp.xn--v3cud6b6c.systems/send-media', [
                        'api_key' => $apiKey,
                        'sender' => $senderNumber,
                        'number' => $recipientNumber,
                        'media_type' => $mediaType,
                        'caption' => $imageCaption,
                        'url' => $imageUrl,
                    ]);

                    $fileType = 'image';
                } elseif (in_array($fileExt, ['mp4', 'mov'])) {

                    $apiKey = 'YelYqpUlZjESa077DpL3PP2kjyIBL1';
                    $senderNumber = '6285229931237';
                    $recipientNumber = $operator->phone_number;
                    $mediaType = 'video';
                    $imageCaption = 'from api';
                    $videoUrl = asset('/storage/'.$filePath);

                    $response = Http::get('https://whatsapp.xn--v3cud6b6c.systems/send-media', [
                        'api_key' => $apiKey,
                        'sender' => $senderNumber,
                        'number' => $recipientNumber,
                        'media_type' => $mediaType,
                        'caption' => $imageCaption,
                        'url' => $videoUrl,
                    ]);

                    $fileType = 'video';
                }

                $media = new RequestPostingMedia();
                $media->request_posting_id = $requestPosting->id;
                $media->file_path = $filePath;
                $media->file_ext = $fileExt;
                $media->file_size = $fileSize;
                $media->file_type = $fileType;
                $media->save();
            }
        }

        return redirect()->back()->with('success', 'Post request created successfully!');
    }

    public function edit($id)
    {
        $post = RequestPosting::with('requestMediaPosts')->findOrFail($id);
        $operators = User::whereNotIn('role', ['superadmin', 'admin'])->get();
        $socialMedias = SocialMediaPlatform::all();

        return view('super.request.edit', compact('post', 'operators', 'socialMedias'));
    }

    // Method to update post request
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

        $requestPosting = RequestPosting::findOrFail($id);
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

                $media = new RequestPostingMedia();
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
