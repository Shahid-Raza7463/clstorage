  <!--Third party Styles(used by this page)-->
  <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">

  <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">



  @extends('backEnd.layouts.layout') @section('backEnd_content')
      <style>
          .pagination {
              justify-content: center;
          }

          .dt-buttons .btn-group {
              height: 39px;
          }
      </style>

      <style>
          div.dataTables_wrapper div.dataTables_length select {
              width: -webkit-fill-available;
              display: inline-block;
          }

          .dataTables_length {
              margin-left: 10px;
          }

          .btn-secondary {
              color: #fff;
              background-color: #37a000;
              border-color: #37a000;
          }

          .btn-primary:hover {
              color: #fff;
              background-color: #37a000;
              border-color: #1c1f22;
          }

          .btn-primary {
              color: #fff;
              background-color: #37a000;
              border-color: #f9f9f9;
          }

          .toggle.btn {
              min-width: 4.7rem;
              min-height: 2.15rem;
          }
      </style>
      <div class="content-header row align-items-center m-0">
          <!--<nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <li class="breadcrumb-item"><a href="{{ url('assignmenttemplate/' . $assignmentgenerate_id) }}">Template List</a></li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              </ol>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          </nav> -->
          <div class="col-sm-8 header-title p-0">
              <div class="media">
                  <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
                  <div class="media-body">
                      <a href="{{ url('home') }}">
                          <h1 class="font-weight-bold" style="color:black;">Home</h1>
                      </a>
                      <small>Confirmation List</small>
                  </div>
              </div>
          </div>
      </div>
      <div class="body-content">
          <div class="card mb-4">
              @if (session()->has('success'))
                  <div class="alert alert-success">
                      @if (is_array(session()->get('success')))
                          @foreach (session()->get('success') as $message)
                              <p>{{ $message }}</p>
                          @endforeach
                      @else
                          <p>{{ session()->get('success') }}</p>
                      @endif
                  </div>
              @else
                  @if ($errors->any())
                      <div class="alert alert-danger">
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                  @endif
              @endif


              {{-- @php
                  dd($clientList);
                      "balanceconfirmationstatus" => 0
              @endphp --}}
              <div class="card-header" style="background: #37A000;margin-top: -16px;">

                  <div class="d-flex justify-content-between align-items-center">

                      <div>
                          <h6 style="color:white;" class="fs-17 font-weight-600 mb-0">
                              {{ ucfirst($clientList->assignmentname) ?? '' }}</h6>
                      </div>

                      {{-- <div>
                          <span style="color:white;" class="fs-17 font-weight-600 mb-0">
                              Confirmation:</span>
                          @if ($clientList->balanceconfirmationstatus == 1)
                              <a style="color:white;" class="fs-17 font-weight-600 mb-0"
                                  onclick="return confirm('Are you sure ?');"
                                  href="{{ url('/confirmationstatus?' . 'assignmentid=' . $clientList->assignmentgenerate_id . '&&' . 'status=' . 0) }}"><span
                                      class="badge badge-primary">OPEN</span></a>
                          @else
                              <a style="color:white;" class="fs-17 font-weight-600 mb-0"
                                  onclick="return confirm('Are you sure ?');"
                                  href="{{ url('/confirmationstatus?' . 'assignmentid=' . $clientList->assignmentgenerate_id . '&&' . 'status=' . 1) }}">
                                  <span class="badge badge-danger">CLOSED</span></a>
                          @endif
                      </div> --}}


                      {{-- 
                      <div>
                          <span style="color:white;" class="fs-17 font-weight-600 mb-0">
                              Confirmation:</span>
                          <input type="checkbox" id="toggle-status-{{ $clientList->id }}"
                              {{ $clientList->balanceconfirmationstatus ? 'checked' : '' }} data-toggle="toggle"
                              data-style="ios" data-id="{{ $clientList->id }}" data-on="Open" data-off="Close"
                              data-onstyle="info" data-offstyle="danger">
                      </div> --}}
                      <div>
                          <span style="color:white;" class="fs-17 font-weight-600 mb-0">Confirmation:</span>
                          <input type="checkbox" id="toggle-status-{{ $clientList->id }}"
                              {{ $clientList->balanceconfirmationstatus ? 'checked' : '' }} data-toggle="toggle"
                              data-style="ios" data-id="{{ $clientList->id }}" data-on="Open" data-off="Close"
                              data-onstyle="info" data-offstyle="danger" onchange="updateConfirmationStatus(this)">
                      </div>
                  </div>
              </div>
              <div>
                  <div class="alert alert-success" id="successmessage" style="display: none;">
                      <p></p>
                  </div>
                  @if (session()->has('success'))
                      <div class="alert alert-success">
                          @if (is_array(session()->get('success')))
                              @foreach (session()->get('success') as $message)
                                  <p>{{ $message }}</p>
                              @endforeach
                          @else
                              <p>{{ session()->get('success') }}</p>
                          @endif
                      </div>
                  @endif
                  @if (session()->has('statuss'))
                      <div class="alert alert-danger">
                          @if (is_array(session()->get('statuss')))
                              @foreach (session()->get('statuss') as $message)
                                  <p>{{ $message }}</p>
                              @endforeach
                          @else
                              <p>{{ session()->get('success') }}</p>
                          @endif
                      </div>
                  @endif
                  @if (session()->has('statusss'))
                      <div class="alert alert-success">
                          @if (is_array(session()->get('statusss')))
                              @foreach (session()->get('statusss') as $message)
                                  <p>{{ $message }}</p>
                              @endforeach
                          @else
                              <p>{{ session()->get('success') }}</p>
                          @endif
                      </div>
                  @endif
                  <div>

                  </div>
              </div>
              <!-- Message container -->
              <div class="alert alert-success" id="message-container" style="display: none;">
                  @if (is_array(session()->get('success')))
                      @foreach (session()->get('success') as $message)
                          <p id="message-text"></p>
                      @endforeach
                  @else
                      <p id="message-text"></p>
                  @endif
              </div>

              <div class="card-body">
                  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                      <li class="nav-item">
                          <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                              role="tab" aria-controls="pills-home" aria-selected="true">Debtor</a>
                      </li>

                      <li class="nav-item">
                          <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab"
                              aria-controls="pills-contact" aria-selected="false">Creditor</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab"
                              aria-controls="pills-user" aria-selected="false">Bank</a>
                      </li>
                  </ul>
                  <div class="tab-content" id="pills-tabContent">
                      <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                          aria-labelledby="pills-home-tab">
                          <div class="table-responsive">
                              <br>
                              @if ($clientList->balanceconfirmationstatus == 1)
                                  @php
                                      $disabled = '';
                                  @endphp
                              @else
                                  @php
                                      $disabled = 'disabled';
                                  @endphp
                              @endif
                              {{-- @if ($clientList->balanceconfirmationstatus == 1) --}}
                              {{-- <div class="card-head" style="width:830px;height: 10px;">
                                  <b style="float:left;margin-top: -17px;"> <a id="sendButton" data-toggle="modal"
                                          data-target=".exampleModal155-modal-lg"
                                          class="btn btn-info-soft btn-sm {{ $disabled }}">Send<i
                                              class="fas fa-envelope"></i></a></b>

                                  <b style="margin-left: 10px;float:left;margin-top: -17px;"> <a data-toggle="modal"
                                          data-target=".exampleModal1556-modal-lg"
                                          class="btn btn-info-soft btn-sm {{ $disabled }}">Upload
                                          Confirmation File <i class="fa fa-plus"></i></a></b>
                              </div>  --}}
                              <div class="card-head" style="width:830px;height: 10px;">
                                  <b style="float:left;margin-top: -17px;">
                                      <a id="sendButton" data-toggle="modal" data-target=".exampleModal155-modal-lg"
                                          class="btn btn-info-soft btn-sm {{ $disabled }}">Send<i
                                              class="fas fa-envelope"></i></a>
                                  </b>
                                  <b style="margin-left: 10px;float:left;margin-top: -17px;">
                                      <a id="uploadButton" data-toggle="modal" data-target=".exampleModal1556-modal-lg"
                                          class="btn btn-info-soft btn-sm {{ $disabled }}">Upload Confirmation File <i
                                              class="fa fa-plus"></i></a>
                                  </b>
                              </div>
                              {{-- @endif --}}
                              <hr>
                              <table id="examplee" class="display nowrap">
                                  <thead>
                                      <tr>
                                          <th style="display: none;">id</th>
                                          @if ($clientList->balanceconfirmationstatus == 1)
                                              <th><input type="checkbox" id="masterCheckbox" class="check-all"></th>
                                          @endif
                                          <th>Unique No.</th>
                                          <th>Name</th>
                                          <th class="text-right">
                                              Amount
                                          </th>
                                          @if ($clientList->balanceconfirmationstatus == 1)
                                              <th class="text-right"> <input type="checkbox"
                                                      class="debtor-status-toggle-master" id="toggle-all-statuses"
                                                      data-toggle="toggle" data-style="ios" data-on=" Show"
                                                      data-off=" Hide"></th>
                                          @else
                                              <th>Show/Hide</th>
                                          @endif
                                          <th>Year</th>
                                          <th>Date</th>
                                          <th>Address</th>
                                          <th>Primary Email</th>
                                          <th>Secondary Email</th>
                                          <th>Entity Name</th>
                                          <th>Email Status</th>
                                          <th>Confirmation Status</th>
                                          <th>Created By</th>
                                          <th>Remark</th>
                                          <th>Amount</th>
                                          <th>Attachment</th>
                                          <th>Edit</th>
                                          <th>Delete</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($clientdebit as $clientdebitdata)
                                          <tr>
                                              <td style="display: none;">{{ $clientdebitdata->id }}</td>

                                              @if ($clientList->balanceconfirmationstatus == 1)
                                                  <td>
                                                      @if ($clientdebitdata->status == 2)
                                                          <input style="font-size:4px;" type="checkbox" name="approve[]"
                                                              value="{{ $clientdebitdata->id }}">
                                                      @else
                                                      @endif
                                                  </td>
                                              @endif
                                              <td>{{ $clientdebitdata->unique }}</td>
                                              <td>{{ ucfirst($clientdebitdata->name) }}</td>
                                              <td class="text-right">
                                                  {{ $clientdebitdata->amount }}
                                              </td>
                                              <td class="text-right">
                                                  @if ($clientdebitdata->status != 2)
                                                      @if ($clientdebitdata->amounthidestatus == 1)
                                                          <span> Show </span>
                                                      @else
                                                          <span> Hide </span>
                                                      @endif
                                                  @endif
                                                  @if ($clientList->balanceconfirmationstatus == 1)
                                                      @if ($clientdebitdata->status == 2)
                                                          <input type="checkbox" class="debtor-status-toggle"
                                                              id="toggle-status-{{ $clientdebitdata->id }}"
                                                              {{ $clientdebitdata->amounthidestatus ? 'checked' : '' }}
                                                              data-toggle="toggle" data-style="ios"
                                                              data-id="{{ $clientdebitdata->id }}" data-on=" Show"
                                                              data-off=" Hide">
                                                      @endif
                                                  @endif
                                              </td>
                                              <td>{{ $clientdebitdata->year }}</td>
                                              @if ($clientdebitdata->date != null)
                                                  {{-- <td>{{ date('F d,Y', strtotime($clientdebitdata->date)) }}</td> --}}
                                                  <td>{{ \Carbon\Carbon::createFromFormat('d/m/Y', $clientdebitdata->date)->format('F d, Y') }}
                                                  </td>
                                              @else
                                                  <td></td>
                                              @endif
                                              <td>{{ $clientdebitdata->address }}</td>
                                              <td><a
                                                      href="mail:={{ $clientdebitdata->email }}">{{ $clientdebitdata->email }}</a>
                                              </td>
                                              <td><a
                                                      href="mail:={{ $clientdebitdata->secondaryemail }}">{{ $clientdebitdata->secondaryemail }}</a>
                                              </td>
                                              <td>{{ $clientdebitdata->entityname }}</td>
                                              <td>
                                                  @if ($clientdebitdata->mailstatus == 1)
                                                      <span>Sent</span>
                                                  @elseif($clientdebitdata->mailstatus == 2)
                                                      <span>Failed</span>
                                                  @else
                                                      <span>Not Sent</span>
                                                  @endif
                                              </td>
                                              <td>
                                                  @if ($clientdebitdata->status == 0)
                                                      <span class="badge badge-pill badge-danger">Not Confirmed</span>
                                                  @elseif($clientdebitdata->status == 2)
                                                      <span class="badge badge-pill badge-Warning">Draft</span>
                                                  @elseif($clientdebitdata->status == 3)
                                                      <span class="badge badge-pill badge-info">Pending</span>
                                                  @else
                                                      <span class="badge badge-pill badge-success">Confirmed</span>
                                                  @endif
                                                  @if ($clientList->balanceconfirmationstatus == 1)
                                                      @if ($clientdebitdata->status == 3)
                                                          <a class="editCompanyyyy hide-on-closed" data-toggle="modal"
                                                              data-id="{{ $clientdebitdata->id }}"
                                                              data-target="#exampleModal1121{{ $loop->index }}"
                                                              title="Send Reminder">
                                                              <span class="typcn typcn-bell"
                                                                  style="font-size: large;color: green;"></span>
                                                          </a>
                                                      @endif
                                                  @endif
                                                  {{-- asa request reminder modal --}}
                                                  <div class="modal fade" id="exampleModal1121{{ $loop->index }}"
                                                      tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
                                                      aria-hidden="true">
                                                      <div class="modal-dialog" role="document">
                                                          <div class="modal-content">
                                                              <div class="modal-header" style="background: #218838;">
                                                                  <h5 style="color:white;"
                                                                      class="modal-title font-weight-600"
                                                                      id="exampleModalLabel4">Send
                                                                      Reminder
                                                                      list</h5>
                                                                  <div>
                                                                      <ul>
                                                                          @foreach ($errors->all() as $e)
                                                                              <li style="color:red;">{{ $e }}
                                                                              </li>
                                                                          @endforeach
                                                                      </ul>
                                                                  </div>
                                                                  <button type="button" class="close"
                                                                      data-dismiss="modal" aria-label="Close">
                                                                      <span aria-hidden="true">&times;</span>
                                                                  </button>
                                                              </div>
                                                              <div class="modal-body">
                                                                  <div class="table-responsive">
                                                                      <table id="reminderTable"
                                                                          class="table display table-bordered table-striped table-hover">
                                                                          <thead>
                                                                              <tr style="background-color: #b6acae;">
                                                                                  <th>Reminder Count</th>
                                                                                  <th>Last Reminder Date</th>
                                                                              </tr>
                                                                          </thead>
                                                                          <tbody id="timesheetTableBody">

                                                                          </tbody>
                                                                      </table>
                                                                  </div>
                                                              </div>
                                                              <div class="modal-footer">
                                                                  <a href="{{ url('assignmentpending/mail', $clientdebitdata->id) }}"
                                                                      class="btn btn-success sendReminderBtn"
                                                                      onclick="return confirm('Are you sure you want to send notification?');">
                                                                      Send
                                                                      Notification</a>
                                                              </div>

                                                          </div>
                                                      </div>
                                                  </div>
                                              </td>
                                              <td>{{ $clientdebitdata->debtorcreatedby->team_member ?? '' }}</td>
                                              <td>{{ $clientdebitdata->debtorconfirm->remark ?? '' }}</td>
                                              <td>{{ $clientdebitdata->debtorconfirm->amount ?? '' }}</td>
                                              <td> <a target="blank"
                                                      href="{{ optional($clientdebitdata->debtorconfirm)->file
                                                          ? url('/backEnd/image/confirmationfile/' . $clientdebitdata->debtorconfirm->file)
                                                          : '' }}">
                                                      {{ optional($clientdebitdata->debtorconfirm)->file ?? '' }}
                                                  </a></td>
                                              <td>
                                                  @if ($clientList->balanceconfirmationstatus == 1)
                                                      @if ($clientdebitdata->mailstatus == 0)
                                                          <a href="{{ url('/entriesedit/' . $clientdebitdata->id) }}"
                                                              class="btn btn-info-soft btn-sm hide-on-closed"><i
                                                                  class="far fa-edit"></i></a>
                                                      @endif
                                                  @endif
                                              </td>
                                              <td>
                                                  @if ($clientList->balanceconfirmationstatus == 1)
                                                      @if ($clientdebitdata->mailstatus == 0)
                                                          <a href="{{ url('/entries/destroy/' . $clientdebitdata->id) }}"
                                                              onclick="return confirm('Are you sure you want to delete this item?');"
                                                              class="btn btn-danger-soft btn-sm hide-on-closed"><i
                                                                  class="far fa-trash-alt"></i></a>
                                                      @endif
                                                  @endif
                                              </td>
                                          </tr>
                                      @endforeach
                                  </tbody>
                              </table>
                          </div>
                      </div>
                      <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                          <div class="table-responsive">
                              <br>
                              {{-- @if ($clientList->balanceconfirmationstatus == 1) --}}
                              {{-- <div class="card-head" style="width:830px;height: 10px;">
                                  <b style="float:left;margin-top: -17px;"> <a id="sendButtons" data-toggle="modal"
                                          data-target=".exampleModal155-modal-lg"
                                          class="btn btn-info-soft btn-sm {{ $disabled }}">Send <i
                                              class="fas fa-envelope"></i></a></b>

                                  <b style="margin-left: 10px;float:left;margin-top: -17px;"> <a data-toggle="modal"
                                          data-target=".exampleModal1556-modal-lg"
                                          class="btn btn-info-soft btn-sm {{ $disabled }}">
                                          Upload Confirmation File <i class="fa fa-plus"></i></a></b>
                              </div> --}}
                              <div class="card-head" style="width:830px;height: 10px;">
                                  <b style="float:left;margin-top: -17px;"> <a id="sendButtons" data-toggle="modal"
                                          data-target=".exampleModal155-modal-lg"
                                          class="btn btn-info-soft btn-sm {{ $disabled }}">Send <i
                                              class="fas fa-envelope"></i></a></b>

                                  <b style="margin-left: 10px;float:left;margin-top: -17px;"> <a id="uploadButtons"
                                          data-toggle="modal" data-target=".exampleModal1556-modal-lg"
                                          class="btn btn-info-soft btn-sm {{ $disabled }}">
                                          Upload Confirmation File <i class="fa fa-plus"></i></a></b>
                              </div>
                              {{-- @endif --}}
                              <hr>

                              <table id="exampleee" class="display nowrap">
                                  <thead>
                                      <tr>
                                          <th style="display: none;">id</th>
                                          @if ($clientList->balanceconfirmationstatus == 1)
                                              <th><input type="checkbox" id="masterCheckboxx" class="check-all"></th>
                                          @endif
                                          <th>Unique No.</th>
                                          <th>Name</th>
                                          <th class="text-right">

                                              Amount

                                          </th>
                                          @if ($clientList->balanceconfirmationstatus == 1)
                                              <th class="text-right"> <input type="checkbox"
                                                      class="creditor-status-toggle-master" id="toggle-all-statuses"
                                                      data-toggle="toggle" data-style="ios" data-on=" Show"
                                                      data-off=" Hide"></th>
                                          @else
                                              <th>Show/Hide</th>
                                          @endif
                                          <th>Year</th>
                                          <th>Date</th>
                                          <th>Address</th>
                                          <th>Primary Email</th>
                                          <th>Secondary Email</th>
                                          <th>Entity Name</th>
                                          <th>Email Status</th>
                                          <th>Confirmation Status</th>
                                          <th>Created By</th>
                                          <th>Remark</th>
                                          <th>Amount</th>
                                          <th>Attachment</th>
                                          <th>Edit</th>
                                          <th>Delete</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($clientcredit as $clientcreditdata)
                                          <tr>
                                              <td style="display: none;">{{ $clientcreditdata->id }}</td>
                                              @if ($clientList->balanceconfirmationstatus == 1)
                                                  <td>
                                                      @if ($clientcreditdata->status == 2)
                                                          <input style="font-size:4px;" type="checkbox" name="approves[]"
                                                              value="{{ $clientcreditdata->id }}">
                                                      @else
                                                      @endif
                                                  </td>
                                              @endif



                                              <td>{{ $clientcreditdata->unique }}</td>
                                              <td>{{ ucfirst($clientcreditdata->name) }}</td>
                                              <td class="text-right">

                                                  {{ $clientcreditdata->amount }}



                                              </td>

                                              <td class="text-right">
                                                  @if ($clientcreditdata->status != 2)
                                                      @if ($clientcreditdata->amounthidestatus == 1)
                                                          <span> Show </span>
                                                      @else
                                                          <span> Hide </span>
                                                      @endif
                                                  @endif
                                                  @if ($clientList->balanceconfirmationstatus == 1)
                                                      @if ($clientcreditdata->status == 2)
                                                          <input type="checkbox" class="creditor-status-toggle"
                                                              id="toggle-status-{{ $clientcreditdata->id }}"
                                                              {{ $clientcreditdata->amounthidestatus ? 'checked' : '' }}
                                                              data-toggle="toggle" data-style="ios"
                                                              data-id="{{ $clientcreditdata->id }}" data-on=" Show"
                                                              data-off=" Hide">
                                                      @endif
                                                  @endif
                                              </td>



                                              <td>{{ $clientcreditdata->year }}</td>
                                              @if ($clientcreditdata->date != null)
                                                  <td>{{ date('F d,Y', strtotime($clientcreditdata->date)) }}</td>
                                              @else
                                                  <td></td>
                                              @endif
                                              <td>{{ $clientcreditdata->address }}</td>
                                              <td><a
                                                      href="mail:={{ $clientcreditdata->email }}">{{ $clientcreditdata->email }}</a>
                                              </td>
                                              <td><a
                                                      href="mail:={{ $clientcreditdata->secondaryemail }}">{{ $clientcreditdata->secondaryemail }}</a>
                                              </td>
                                              <td>{{ $clientcreditdata->entityname }}</td>
                                              <td>
                                                  @if ($clientcreditdata->mailstatus == 1)
                                                      <span>Sent</span>
                                                  @elseif($clientcreditdata->mailstatus == 2)
                                                      <span>Failed</span>
                                                  @else
                                                      <span>Not Sent</span>
                                                  @endif
                                              </td>
                                              <td>
                                                  @if ($clientcreditdata->status == 0)
                                                      <span class="badge badge-pill badge-danger">Not Confirmed</span>
                                                  @elseif($clientcreditdata->status == 2)
                                                      <span class="badge badge-pill badge-Warning">Draft</span>
                                                  @elseif($clientcreditdata->status == 3)
                                                      <span class="badge badge-pill badge-info">Pending</span>
                                                  @else
                                                      <span class="badge badge-pill badge-success">Confirmed</span>
                                                  @endif

                                                  @if ($clientList->balanceconfirmationstatus == 1)
                                                      {{-- bellicon --}}
                                                      @if ($clientcreditdata->status == 3)
                                                          <a class="editCompanyyyy hide-on-closed" data-toggle="modal"
                                                              data-id="{{ $clientcreditdata->id }}"
                                                              data-target="#exampleModal1122{{ $loop->index }}"
                                                              title="Send Reminder">
                                                              <span class="typcn typcn-bell"
                                                                  style="font-size: large;color: green;"></span>
                                                          </a>
                                                      @endif
                                                  @endif



                                                  {{-- asa request reminder modal --}}
                                                  <div class="modal fade" id="exampleModal1122{{ $loop->index }}"
                                                      tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
                                                      aria-hidden="true">
                                                      <div class="modal-dialog" role="document">
                                                          <div class="modal-content">
                                                              <div class="modal-header" style="background: #218838;">
                                                                  <h5 style="color:white;"
                                                                      class="modal-title font-weight-600"
                                                                      id="exampleModalLabel4">Send
                                                                      Reminder
                                                                      list</h5>
                                                                  <div>
                                                                      <ul>
                                                                          @foreach ($errors->all() as $e)
                                                                              <li style="color:red;">{{ $e }}
                                                                              </li>
                                                                          @endforeach
                                                                      </ul>
                                                                  </div>
                                                                  <button type="button" class="close"
                                                                      data-dismiss="modal" aria-label="Close">
                                                                      <span aria-hidden="true">&times;</span>
                                                                  </button>
                                                              </div>
                                                              <div class="modal-body">
                                                                  <div class="table-responsive">
                                                                      <table id="reminderTable"
                                                                          class="table display table-bordered table-striped table-hover">
                                                                          <thead>
                                                                              <tr style="background-color: #b6acae;">
                                                                                  <th>Reminder Count</th>
                                                                                  <th>Last Reminder Date</th>
                                                                              </tr>
                                                                          </thead>
                                                                          <tbody id="timesheetTableBody">

                                                                          </tbody>
                                                                      </table>
                                                                  </div>
                                                              </div>
                                                              <div class="modal-footer">
                                                                  <a href="{{ url('assignmentpending/mail', $clientcreditdata->id) }}"
                                                                      class="btn btn-success sendReminderBtn"
                                                                      onclick="return confirm('Are you sure you want to send notification?');">
                                                                      Send
                                                                      Notification</a>
                                                              </div>

                                                          </div>
                                                      </div>
                                                  </div>

                                              </td>
                                              <td>{{ $clientcreditdata->debtorcreatedby->team_member ?? '' }}</td>
                                              <td>{{ $clientcreditdata->debtorconfirm->remark ?? '' }}</td>
                                              <td>{{ $clientcreditdata->debtorconfirm->amount ?? '' }}</td>


                                              <td> <a target="blank"
                                                      href="{{ optional($clientcreditdata->debtorconfirm)->file
                                                          ? url('/backEnd/image/confirmationfile/' . $clientcreditdata->debtorconfirm->file)
                                                          : '' }}">
                                                      {{ optional($clientcreditdata->debtorconfirm)->file ?? '' }}
                                                  </a></td>

                                              <td>
                                                  @if ($clientList->balanceconfirmationstatus == 1)
                                                      @if ($clientcreditdata->mailstatus == 0)
                                                          <a href="{{ url('/entriesedit/' . $clientcreditdata->id) }}"
                                                              class="btn btn-info-soft btn-sm hide-on-closed"><i
                                                                  class="far fa-edit"></i></a>
                                                      @endif
                                                  @endif
                                              </td>

                                              <td>
                                                  @if ($clientList->balanceconfirmationstatus == 1)
                                                      @if ($clientcreditdata->mailstatus == 0)
                                                          <a href="{{ url('/entries/destroy/' . $clientcreditdata->id) }}"
                                                              onclick="return confirm('Are you sure you want to delete this item?');"
                                                              class="btn btn-danger-soft btn-sm hide-on-closed"><i
                                                                  class="far fa-trash-alt"></i></a>
                                                      @endif
                                                  @endif
                                              </td>
                                          </tr>
                                      @endforeach
                                  </tbody>
                              </table>
                          </div>
                      </div>
                      <div class="tab-pane fade" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
                          <div class="table-responsive">
                              <br>
                              {{-- @if ($clientList->balanceconfirmationstatus == 1) --}}
                              {{-- <div class="card-head" style="width:830px;height: 10px;">
                                  <b style="float:left;margin-top: -17px;"> <a id="sendButtonss" data-toggle="modal"
                                          data-target=".exampleModal155-modal-lg"
                                          class="btn btn-info-soft btn-sm {{ $disabled }}">Send <i
                                              class="fas fa-envelope"></i></a></b>

                                  <b style="margin-left: 10px;float:left;margin-top: -17px;"> <a data-toggle="modal"
                                          data-target=".exampleModal1556-modal-lg"
                                          class="btn btn-info-soft btn-sm {{ $disabled }}">
                                          Upload Confirmation File <i class="fa fa-plus"></i></a></b>
                              </div> --}}
                              <div class="card-head" style="width:830px;height: 10px;">
                                  <b style="float:left;margin-top: -17px;"> <a id="sendButtonss" data-toggle="modal"
                                          data-target=".exampleModal155-modal-lg"
                                          class="btn btn-info-soft btn-sm {{ $disabled }}">Send <i
                                              class="fas fa-envelope"></i></a></b>

                                  <b style="margin-left: 10px;float:left;margin-top: -17px;"> <a id="uploadButtonss"
                                          data-toggle="modal" data-target=".exampleModal1556-modal-lg"
                                          class="btn btn-info-soft btn-sm {{ $disabled }}">
                                          Upload Confirmation File <i class="fa fa-plus"></i></a></b>
                              </div>
                              {{-- @endif --}}
                              <hr>
                              <table id="exampleeee" class="display nowrap">
                                  <thead>
                                      <tr>
                                          <th style="display: none;">id</th>
                                          @if ($clientList->balanceconfirmationstatus == 1)
                                              <th><input type="checkbox" id="masterCheckboxxx" class="check-all"></th>
                                          @endif
                                          <th>Unique No.</th>
                                          <th>Name</th>
                                          <th class="text-right">

                                              Amount

                                          </th>

                                          @if ($clientList->balanceconfirmationstatus == 1)
                                              <th class="text-right"> <input type="checkbox"
                                                      class="bank-status-toggle-master" id="toggle-all-statuses"
                                                      data-toggle="toggle" data-style="ios" data-on=" Show"
                                                      data-off=" Hide"></th>
                                          @else
                                              <th>Show/Hide</th>
                                          @endif

                                          <th>Year</th>
                                          <th>Date</th>
                                          <th>Address</th>
                                          <th>Primary Email</th>
                                          <th>Secondary Email</th>
                                          <th>Entity Name</th>
                                          <th>Email Status</th>
                                          <th>Confirmation Status</th>
                                          <th>Created By</th>
                                          <th>Remark</th>
                                          <th>Amount</th>
                                          <th>Attachment</th>
                                          <th>Edit</th>
                                          <th>Delete</th>
                                      </tr>
                                  </thead>
                                  <tbody>

                                      @foreach ($clientbank as $clientbankdata)
                                          {{-- @php
                                              dd($clientbankdata->id);
                                          @endphp --}}
                                          <tr>
                                              <td style="display: none;">{{ $clientbankdata->id }}</td>
                                              @if ($clientList->balanceconfirmationstatus == 1)
                                                  <td>
                                                      @if ($clientbankdata->status == 2)
                                                          <input style="font-size:4px;" type="checkbox"
                                                              name="approvess[]" value="{{ $clientbankdata->id }}">
                                                      @else
                                                      @endif
                                                  </td>
                                              @endif
                                              <td>{{ $clientbankdata->unique }}</td>
                                              <td>{{ ucfirst($clientbankdata->name) }}</td>
                                              <td class="text-right">


                                                  {{ $clientbankdata->amount }}



                                              </td>

                                              <td class="text-right">
                                                  @if ($clientbankdata->status != 2)
                                                      @if ($clientbankdata->amounthidestatus == 1)
                                                          <span> Show </span>
                                                      @else
                                                          <span> Hide </span>
                                                      @endif
                                                  @endif
                                                  @if ($clientList->balanceconfirmationstatus == 1)
                                                      @if ($clientbankdata->status == 2)
                                                          <input type="checkbox" class="bank-status-toggle"
                                                              id="toggle-status-{{ $clientbankdata->id }}"
                                                              {{ $clientbankdata->amounthidestatus ? 'checked' : '' }}
                                                              data-toggle="toggle" data-style="ios"
                                                              data-id="{{ $clientbankdata->id }}" data-on=" Show"
                                                              data-off=" Hide">
                                                      @endif
                                                  @endif
                                              </td>


                                              <td>{{ $clientbankdata->year }}</td>
                                              @if ($clientbankdata->date != null)
                                                  <td>{{ date('F d,Y', strtotime($clientbankdata->date)) }}</td>
                                              @else
                                                  <td></td>
                                              @endif
                                              <td>{{ $clientbankdata->address }}</td>
                                              <td><a
                                                      href="mail:={{ $clientbankdata->email }}">{{ $clientbankdata->email }}</a>
                                              </td>
                                              <td><a
                                                      href="mail:={{ $clientbankdata->secondaryemail }}">{{ $clientdebitdata->secondaryemail }}</a>
                                              </td>
                                              <td>{{ $clientbankdata->entityname }}</td>
                                              <td>
                                                  @if ($clientbankdata->mailstatus == 1)
                                                      <span>Sent</span>
                                                  @elseif($clientbankdata->mailstatus == 2)
                                                      <span>Failed</span>
                                                  @else
                                                      <span>Not Sent</span>
                                                  @endif
                                              </td>
                                              <td>
                                                  @if ($clientbankdata->status == 0)
                                                      <span class="badge badge-pill badge-danger">Not Confirmed</span>
                                                  @elseif($clientbankdata->status == 2)
                                                      <span class="badge badge-pill badge-Warning">Draft</span>
                                                  @elseif($clientbankdata->status == 3)
                                                      <span class="badge badge-pill badge-info">Pending</span>
                                                  @else
                                                      <span class="badge badge-pill badge-success">Confirmed</span>
                                                  @endif
                                                  @if ($clientList->balanceconfirmationstatus == 1)
                                                      @if ($clientbankdata->status == 3)
                                                          <a class="editCompanyyyy hide-on-closed" data-toggle="modal"
                                                              data-id="{{ $clientbankdata->id }}"
                                                              data-target="#exampleModal1123{{ $loop->index }}"
                                                              title="Send Reminder">
                                                              <span class="typcn typcn-bell"
                                                                  style="font-size: large;color: green;"></span>
                                                          </a>
                                                      @endif
                                                  @endif

                                                  {{-- asa request reminder modal --}}
                                                  <div class="modal fade" id="exampleModal1123{{ $loop->index }}"
                                                      tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
                                                      aria-hidden="true">
                                                      <div class="modal-dialog" role="document">
                                                          <div class="modal-content">
                                                              <div class="modal-header" style="background: #218838;">
                                                                  <h5 style="color:white;"
                                                                      class="modal-title font-weight-600"
                                                                      id="exampleModalLabel4">Send
                                                                      Reminder
                                                                      list</h5>
                                                                  <div>
                                                                      <ul>
                                                                          @foreach ($errors->all() as $e)
                                                                              <li style="color:red;">{{ $e }}
                                                                              </li>
                                                                          @endforeach
                                                                      </ul>
                                                                  </div>
                                                                  <button type="button" class="close"
                                                                      data-dismiss="modal" aria-label="Close">
                                                                      <span aria-hidden="true">&times;</span>
                                                                  </button>
                                                              </div>
                                                              <div class="modal-body">
                                                                  <div class="table-responsive">
                                                                      <table id="reminderTable"
                                                                          class="table display table-bordered table-striped table-hover">
                                                                          <thead>
                                                                              <tr style="background-color: #b6acae;">
                                                                                  <th>Reminder Count</th>
                                                                                  <th>Last Reminder Date</th>
                                                                              </tr>
                                                                          </thead>
                                                                          <tbody id="timesheetTableBody">

                                                                          </tbody>
                                                                      </table>
                                                                  </div>
                                                              </div>
                                                              <div class="modal-footer">
                                                                  <a href="{{ url('assignmentpending/mail', $clientbankdata->id) }}"
                                                                      class="btn btn-success sendReminderBtn"
                                                                      onclick="return confirm('Are you sure you want to send notification?');">
                                                                      Send
                                                                      Notification</a>
                                                              </div>

                                                          </div>
                                                      </div>
                                                  </div>

                                              </td>
                                              <td>{{ $clientbankdata->debtorcreatedby->team_member ?? '' }}</td>
                                              <td>{{ $clientbankdata->debtorconfirm->remark ?? '' }}</td>
                                              <td>{{ $clientbankdata->debtorconfirm->amount ?? '' }}</td>


                                              <td> <a target="blank"
                                                      href="{{ optional($clientbankdata->debtorconfirm)->file
                                                          ? url('/backEnd/image/confirmationfile/' . $clientbankdata->debtorconfirm->file)
                                                          : '' }}">
                                                      {{ optional($clientbankdata->debtorconfirm)->file ?? '' }}
                                                  </a></td>


                                              <td>
                                                  @if ($clientList->balanceconfirmationstatus == 1)
                                                      @if ($clientbankdata->mailstatus == 0)
                                                          <a href="{{ url('/entriesedit/' . $clientbankdata->id) }}"
                                                              class="btn btn-info-soft btn-sm hide-on-closed"><i
                                                                  class="far fa-edit"></i></a>
                                                      @endif
                                                  @endif
                                              </td>
                                              <td>
                                                  @if ($clientList->balanceconfirmationstatus == 1)
                                                      @if ($clientbankdata->mailstatus == 0)
                                                          <a href="{{ url('/entries/destroy/' . $clientbankdata->id) }}"
                                                              onclick="return confirm('Are you sure you want to delete this item?');"
                                                              class="btn btn-danger-soft btn-sm hide-on-closed"><i
                                                                  class="far fa-trash-alt"></i></a>
                                                      @endif
                                                  @endif
                                              </td>
                                          </tr>
                                      @endforeach
                                  </tbody>
                              </table>
                          </div>
                      </div>

                  </div>
              </div>
          </div>


      </div>
      <div class="modal modal-success fade exampleModal155-modal-lg" tabindex="-1" role="dialog"
          aria-labelledby="exampleModalLabel3" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <form id="detailsForm" method="post" action="{{ url('assignmentconfirmation/mail') }}"
                      enctype="multipart/form-data">
                      @csrf
                      <div class="modal-header">
                          <h5 class="modal-title font-weight-600" aria-labelledby="exampleModalLabel3">Send Mail</h5>

                          <button id="refreshButtons" type="button" class="close" data-dismiss="modal"
                              aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">

                          <div class="row row-sm">
                              {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                              <div class="col-sm-8">
                                  <label class="font-weight-600">Subject <span class="tx-danger">*</span></label>
                                  <input placeholder=" Enter Subject" class="form-control" name="subject"
                                      type="text">
                                  <input hidden class="form-control" id="confirmationtype" name="type"
                                      type="text">
                                  <input hidden class="form-control" id="debtorid" name="confirmationid[]"
                                      type="text">

                              </div>
                              <div class="col-sm-4">
                                  <label class="font-weight-600">Confirmation Type <span
                                          class="tx-danger">*</span></label>
                                  <select required id="assignmenttemplate" name="templateid" class="form-control">
                                      <!--placeholder-->
                                      <option value="">Please Select One</option>
                                      @foreach ($template as $templateData)
                                          <option value="{{ $templateData->id }}">
                                              {{ $templateData->title }}</option>
                                      @endforeach
                                  </select>

                                  <input id="name" hidden class="form-control" name="assignmentgenerate_id"
                                      type="text" value="{{ $assignmentgenerate_id }}">
                              </div>

                          </div>
                          <br>

                          <div class="row row-sm">
                              {{-- <div class="col-sm-6">
                        <input id="contactemail" placeholder=" Enter From Email" class="form-control" name="fromemail"
                            type="text">
                      
                    </div> --}}
                              <div class="col-sm-6">
                                  <label class="font-weight-600">Select CC Mail</label>
                                  <select class="form-control basic-multiple" multiple="multiple" name="teammember_id[]">

                                      <option>Please Select Cc Mail</option>
                                      @foreach ($teammember as $teammemberData)
                                          <option value="{{ $teammemberData->id }}"
                                              @if (!empty($store->financial) && $store->financial == $teammemberData->id) selected @endif>
                                              {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename }}
                                              )
                                          </option>
                                      @endforeach
                                  </select>

                              </div>
                              <div class="col-sm-6">
                                  <label class="font-weight-600">Enter CC Mail id </label>
                                  <input class="form-control" name="ccmail" type="text"
                                      placeholder="Enter Multiple Mail Id">
                                  <span>eg : abc@gmail.com,xyz@gmail.com</span>

                              </div>
                          </div>
                          <br>
                          <div class="row row-sm">
                              <div class="col-sm-12">
                                  <label class="font-weight-600">Description <span class="tx-danger">*</span></label>
                                  <textarea rows="6" name="description" class="centered form-control" id="editorss"
                                      placeholder="Enter Description"></textarea>
                                  <span>please merge dynamic field
                                      [name],[amount],[year],[date],[address],[entityname]</span>
                              </div>

                          </div>
                      </div>
                      <div class="modal-footer">
                          <button id="refreshButton" type="button" class="btn btn-danger"
                              data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-info" onclick="saveForm()">Save Draft</button>
                          <button type="submit" class="btn btn-primary" onclick="saveForm2()">Save</button>
                          <button type="submit" class="btn btn-success"
                              onclick="return validateSubject();">Send</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>


      <script>
          // JavaScript code to refresh the page when either button is clicked
          document.getElementById("refreshButton").addEventListener("click", function() {
              location.reload(); // Reload the current page
          });

          document.getElementById("refreshButtons").addEventListener("click", function() {
              location.reload(); // Reload the current page
          });
      </script>

      <script src="{{ url('backEnd/ckeditor/ckeditor.js') }}"></script>

      <script>
          ClassicEditor
              .create(document.querySelector('#editorss'), {
                  // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
              })
              .then(editor => {
                  window.editor = editor;
              })
              .catch(err => {
                  console.error(err.stack);
              });
      </script>

      <div class="modal modal-success fade exampleModal1556-modal-lg" tabindex="-1" role="dialog"
          aria-labelledby="exampleModalLabel3" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <form id="detailsForm" method="post" action="{{ url('confirmation/excel') }}"
                      enctype="multipart/form-data">
                      @csrf
                      <div class="modal-header" style="background: #37A000">
                          <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Add Excel
                          </h5>
                          <!--  <div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <ul>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  @foreach ($errors->all() as $e)
    <li style="color:red;">{{ $e }}</li>
    @endforeach
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              </ul>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          </div> -->
                          <button id="refreshButtonexcel" type="button" class="close" data-dismiss="modal"
                              aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">

                          <div class="details-form-field form-group row">
                              <label for="name" class="col-sm-3 col-form-label font-weight-600">Type:</label>
                              <div class="col-sm-9">
                                  <select required name="type" id="exampleFormControlSelect1" class="form-control">
                                      <!--placeholder-->
                                      <option value="">Please Select One</option>
                                      <option value="1">Debtor</option>
                                      <option value="2">Creditor</option>
                                      <option value="3">Bank</option>
                                  </select>
                              </div>

                          </div>
                          <div class="details-form-field form-group row">
                              <label for="name" class="col-sm-3 col-form-label font-weight-600">Upload Excel:</label>
                              <div class="col-sm-9">
                                  <input required class="form-control" id="input-excel" name="file" type="file"
                                      onchange="validateFileType(this)">
                                  <input id="name" hidden class="form-control" name="assignmentgenerate_id"
                                      type="text" value="{{ $assignmentgenerate_id }}">
                              </div>

                          </div>

                          <div class="details-form-field form-group row">
                              <label for="address" class="col-sm-3 col-form-label font-weight-600">Sample Excel:</label>
                              <div class="col-sm-9">
                                  <a href="{{ url('backEnd/confirmationsfiles.xlsx') }}"
                                      class="btn btn-success btn">Download<i class="fas fa-file-excel"
                                          style="margin-left: 3px;font-size: 20px;"></i></a>

                              </div>
                          </div>
                          <!-- Responsive table container -->
                          <div class="container mt-5">
                              <div class="mt-3">
                                  <table class="table table-bordered">
                                      <thead id="table-header"></thead>
                                      <tbody id="table-body"></tbody>
                                  </table>
                              </div>
                              <nav aria-label="Page navigation example">
                                  <ul class="pagination" id="pagination"></ul>
                              </nav>
                          </div>
                          <div class="modal-footer">
                              <button id="refreshButtonexcels" type="button" class="btn btn-danger"
                                  data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-success">Save</button>
                          </div>
                  </form>
              </div>
          </div>
      </div>
      {{-- other javascript --}}

      <script>
          // JavaScript code to refresh the page when either button is clicked
          document.getElementById("refreshButtonexcels").addEventListener("click", function() {
              location.reload(); // Reload the current page
          });

          document.getElementById("refreshButtonexcel").addEventListener("click", function() {
              location.reload(); // Reload the current page
          });
      </script>

      <!-- JavaScript -->
      <script>
          function validateFileType(input) {
              const allowedExtensions = [".csv", ".xlsx", ".xls"];
              const fileName = input.value.toLowerCase();
              const extension = fileName.substring(fileName.lastIndexOf("."));

              if (!allowedExtensions.includes(extension)) {
                  alert("Please select an Excel (.csv, .xlsx, or .xls) file.");
                  input.value = ""; // Clear the file selection
                  return false; // Prevent form submission if file type is invalid
              }
              return true; // Allow form submission if file type is valid
          }
      </script>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
      <script>
          let excelData = [];
          let currentPage = 1;
          const rowsPerPage = 10;

          function excelSerialToDate(serial) {
              const utc_days = Math.floor(serial - 25569);
              const utc_value = utc_days * 86400;
              return new Date(utc_value * 1000);
          }

          function handleFileSelect(event) {
              const file = event.target.files[0];
              const reader = new FileReader();

              reader.onload = function(e) {
                  const data = new Uint8Array(e.target.result);
                  const workbook = XLSX.read(data, {
                      type: 'array'
                  });
                  const sheetName = workbook.SheetNames[0];
                  const sheet = workbook.Sheets[sheetName];
                  excelData = XLSX.utils.sheet_to_json(sheet, {
                      header: 1,
                      raw: false,
                      dateNF: 'yyyy-mm-dd'
                  });
                  displayHeaderRow(excelData[0]);
                  displayData(currentPage);
              };

              reader.readAsArrayBuffer(file);
          }

          function capitalizeFirstLetter(string) {
              return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
          }

          function displayHeaderRow(headerRow) {
              const tableHeader = document.getElementById('table-header');
              tableHeader.innerHTML = '';
              const tr = document.createElement('tr');
              headerRow.forEach(header => {
                  const th = document.createElement('th');
                  // Capitalize the first letter of each header
                  th.textContent = capitalizeFirstLetter(header);
                  tr.appendChild(th);
              });
              tableHeader.appendChild(tr);
          }

          function displayData(page) {
              const startIndex = (page - 1) * rowsPerPage;
              const endIndex = startIndex + rowsPerPage;
              const totalPages = Math.ceil((excelData.length - 1) / rowsPerPage);

              const tableBody = document.getElementById('table-body');
              tableBody.innerHTML = '';

              for (let i = startIndex + 1; i < endIndex + 1 && i < excelData.length; i++) {
                  const row = excelData[i];
                  const tr = document.createElement('tr');
                  for (let j = 0; j < excelData[0].length; j++) {
                      const td = document.createElement('td');
                      if (j < row.length) {
                          let cellValue = row[j];
                          if (j === 3 && !isNaN(cellValue)) {
                              const date = excelSerialToDate(cellValue);
                              cellValue = date.toLocaleDateString();
                          }
                          td.textContent = cellValue;
                      } else {
                          td.textContent = ""; // For blank cells
                      }
                      tr.appendChild(td);
                  }
                  tableBody.appendChild(tr);
              }

              displayPagination(totalPages);
          }

          function displayPagination(totalPages) {
              const pagination = document.getElementById('pagination');
              pagination.innerHTML = '';

              for (let i = 1; i <= totalPages; i++) {
                  const li = document.createElement('li');
                  li.className = 'page-item';
                  const a = document.createElement('a');
                  a.className = 'page-link';
                  a.href = '#';
                  a.textContent = i;
                  a.addEventListener('click', (e) => {
                      e.preventDefault();
                      currentPage = i;
                      displayData(currentPage);
                  });
                  li.appendChild(a);
                  pagination.appendChild(li);
              }
          }

          document.getElementById('input-excel').addEventListener('change', handleFileSelect);
      </script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script>
          $(function() {
              $('#assignmenttemplate').on('change', function() {
                  var template_id = $(this).val();

                  $.ajax({
                      type: "GET",
                      url: "{{ url('assignmentconfirmationtemplate') }}",
                      data: "template_id=" + template_id,
                      success: function(response) {
                          var desc = response.description;

                          // Check if the editor instance is already created
                          if (window.editor) {
                              window.editor.setData(desc); // Set the content using CKEditor's API
                          }
                      },
                      error: function() {

                      },
                  });
                  $('#subcentre_id').html('');
              });
          });
      </script>

      <script>
          $(document).ready(function() {
              $('.editCompanyyyy').click(function(e) {
                  // Prevent default anchor behavior
                  e.preventDefault();
                  // Get the data-id attribute value
                  var id = $(this).data('id');
                  //   alert(id);
                  $.ajax({
                      type: 'GET',

                      url: "{{ url('balanceconfirmationreminderlist') }}",
                      data: {
                          id: id,
                      },
                      success: function(response) {

                          var balanceconfirmationreminderlist = response
                              .balanceconfirmationreminderlist;

                          $('#reminderTable tbody').empty();
                          $.each(balanceconfirmationreminderlist, function(index, reminder) {
                              // Append a new row to the table
                              $('#reminderTable tbody').append('<tr>' +
                                  '<td>' + reminder.remindercount + '</td>' +
                                  '<td>' + reminder.reminderdatecount + '</td>' +
                                  '</tr>');
                          });
                      },
                      error: function(error) {
                          console.error('Error fetching data:', error);
                      }
                  });
              });
          });
      </script>
      <script>
          function saveForm() {
              document.getElementById('detailsForm').action = "{{ url('/assignmentmaildraft') }}";
          }

          function saveForm2() {
              document.getElementById('detailsForm').action = "{{ url('/assignmentfinalsave') }}";
          }
      </script>


      @include('backEnd.assignmentconfirmation.checkbox')

      @include('backEnd.assignmentconfirmation.togglejs')

  @endsection
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
  <script>
      $(document).ready(function() {
          $('#examplee').DataTable({
              "pageLength": 50,
              dom: 'Blfrtip', // 'l' is for length dropdown
              lengthMenu: [
                  [10, 30, 50, 100, -1],
                  [10, 30, 50, 100, "All"]
              ], // Length dropdown options
              "order": [
                  [0, "desc"]
              ],
              columnDefs: [{
                      orderable: false,
                      targets: [1, 5]
                  } // Disables sorting on the first column (checkbox column)
              ],
              buttons: [{
                      extend: 'copyHtml5',
                      exportOptions: {
                          columns: [0, ':visible']
                      }
                  },
                  {
                      extend: 'excelHtml5',
                      filename: 'Debtor List',
                      exportOptions: {
                          columns: ':visible'
                      }
                  },
                  {
                      extend: 'pdfHtml5',
                      exportOptions: {
                          columns: [0, 1, 2, 5]
                      }
                  },
                  {
                      extend: 'colvis',
                      text: 'Column Visibility',
                      columns: ':not(:nth-child(2)):not(:nth-child(6))'
                  }
              ]
          });
          // Set width of length menu
          $('.dataTables_length select').css('width', '50px');
      });
  </script>

  <script>
      $(document).ready(function() {
          $('#exampleee').DataTable({
              "pageLength": 50,
              dom: 'Blfrtip', // 'l' is for length dropdown
              lengthMenu: [
                  [10, 30, 50, 100, -1],
                  [10, 30, 50, 100, "All"]
              ], // Length dropdown options
              "order": [
                  [0, "desc"]
              ],
              columnDefs: [{
                      orderable: false,
                      targets: [1, 5]
                  } // Disables sorting on the first column (checkbox column)
              ],
              buttons: [{
                      extend: 'copyHtml5',
                      exportOptions: {
                          columns: [0, ':visible']
                      }
                  },
                  {
                      extend: 'excelHtml5',
                      filename: 'Creditor List',
                      exportOptions: {
                          columns: ':visible'
                      }
                  },
                  {
                      extend: 'pdfHtml5',
                      exportOptions: {
                          columns: [0, 1, 2, 5]
                      }
                  },
                  {
                      extend: 'colvis',
                      text: 'Column Visibility',
                      columns: ':not(:nth-child(2)):not(:nth-child(6))'
                  }
              ]
          });
          // Set width of length menu
          $('.dataTables_length select').css('width', '50px');
      });
  </script>
  <script>
      $(document).ready(function() {
          $('#exampleeee').DataTable({
              "pageLength": 50,
              dom: 'Blfrtip', // 'l' is for length dropdown
              lengthMenu: [
                  [10, 30, 50, 100, -1],
                  [10, 30, 50, 100, "All"]
              ], // Length dropdown options
              "order": [
                  [0, "desc"]
              ],
              columnDefs: [{
                      orderable: false,
                      targets: [1, 5]
                  } // Disables sorting on the first column (checkbox column)
              ],
              buttons: [{
                      extend: 'copyHtml5',
                      exportOptions: {
                          columns: [0, ':visible']
                      }
                  },
                  {
                      extend: 'excelHtml5',
                      filename: 'Bank List',
                      exportOptions: {
                          columns: ':visible'
                      }
                  },
                  {
                      extend: 'pdfHtml5',
                      exportOptions: {
                          columns: [0, 1, 2, 5]
                      }
                  },
                  {
                      extend: 'colvis',
                      text: 'Column Visibility',
                      columns: ':not(:nth-child(2)):not(:nth-child(6))'
                  }
              ]
          });
          // Set width of length menu
          $('.dataTables_length select').css('width', '50px');
      });
  </script>
  <script>
      function validateSubject() {
          var subjectInput = document.getElementsByName('subject')[0].value.trim();
          if (subjectInput === '') {
              alert('Please enter a subject.');
              return false; // Prevent form submission
          }
          return confirm('Are you sure?'); // Proceed with form submission
      }
  </script>

  <script>
      function updateConfirmationStatus(checkbox) {
          var assignmentId = "{{ $clientList->assignmentgenerate_id }}";
          var status = checkbox.checked ? 1 : 0;

          $.ajax({
              url: "{{ url('/confirmationstatus') }}",
              type: 'GET',
              data: {
                  assignmentid: assignmentId,
                  status: status
              },
              success: function(response) {
                  console.log(response);
                  var message = response.status == 1 ? 'Your balance confirmation has been opened.' :
                      'Your balance confirmation has been closed.';
                  $('#successmessage').find('p').text(message);
                  $('#successmessage').show();
                  $('#successmessage').delay(5000).fadeOut(400);
                  if (response.status == 1) {
                      $('#sendButton, #uploadButton, #sendButtons, #uploadButtons, #sendButtonss, #uploadButtonss')
                          .removeClass('disabled');
                      $('.hide-on-closed').show();
                  } else {
                      $('#sendButton, #uploadButton, #sendButtons, #uploadButtons, #sendButtonss, #uploadButtonss')
                          .addClass('disabled');
                      $('.hide-on-closed').hide();
                  }
              },
              error: function(xhr, status, error) {
                  // Handle error response if needed
                  console.error(xhr.responseText);
              }
          });
      }
  </script>
  <script>
      $(document).ready(function() {
          $('.alert-success, .alert-danger').delay(5000).fadeOut(400);
      });
  </script>
