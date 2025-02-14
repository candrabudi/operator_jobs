<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PostingReport;
use App\Models\PostingReportMedia;
use App\Models\RequestPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperatorRequestPostController extends Controller
{
    public function index()
    {
        return view('operator.posts.index');
    }

    public function list()
    {
        $user = Auth::user();
        $requestPosts = RequestPosting::where('user_id', $user->id)
            ->with('requestMediaPosts', 'platform')
            ->paginate(25);

        return response()->json($requestPosts);
    }

    public function report($a)
    {
        $requestPostID = $a;
        $existingReport = PostingReport::where('request_posting_id', $requestPostID)->first();

        if ($existingReport) {
            return view('operator.posts.report', compact('requestPostID', 'existingReport'));
        } else {
            return view('operator.posts.report', compact('requestPostID', 'existingReport'));
        }
    }


    public function storeReport(Request $request)
    {
        $request->validate([
            'request_posting_id' => 'required|integer',
            'report_title' => 'required|string|max:255',
            'report_content' => 'required|string|max:500',
            'mediaFiles.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,doc,docx,pdf|max:10240',
        ]);

        // Check if the report already exists
        $postingReport = PostingReport::updateOrCreate(
            ['request_posting_id' => $request->input('request_posting_id')],
            [
                'report_title' => $request->input('report_title'),
                'report_content' => $request->input('report_content')
            ]
        );

        if ($request->hasFile('mediaFiles')) {
            foreach ($request->file('mediaFiles') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('public/posting_report_media', $fileName);

                PostingReportMedia::create([
                    'posting_report_id' => $postingReport->id,
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                ]);
            }
        }

        RequestPosting::where('id', $request->input('request_posting_id'))
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

        $postingReport = PostingReport::find($id);

        if (!$postingReport) {
            return redirect()->back()->with('error', 'Report not found.');
        }

        $postingReport->report_title = $request->report_title;
        $postingReport->report_content = $request->report_content;
        $postingReport->save();

        if ($request->hasFile('mediaFiles')) {
            foreach ($request->file('mediaFiles') as $mediaFile) {
                $filePath = $mediaFile->store('media', 'public');

                PostingReportMedia::create([
                    'posting_report_id' => $postingReport->id,
                    'file_name' => $mediaFile->getClientOriginalName(),
                    'file_path' => $filePath,
                ]);
            }
        }

        return redirect()->route('system.operator.request.posts', $postingReport->id)
            ->with('success', 'Report updated successfully.');
    }



    public function detail($a)
    {
        $posts = RequestPosting::where('id', $a)
            ->first();
        return view('operator.posts.detail', compact('posts'));
    }
}
