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
        return response()->json(['Bookmarks' => $bookmarks], 201);
    }

    public function indexFull()
    {
        $bookmarks = Bookmark::all();
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

    public function sortLast5days()
    {
        $last_5_days = Bookmark::where('created_at', '>=', Carbon::now()->subdays(5))->paginate(6);
        $last_5_days = $last_5_days->reverse();
        return Response()->json($last_5_days, 200);
    }

    public function sortlast7days()
    {
        $last_7_days = Bookmark::where('created_at', '>=', Carbon::now()->subdays(7))->paginate(6);
        $last_7_days = $last_7_days->reverse();
        return Response()->json($last_7_days, 200);
    }
}
