<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RequestBoosting;
use App\Models\SocialMediaPlatform;
use App\Models\SocialMediaLimit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class RequestBoostingController extends Controller
{
    public function index(Request $request)
    {
        return view('super.boost.index');
    }

    public function list()
    {
        $requestBoosts = RequestBoosting::with('socialMediaPlatform', 'socialMediaPlatformLimit')
            ->paginate(25);

        return response()->json($requestBoosts);
    }

    public function create()
    {
        $socialMedias = SocialMediaPlatform::all();
        $boostLimits = SocialMediaLimit::all();

        $operators = User::whereNotIn('role', ['superadmin', 'admin'])
            ->get();

        return view('super.boost.create', compact('socialMedias', 'boostLimits', 'operators'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'social_media_platform_id' => 'required|integer',
            'social_media_platform_limit_id' => 'required|integer',
            'link_post' => 'required|string',
            'qty' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $requestBoost = new RequestBoosting();
        $requestBoost->user_id = $request->user_id;
        $requestBoost->social_media_platform_id = $request->social_media_platform_id;
        $requestBoost->social_media_platform_limit_id = $request->social_media_platform_limit_id;
        $requestBoost->trx_boost = strtoupper(uniqid('trx_'));
        $requestBoost->link_post = $request->link_post;
        $requestBoost->notes = $request->content ?? '-';
        $requestBoost->comment = $request->comment;
        $requestBoost->qty = $request->qty;
        $requestBoost->status = 'pending';
        $requestBoost->save();

        $operator = User::where('id', $request->user_id)
            ->first();

        $dateRequest = Carbon::parse($requestBoost->created_at)->format('Y/m/d H:i:s');
        $socialMediaPlatform = SocialMediaPlatform::where('id', $request->social_media_platform_id)
            ->first();

        $socialMediaPlatformLimit = SocialMediaLimit::where('id', $request->social_media_platform_limit_id)
            ->first();

        $status = strtoupper($requestBoost->status);

        $message = "
            NOMOR TRX: *{$requestBoost->trx_boost}* \nOPERATOR: *{$operator->full_name}* \nTIPE REQUEST: *BOOSTING* \nTOTAL BOOSTING: *{$request->qty}* \nSOCIAL MEDIA: *{$socialMediaPlatform->social_media_name}* \nBOOSTING TYPE: *{$socialMediaPlatformLimit->platform_type}* \nLINK POST: {$request->link_post} \nTANGGAL REQUEST: *{$dateRequest}* \nSTATUS: *{$status}* \n\n*MOHON BANTUANNYA UNTUK MELAKUKAN BOOSTING MENGENAI REQUEST DARI PUSAT*";

        Http::get('https://whatsapp.xn--v3cud6b6c.systems/send-message', [
            'api_key' => 'YelYqpUlZjESa077DpL3PP2kjyIBL1',
            'sender' => '6285229931237',
            'number' => $operator->phone_number,
            'message' => $message,
        ]);

        return redirect()->route('system.request.boosts.index');
    }

    public function edit($id)
    {
        $boost = RequestBoosting::with('socialMediaPlatform', 'socialMediaPlatformLimit')->findOrFail($id);
        $socialMedias = SocialMediaPlatform::all();
        $boostLimits = SocialMediaLimit::all();
        $operators = User::whereNotIn('role', ['superadmin', 'admin'])
        ->get();
        return view('super.boost.edit', compact('boost', 'socialMedias', 'boostLimits', 'operators'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'social_media_platform_id' => 'required|integer',
            'social_media_platform_limit_id' => 'required|integer',
            'link_post' => 'required|string',
            'qty' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $requestBoost = RequestBoosting::findOrFail($id);
        $requestBoost->user_id = $request->user_id;
        $requestBoost->social_media_platform_id = $request->social_media_platform_id;
        $requestBoost->social_media_platform_limit_id = $request->social_media_platform_limit_id;
        $requestBoost->link_post = $request->link_post;
        $requestBoost->notes = $request->content ?? '-';
        $requestBoost->comment = $request->comment;
        $requestBoost->qty = $request->qty;
        $requestBoost->status = 'pending';
        $requestBoost->save();

        return redirect()->route('system.request.boosts.index')->with('success', 'Request boost updated successfully.');
    }

    public function destroy($id)
    {
        $boost = RequestBoosting::findOrFail($id);
        $boost->delete();

        return response()->json(['message' => 'Request boost deleted successfully.']);
    }

    public function getBoostLimits($platformId)
    {
        $boostLimits = SocialMediaLimit::where('social_media_platform_id', $platformId)->get();

        return response()->json($boostLimits);
    }
}
