<?php

namespace App\Http\Controllers;

use App\Bookmark;
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

    public function index(){
        $bookmarks = Bookmark::where('user_id', auth()->user()->id)->paginate(6);
        return response()->json(['Bookmarks' => $bookmarks], 201);
    }
}
