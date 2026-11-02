@extends('Admin.template')

@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">Contact Message</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-sm btn-success">All</a>
                </div>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $contact->name }}</p>
                <p><strong>Email:</strong> {{ $contact->email }}</p>
                <p><strong>Subject:</strong> {{ $contact->subject }}</p>
                <p><strong>Message:</strong></p>
                <p>{{ $contact->message }}</p>
            </div>
        </div>
    </div>
@endsection
