<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogsViewWebController extends Controller
{
    public function index(Request $request, $slug)
    {
        $blogsview = DB::table('blogs')
            ->where('slug', $slug)
            ->first();

        return view('web.pages.blogsview.blogsview', [
            'blogsview' => $blogsview,
        ]);
    }
}
