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

        // $name = $request->get('search');

        // if($request->has('search')){
        //     $result = ThreatIntel::where('real_name', 'LIKE', '%' . $name . '%')->orWhere('alias', 'like', '%' . $name . '%')->get();
        //     return response()->json($result, 200);
        // }else {
        //     return response()->json(['Message' => 'Record not found!'], 404);
        // }
    }

    public function filterDate(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        if ($request->has('start_date') && $request->has('end_date')) {
            $data = ThreatIntel::whereBetween("time", [$startDate, $endDate])->get();
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
