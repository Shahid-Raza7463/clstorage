@extends('backEnd.layouts.layout')
@section('backEnd_content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>All Folder Download</small>
                </div>
            </div>
        </div>
    </div>
    <div class="body-content">
        <div class="card mb-4">
            @component('backEnd.components.alert')
            @endcomponent
            {{-- style of card body --}}
            <style>
                .card-body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    flex-direction: column;
                }
            </style>
            <div class="card-body">
                @if (!isset($message))
                    <div>
                        <button type="button" id="downloadButton" class="btn btn-outline-primary">Create Zip
                            File</button>
                    </div>
                @endif
                @if (isset($message))
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @endif
                <div class="row">
                    {{-- waiting message  --}}
                    <div id="loadingMessage" style="display:none; margin-bottom: 10px;" class="text-success">
                        Creating your zip file. Please wait...
                    </div>
                    {{-- display file name that was created --}}
                    <div id="createdzipfile" style="display:none; margin-bottom: 10px;">
                    </div>
                </div>
                <div class="row">
                    <div>
                        <a href="{{ route('createdzipdownload', ['assignmentgenerateid' => $assignmentgenerateid]) }}"
                            class="btn btn-success" style="color:white; display:none;" id="downloadzip">Download
                            zip file</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Create Zip file button click then
        $('#downloadButton').click(function(e) {
            e.preventDefault();
            var assignmentgenerateid1 = '{{ $assignmentgenerateid }}';

            // Show waiting message
            $('#loadingMessage').show();
            // Create Zip file button hide 
            $('#downloadButton').hide();

            $.ajax({
                type: 'GET',
                url: '/createzipfolder',
                data: {
                    assignmentgenerateid: assignmentgenerateid1,
                },
                success: function(data) {
                    // Hide waiting message
                    $('#loadingMessage').hide();
                    // Display created zip file name
                    $('#createdzipfile').text('Created Zip File: ' + data).show();
                    $('#downloadzip').show();

                },
                // handle error
                error: function(error) {

                    // $('#loadingMessage').hide();
                    // console.error(error);
                    alert('hi');
                }
            });
        });
    });
</script>
