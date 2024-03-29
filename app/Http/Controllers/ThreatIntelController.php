<?php

namespace App\Http\Controllers;

use App\ThreatIntel;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ThreatIntelController extends Controller
{
    public function index()
    {
        $threat_intels = ThreatIntel::orderBy('time', 'desc')->paginate(6);
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
        $results = ThreatIntel::orderBy('id', 'DESC')->paginate(6);
        return Response()->json($results, 200);
    }

    public function orderbyAlias()
    {
        $results = ThreatIntel::orderBy('id', 'ASC')->paginate(6);
        return Response()->json($results, 200);
    }

    public function orderbyReal_Name()
    {
        $results = ThreatIntel::orderBy('real_name', 'ASC')->paginate(6);
        return Response()->json($results, 200);
    }

    public function sort24hrs($value)
    {
        $records = ThreatIntel::where('time', '>=', Carbon::now()->subDays($value))->paginate(6);
        $records = $records->reverse();
        return Response()->json($records, 200);
    }

    public function sort7days($value)
    {
        $records = ThreatIntel::where('time', '>=', Carbon::now()->subDays($value))->paginate(6);
        $records = $records->reverse();
        return Response()->json($records, 200);
    }

    public function sortMonth($value)
    {
        $records = ThreatIntel::where('time', '>=', Carbon::now()->subMonths($value))->paginate(6);
        return Response()->json($records, 200);
    }

    public function anytime($value){
        $records = ThreatIntel::where('time', '>=', Carbon::now()->subDays($value))->paginate(6);
        return Response()->json($records, 200);   
    }

    public function uniqueSource()
    {
        $sources = ThreatIntel::distinct('source')->pluck('source');
        return Response()->json($sources, 200);
    }

    public function uniqueGeolocation()
    {
        $geolocations = ThreatIntel::distinct('geolocation')->pluck('geolocation');
        return Response()->json($geolocations, 200);
    }

    public function multiSearch(Request $request)
    {
        $threat_intels = ThreatIntel::query();

        if ($request->filled('source')) {
            $threat_intels->where('source', 'LIKE', "%{$request->input('source')}%");
        }

        if ($request->filled('source') && $request->filled('geolocation')) {
            $threat_intels->where('source', 'LIKE', "%{$request->input('source')}%")->Where('geolocation', 'LIKE', "%{$request->input('geolocation')}%")->get();;
        }

        if ($request->filled('geolocation')) {
            $threat_intels->orWhere('geolocation', 'LIKE', "%{$request->input('geolocation')}%");
        }

        if ($request->filled('all')) {
            $threat_intels;
        }

        if ($request->filled('all') && $request->filled('geolocation')) {
            $threat_intels->where('source', 'LIKE', "%{$request->input('geolocation')}%");
        }

        if ($request->filled('all') && $request->filled('source')) {
            $threat_intels->where('source', 'LIKE', "%{$request->input('source')}%");
        }

        return Response()->json(['Threat Intels' => $threat_intels->get()], 200);
    }

}
