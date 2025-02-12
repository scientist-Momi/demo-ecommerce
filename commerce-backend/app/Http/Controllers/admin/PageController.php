<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return response()->json($pages);
    }

    public function addPage(Request $request)
    {
        $page = Page::create([
            'name' => $request->input('name')
        ]);

        return response()->json($page);
    }


}
