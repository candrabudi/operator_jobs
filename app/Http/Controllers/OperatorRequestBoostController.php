<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BoostReport;
use App\Models\BoostReportMedia;
use App\Models\RequestBoost;
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
        $requestBoosts = RequestBoost::with('platform', 'engagement')
        ->paginate(25);

        return response()->json($requestBoosts);
    }

    public function updateToCompleted($a)
    {
        $requestBoost = RequestBoost::where('id', $a)
            ->where('status', 'pending')
            ->first();

        if(!$requestBoost) {
            return response()
                ->json([
                    'status' => 'failed', 
                    'code' => 404,
                    'message' => 'No Data Found.' 
                ], 400);
        }

        $requestBoost->status = 'completed';
        $requestBoost->save();

        return response()
                ->json([
                    'status' => 'success', 
                    'code' => 200,
                    'message' => 'Success update to completed status.' 
                ], 200);
    }
}
