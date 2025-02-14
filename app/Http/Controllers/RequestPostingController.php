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
                    $imageUrl = asset($filePath);

                    
                    $response = Http::get('https://whatsapp.xn--v3cud6b6c.systems/send-media', [
                        'api_key' => $apiKey,
                        'sender' => $senderNumber,
                        'number' => $recipientNumber,
                        'media_type' => $mediaType,
                        'caption' => $imageCaption,
                        'url' => asset($filePath),
                    ]);

                    $fileType = 'image';
                } elseif (in_array($fileExt, ['mp4', 'mov'])) {

                    $apiKey = 'YelYqpUlZjESa077DpL3PP2kjyIBL1';
                    $senderNumber = '6285229931237';
                    $recipientNumber = $operator->phone_number;
                    $mediaType = 'video';
                    $imageCaption = 'from api';
                    $videoUrl = 'https://rr4---sn-npoeeney.googlevideo.com/videoplayback?expire=1739477173&ei=VfytZ8vPFZPug8UP7sXngAU&ip=110.139.131.126&id=o-AAmtNhNSqKIFGD0W9BAYKYsF5I5mcW-bSdwtGEmUgm3Z&itag=18&source=youtube&requiressl=yes&xpc=EgVo2aDSNQ%3D%3D&bui=AUWDL3zpA5A7b1_rEIrSMX7cbFAfWw4dHJiYsWN1BYBzGf8xMeSkiVw3UHXb9_UCyxX8HAdHUdrXhFte&spc=RjZbSVu0G7Nemk7menAvzikfDjZz3Pbqvf5nviFUri1y0CZPNCwEdlMdz7tdFSjBRA&vprv=1&svpuc=1&mime=video%2Fmp4&ns=Q_2COGoLe1s5tsCoklcKM1kQ&rqh=1&gir=yes&clen=20060686&ratebypass=yes&dur=855.957&lmt=1730546242030913&fexp=24350590,24350737,24350827,24350961,24350977,24350978,24351082,24351092,24351129,24351132,24351183,51326932,51331020&c=MWEB&sefc=1&txp=5538434&n=G4vuHXe451MrGA&sparams=expire%2Cei%2Cip%2Cid%2Citag%2Csource%2Crequiressl%2Cxpc%2Cbui%2Cspc%2Cvprv%2Csvpuc%2Cmime%2Cns%2Crqh%2Cgir%2Cclen%2Cratebypass%2Cdur%2Clmt&sig=AJfQdSswRQIgTsvrFI8WNFi93wl740_LLy3YqNds1Mm_f78xXt0pb1oCIQCIoCo_gcl9c1SodTZO0boMK_k-6eSTdkK3O2RpjF2VDw%3D%3D&title=Nadhif%20Basalamah%20-%20Penjaga%20Hati%20(Lirik)%20-%20Mix%20Playlist&rm=sn-2uuxa3vh-cqws7e,sn-npoze7z&rrc=79,104&req_id=fe2c7b34516da3ee&rms=rdu,au&redirect_counter=2&cms_redirect=yes&cmsv=e&ipbypass=yes&met=1739467613,&mh=_l&mip=182.253.54.115&mm=29&mn=sn-npoeeney&ms=rdu&mt=1739467272&mv=m&mvi=4&pl=24&lsparams=ipbypass,met,mh,mip,mm,mn,ms,mv,mvi,pl,rms&lsig=AGluJ3MwRAIgMtArNTkprRnS3Fv9lO5vH1kYF2sO0p-hZa8Qa8nYbKcCIBgq7q9QyPvdcUjdW0mn9wW4nRKeddXyCh3ocplmJk6o';

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
