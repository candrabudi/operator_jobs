<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BoostReport;
use App\Models\BoostReportMedia;
use App\Models\RequestBoosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperatorRequestBoostController extends Controller
{
    public function index()
    {
        return view('operator.boosts.index');
    }

    public function list()
    {
        $user = Auth::user();
        $requestPosts = RequestBoosting::where('user_id', $user->id)
            ->with('socialMediaPlatform', 'socialMediaPlatformLimit')
            ->paginate(25);

        return response()->json($requestPosts);
    }

    public function report($a)
    {
        $requestBoostID = $a;
        $existingReport = BoostReport::where('request_boost_id', $requestBoostID)->first();

        if ($existingReport) {
            return view('operator.boosts.report', compact('requestBoostID', 'existingReport'));
        } else {
            return view('operator.boosts.report', compact('requestBoostID', 'existingReport'));
        }
    }


    public function storeReport(Request $request)
    {
        $request->validate([
            'request_boost_id' => 'required|integer',
            'report_title' => 'required|string|max:255',
            'report_content' => 'required|string|max:500',
            'mediaFiles.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,doc,docx,pdf|max:10240',
        ]);

        $postingReport = BoostReport::updateOrCreate(
            ['request_boost_id' => $request->input('request_boost_id')],
            [
                'report_title' => $request->input('report_title'),
                'report_content' => $request->input('report_content')
            ]
        );

        if ($request->hasFile('mediaFiles')) {
            foreach ($request->file('mediaFiles') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('public/posting_report_media', $fileName);

                BoostReportMedia::create([
                    'boost_report_id' => $postingReport->id,
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                ]);
            }
        }

        RequestBoosting::where('id', $request->input('request_boost_id'))
            ->update([
                'status' => 'completed'
            ]);

        return redirect()->route('system.operator.request.posts')->with('success', 'Posting report ' . (isset($request->id) ? 'updated' : 'created') . ' successfully.');
    }

    public function updateReport (Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'report_title' => 'required|string|max:255',
            'report_content' => 'required|string|max:500',
            'mediaFiles.*' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,mp4,mov,pdf,doc,docx',
        ]);

        $postingReport = BoostReport::find($id);

        if (!$postingReport) {
            return redirect()->back()->with('error', 'Report not found.');
        }

        $postingReport->report_title = $request->report_title;
        $postingReport->report_content = $request->report_content;
        $postingReport->save();

        if ($request->hasFile('mediaFiles')) {
            foreach ($request->file('mediaFiles') as $mediaFile) {
                $filePath = $mediaFile->store('media', 'public');

                BoostReportMedia::create([
                    'boost_report_id' => $postingReport->id,
                    'file_name' => $mediaFile->getClientOriginalName(),
                    'file_path' => $filePath,
                ]);
            }
        }

        return redirect()->route('system.operator.request.posts', $postingReport->id)
            ->with('success', 'Report updated successfully.');
    }

}
