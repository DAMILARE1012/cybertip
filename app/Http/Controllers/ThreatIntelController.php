<?php

namespace App\Http\Controllers;

use App\ThreatIntel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ThreatIntelController extends Controller
{
    public function index()
    {
        $threat_intels = ThreatIntel::paginate(10);
        return response()->json($threat_intels, 200);
    }

    public function search($name)
    {
        $result = ThreatIntel::where('real_name', 'LIKE', '%' . $name . '%')->orWhere('alias', 'like', '%' . $name . '%')->get();
        if (count($result)) {
            return Response()->json($result);
        } else {
            return response()->json(['Message' => 'Record not found!'], 404);
        }
    }

    public function filterDate()
    {
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $data = ThreatIntel::whereBetween('time', [$start_date, $end_date])->get();
        } else {
            $data = ThreatIntel::latest()->get();
        }

        return Response()->json($data, 200);
    }

    public function orderByID()
    {
        $results = ThreatIntel::orderBy('id', 'DESC')->get();
        return Response()->json($results, 200);
    }

    public function orderbyAlias()
    {
        $results = ThreatIntel::orderBy('id', 'ASC')->get();
        return Response()->json($results, 200);
    }

    public function orderbyReal_Name()
    {
        $results = ThreatIntel::orderBy('real_name', 'ASC')->get();
        return Response()->json($results, 200);
    }
}
