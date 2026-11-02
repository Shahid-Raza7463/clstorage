<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogsWebController extends Controller
{
    public function index(Request $request)
    {
        $blogs = DB::table('blogs')->paginate(15);
        return view('web.pages.blogs.blogs', [
            'blogs' => $blogs,
        ]);
    }
}
