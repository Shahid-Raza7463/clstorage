<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Web\ContactUs;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(): View
    {
        $messages = ContactUs::latest('id')->paginate(20);

        return view('Admin.portfolio.contacts.index', compact('messages'));
    }

    public function show(int $contactMessage): View
    {
        $contact = ContactUs::findOrFail($contactMessage);

        return view('Admin.portfolio.contacts.show', compact('contact'));
    }

    public function destroy(int $contactMessage): RedirectResponse
    {
        $contact = ContactUs::findOrFail($contactMessage);
        $contact->delete();

        return redirect()->route('admin.contact-messages.index')->with('message', 'Message deleted');
    }
}
