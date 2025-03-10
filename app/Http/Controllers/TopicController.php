<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index()
    {
        return view('topics.index');
    }

    public function list()
    {
        $topics = Topic::all();
        return response()->json($topics);
    }

    public function store(Request $request)
    {
        $request->validate([
            'topic_name' => 'required|string|max:255',
        ]);

        $topic = Topic::create($request->only('topic_name'));
        return response()->json(['message' => 'Topic created successfully', 'topic' => $topic]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'topic_name' => 'required|string|max:255',
        ]);

        $topic = Topic::find($id);
        if ($topic) {
            $topic->update($request->only('topic_name'));
            return response()->json(['message' => 'Topic updated successfully', 'topic' => $topic]);
        }
        return response()->json(['message' => 'Topic not found'], 404);
    }

    public function destroy($id)
    {
        $topic = Topic::find($id);
        if ($topic) {
            $topic->delete();
            return response()->json(['message' => 'Topic deleted successfully']);
        }
        return response()->json(['message' => 'Topic not found'], 404);
    }
}
