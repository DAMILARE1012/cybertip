<?php

namespace App\Http\Controllers;

use App\Bookmark;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookmarkController extends Controller
{
    public function store(Request $request)
    {
        $bookmark = new Bookmark();

        $bookmark->user_id = auth()->user()->id;
        $bookmark->alias = $request->get('alias');
        $bookmark->real_name = $request->get('real_name');
        $bookmark->post = $request->get('post');
        $bookmark->url = $request->get('url');
        $bookmark->time = $request->get('time');
        $bookmark->geolocation = $request->get('geolocation');
        $bookmark->source = $request->get('source');

        $bookmark->save();

        return response()->json(['message' => 'Your information has been successfully bookmarked. Thanks'], 201);
    }

    public function index()
    {
        $bookmarks = Bookmark::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(6);
        return response()->json(['Bookmarks' => $bookmarks], 200);
    }

    public function indexFull()
    {
        $bookmarks = Bookmark::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return response()->json($bookmarks, 200);
    }

    public function removeBookmark($id)
    {
        $bookmark = Bookmark::findOrFail($id);
        $bookmark->delete();
        return response()->json(['message' => 'Post successfully removed.....']);
    }


    public function search($name)
    {
        $result = Bookmark::where('real_name', 'LIKE', '%' . $name . '%')->orWhere('alias', 'like', '%' . $name . '%')->get();
        if (count($result)) {
            return Response()->json($result);
        } else {
            return response()->json(['Message' => 'Record not found!'], 404);
        }
    }

    public function sort24hrs($value)
    {
        $records = Bookmark::where('user_id', auth()->user()->id)->where('time', '>=', Carbon::now()->subDays($value))->paginate(6);
        $records = $records->reverse();
        return Response()->json($records, 200);
    }

    public function sort7days($value)
    {
        $records = Bookmark::where('user_id', auth()->user()->id)->where('time', '>=', Carbon::now()->subDays($value))->paginate(6);
        $records = $records->reverse();
        return Response()->json($records, 200);
    }

    public function sortMonth($value)
    {
        $records = Bookmark::where('user_id', auth()->user()->id)->where('time', '>=', Carbon::now()->subMonths($value))->paginate(6);
        return Response()->json($records, 200);
    }

    public function anytime($value)
    {
        $records = Bookmark::where('user_id', auth()->user()->id)->where('time', '>=', Carbon::now()->subDays($value))->paginate(6);
        return Response()->json($records, 200);
    }
}
