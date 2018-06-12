<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFavouriteController extends Controller
{
     public function store(Request $request, $id)
    {
        \Auth::user()->favourites($id);
        return redirect()->back();
    }

    public function destroy($id)
    {
        \Auth::user()->unfavourites($id);
        return redirect()->back();
    }
}
