<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Web\ContactUs;
use Dotenv\Validator;
use Illuminate\Http\Request;

class ContactUsWebController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' =>  "required|string",
            'email' =>  "required|email",
            'subject' =>  "required",
            'message' =>  "required"
        ]);

        $contact  = $request->all();
        ContactUs::create($contact);

        // $output = 'Thanks, Shahid Raza will contact you soon.';
        // return back()->with('success', $output);
        // return response()->json(['success' => true, 'msg' => 'Thanks, Shahid Raza will contact you soon']);
        return response()->json(['success' => true,]);
    }

    public function download(Request $request, $name)
    {
        $path = public_path('assets/img/' . $name);
        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }
        return response()->download($path);
    }
}
