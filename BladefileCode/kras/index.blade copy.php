  <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">

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

      {{-- <style>
          table {
              table-layout: fixed;
              width: 100%;
          }

          th.textfixed {
              white-space: normal !important;
              word-wrap: break-word;
              overflow-wrap: break-word;
              vertical-align: top;
          }
      </style> --}}

      <style>
          .btn-view {
              background-color: white;
              transition: background-color 0.3s, color 0.3s, border-color 0.3s;
              border: 1px solid #ccc;
          }

          .btn-view:hover {
              background-color: #e7f1ff;
              color: #007bff !important;
              border-color: #007bff;
          }

          .btn-update {
              background-color: white;
              transition: background-color 0.3s, color 0.3s, border-color 0.3s;
              border: 1px solid #ccc;
          }

          .btn-update:hover {
              background-color: #e6f9ed;
              color: #28a745 !important;
              border-color: #28a745;
          }

          .btn-delete {
              background-color: white;
              transition: background-color 0.3s, color 0.3s, border-color 0.3s;
              border: 1px solid #ccc;
          }

          .btn-delete:hover {
              background-color: #fdecea;
              color: #dc3545 !important;
              border-color: #dc3545;
          }
      </style>



      <div class="content-header row align-items-center m-0">
          <div class="col-sm-8 header-title p-0">
              <div class="media">
                  <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
                  <div class="media-body">
                      <a href="#">
                          <h1 class="font-weight-bold" style="color:black;">Team KRA Management Dashboard</h1>
                      </a>
                      <small>Manage Key Responsibility Areas across different teams</small>
                  </div>
              </div>
          </div>
      </div>

      <div class="body-content">
          <div class="card mb-4">
              <div class="card-header" style="background: #37A000;margin-top: -16px;">
                  <div class="d-flex justify-content-between align-items-center">
                      <div>
                          <h6 style="color:white;" class="fs-17 font-weight-600 mb-0">
                              Key Responsibility Areas</h6>
                      </div>
                  </div>
              </div>
              <div>
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
                  @php
                      $tabs = [];
                      foreach ($designationData as $key => $value) {
                          $normalizedKey = strtolower(str_replace([' ', '/'], '', $key));
                          $tabs["pills-$normalizedKey"] = $key;
                      }
                  @endphp
                  <ul class="nav nav-pills mb-3 {{ $teammembers && !in_array($teammembers->designation, [13, 1400, 1500]) ? 'd-none' : '' }}"
                      id="pills-tab" role="tablist" style="background-color: #f1ece742">
                      @foreach ($tabs as $tabId => $roleKey)
                          <li class="nav-item">
                              <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $tabId }}-tab"
                                  data-toggle="pill" href="#{{ $tabId }}" role="tab"
                                  aria-controls="{{ $tabId }}" aria-selected="true">
                                  {{ ucwords(str_replace('_', ' ', $roleKey)) }}
                              </a>
                          </li>
                      @endforeach
                  </ul>
                  <div class="tab-content" id="pills-tabContent">
                      @foreach ($tabs as $tabId => $roleKey)
                          <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $tabId }}"
                              role="tabpanel" aria-labelledby="{{ $tabId }}-tab">
                              <div class="table-responsive">
                                  {{-- <br>
                                  @if ($teammembers && in_array($teammembers->designation, [13, 1400, 1500]))
                                      <div class="card-head" style="width:830px; height:10px;margin-bottom: 26px;">
                                          <b style="float:left; margin-top:-17px;">
                                              <a data-toggle="modal" data-target=".exampleModal155600-modal-lg"
                                                  class="btn btn-info-soft btn-sm">
                                                  Update KRAs Template
                                              </a>
                                          </b>
                                      </div>
                                  @endif
                                  <hr> --}}
                                  <table id="example{{ $loop->iteration }}"
                                      class="table display table-bordered table-striped table-hover">

                                      {{-- @if (count($designationData[$roleKey]['teammemberall']) > 0) --}}
                                      <div class="d-flex justify-content-between align-items-center flex-wrap py-3 px-4"
                                          style="background-color: #dee0e961; height: 81px;">
                                          <div class="d-flex align-items-center flex-wrap">
                                              <i class="fas fa-users me-2" style="color: #6c757d; font-size: 20px;"></i>
                                              <h5 class="mb-0 me-2" style="margin-left: 8px;">Team KRA List</h5>
                                              <span class="badge bg-white text-dark ms-3" style="margin-left: 17px;">
                                                  {{ count($designationData[$roleKey]['teammemberall']) }} members
                                              </span>
                                          </div>

                                          <div class="btn-group mt-2 mt-md-0">
                                              <a href="javascript:void(0);" data-toggle="modal"
                                                  data-target=".exampleModal1500-modal-lg"
                                                  data-id="{{ $designationData[$roleKey]['designationId'] }}"
                                                  data-kraexist1="{{ $designationData[$roleKey]['krasid'] }}"
                                                  class="btn btn-sm btn-update text-black uploadkrasModel500 upload-button d-none">
                                                  <i class="fas fa-upload me-1"></i> Upload
                                              </a>
                                          </div>
                                      </div>

                                      <thead>
                                          <tr>
                                              @if ($designationData[$roleKey]['hasKras'])
                                                  <th style="vertical-align: middle; text-align: center; width: 40px;">
                                                      <div
                                                          class="form-check m-0 d-flex justify-content-center align-items-center">
                                                          <input class="form-check-input select-all-checkbox"
                                                              type="checkbox" data-table-id="example{{ $loop->iteration }}"
                                                              style="border: 1px solid #6c757d; width: 18px; height: 18px;">
                                                      </div>
                                                  </th>
                                              @endif
                                              {{-- <th>S No</th> --}}
                                              <th>Employee Name</th>
                                              <th>KRAs Status</th>
                                              @if ($teammembers && in_array($teammembers->designation, [13, 1400, 1500]))
                                                  <th>Action</th>
                                              @endif
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach ($designationData[$roleKey]['teammemberall'] as $index => $row)
                                              <tr>
                                                  @if ($designationData[$roleKey]['hasKras'])
                                                      <td style="font-size:3px">
                                                          @if ($row->kra_status != 1)
                                                              <div class="form-check">
                                                                  <input class="form-check-input" type="checkbox"
                                                                      name="selected_items[]" value="{{ $row->id }}"
                                                                      style="border: 1px solid #6c757d;">
                                                              </div>
                                                          @endif
                                                      </td>
                                                  @endif
                                                  {{-- <td>{{ $index + 1 }}</td> --}}
                                                  <td>
                                                      <div class="fw-bold">{{ $row->team_member }}</div>
                                                      <div class="text-muted small">{{ $row->designation_name }}</div>
                                                  </td>
                                                  <td>
                                                      @if ($row->kra_status == 1)
                                                          <span class="badge"
                                                              style="background-color: rgba(24, 255, 91, 0.33); color: #000;">
                                                              KRA
                                                          </span>
                                                      @else
                                                          <span class="badge"
                                                              style="background-color: rgb(246 154 154 / 33%);color: #000;">No
                                                              KRA</span>
                                                      @endif
                                                  </td>
                                                  @if ($teammembers && in_array($teammembers->designation, [13, 1400, 1500]))
                                                      <td class="textfixed">
                                                          @if ($row->kra_status == 1)
                                                              <a href="{{ route('kras.show', ['id' => $row->id, 'designation' => $row->designation]) }}"
                                                                  class="btn btn-sm btn-view text-black">
                                                                  <i class="far fa-eye" style="margin-right: 4px;"></i>
                                                                  View
                                                              </a>

                                                              {{-- <a href="{{ route('kras.delete', ['id' => $row->id, 'designation' => $row->designation]) }}"
                                                                      class="btn btn-sm btn-update text-black">
                                                                      <i class="far fa-edit" style="margin-right: 4px;"></i>
                                                                      Update
                                                                  </a> --}}

                                                              <a href="{{ route('kras.delete', ['id' => $row->id, 'designation' => $row->designation]) }}"
                                                                  onclick="return confirm('Are you sure you want to delete this item?');"
                                                                  class="btn btn-sm btn-delete text-danger">
                                                                  <i class="far fa-trash-alt"
                                                                      style="margin-right: 4px;"></i> Delete
                                                              </a>
                                                          @else
                                                              <a data-toggle="modal"
                                                                  data-target=".exampleModal1556-modal-lg"
                                                                  data-id="{{ $row->id }}"
                                                                  data-column="{{ $row->designation }}"
                                                                  data-templates="{{ json_encode($designationData[$roleKey]['kratemplates']) }}"
                                                                  class="btn btn-sm btn-update text-black uploadkrasModel">
                                                                  <i class="fas fa-upload" style="margin-right: 4px;"></i>
                                                                  Upload
                                                              </a>
                                                          @endif
                                                      </td>
                                                  @endif
                                              </tr>
                                          @endforeach
                                      </tbody>
                                      {{-- @endif --}}
                                  </table>
                              </div>
                          </div>
                      @endforeach
                  </div>
              </div>
          </div>
      </div>

      <!-- Upload Modal -->
      {{-- <div class="modal modal-success fade exampleModal155600-modal-lg" id="krasupload600" tabindex="-1" role="dialog"
          aria-labelledby="exampleModalLabel3600" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <form id="detailsForm600" method="post" action="{{ url('kras/excelupload') }}"
                      enctype="multipart/form-data">
                      @csrf
                      <div class="modal-header" style="background: #37A000">
                          <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4600">
                              Upload Excel to Key Responsibility Areas
                          </h5>
                          <button id="refreshButtonexcel" type="button" class="close" data-dismiss="modal"
                              aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="details-form-field form-group row">
                              <label for="name" class="col-sm-3 col-form-label font-weight-600">KRAs Type: *</label>
                              <div class="col-sm-9">
                                  <select required name="designationid" id="exampleFormControlSelect1"
                                      class="form-control">
                                      <option value="">Please Select One</option>
                                      @foreach ($designations as $designation)
                                          <option value="{{ $designation->id }}">
                                              {{ $designation->name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="details-form-field form-group row">
                              <label for="name" class="col-sm-3 col-form-label font-weight-600">Upload KRAs
                                  Excel: *</label>
                              <div class="col-sm-9">
                                  <input required class="form-control" id="input-excel" name="file" type="file"
                                      onchange="validateFileType(this)">
                              </div>

                          </div>



                          <div class="container mt-5">
                              <div class="mt-3">
                                  <div style="max-height: 400px; overflow-y: auto;">
                                      <table class="table table-bordered">
                                          <thead id="table-header"></thead>
                                          <tbody id="table-body"></tbody>
                                      </table>
                                  </div>
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
                      </div>
                  </form>
              </div>
          </div>
      </div> --}}

      <!-- Upload Modal //..// -->
      <div class="modal modal-success fade exampleModal1500-modal-lg" id="krasupload500" tabindex="-1" role="dialog"
          aria-labelledby="exampleModalLabel3" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <form id="detailsForm500" method="post" action="{{ route('krabulkUpload') }}"
                      enctype="multipart/form-data" onsubmit="collectSelectedItems()">
                      @csrf
                      <div class="modal-header" style="background: #37A000">
                          <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">
                              Upload Excel to Key Responsibility Areas
                          </h5>
                          <button id="refreshButtonexcel" type="button" class="close" data-dismiss="modal"
                              aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="form-group" id="mapped-section1">
                              <label><b>Are you want to mapped common KRA: *</b></label>
                              <select required name="mappedId1" id="mappedId1" class="form-control">
                                  <option value="">Please Select One</option>
                                  <option value="1">Yes</option>
                                  <option value="2">No</option>
                              </select>
                          </div>
                          <div class="form-group" id="template-section1">
                              <label><b>Are you want to save as a template KRA: *</b></label>
                              <select required name="kratemplate1" id="kratemplate1" class="form-control">
                                  <option value="">Please Select One</option>
                                  <option value="1">Yes</option>
                                  <option value="2">No</option>
                              </select>
                          </div>
                          <div class="form-group">
                              <label><b>Upload KRAs Excel: *</b></label>
                              <input required class="form-control" id="input-excel1" name="file" type="file"
                                  onchange="validateFileType(this)">
                              <input type="hidden" class="form-control" name="designationids" id="designationid"
                                  value="">
                              <input type="hidden" class="form-control" name="selected_items" id="selected_items_input"
                                  value="">
                          </div>

                          <div class="container-confirm mt-5">
                              <div class="mt-3">
                                  <div style="max-height: 400px; overflow-y: auto;">
                                      <span><b>Do you want to save as KRAs template ? </b></span>
                                      <input type="checkbox" id="enabletemplate" style="margin: 5px;"
                                          title="You want to save as KRAs templatethen please click on the checkbox">
                                  </div>
                              </div>
                              <div class="mt-3" id="templateFieldWrapper"></div>
                          </div>

                          <div class="container mt-5">
                              <div class="mt-3">
                                  <div style="max-height: 400px; overflow-y: auto;">
                                      <table class="table table-bordered">
                                          <thead id="table-header1"></thead>
                                          <tbody id="table-body1"></tbody>
                                      </table>
                                  </div>
                              </div>
                              <nav aria-label="Page navigation example">
                                  <ul class="pagination" id="pagination1"></ul>
                              </nav>
                          </div>

                          <div class="modal-footer">
                              <button id="refreshButtonexcels" type="button" class="btn btn-danger"
                                  data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-success">Save</button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>

      <!-- Upload Modal //..// -->
      <div class="modal modal-success fade exampleModal1556-modal-lg" id="krasupload" tabindex="-1" role="dialog"
          aria-labelledby="exampleModalLabel3" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <form id="detailsForm" method="post" action="{{ url('kras/excelupload/teamwise') }}"
                      enctype="multipart/form-data">
                      @csrf
                      <div class="modal-header" style="background: #37A000">
                          <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">
                              Teamwise Upload Excel to Key Responsibility Areas
                          </h5>
                          <button id="refreshButtonexcel" type="button" class="close" data-dismiss="modal"
                              aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="form-group" id="mapped-section">
                              <label><b>Are you want to mapped common KRA:</b></label>
                              {{-- <select required name="mappedId" id="mappedId" class="form-control">
                                  <option value="">Please Select One</option>
                                  <option value="1">Yes</option>
                                  <option value="2">No</option>
                              </select> --}}
                              <select name="kratemplatesId" id="kratemplatesdata" class="form-control">
                                  <option value="">Please Select One</option>
                              </select>
                          </div>
                          {{-- <div class="form-group" id="template-section">
                              <label><b>Are you want to save as a template KRA: *</b></label>
                              <select required name="kratemplate" id="kratemplate" class="form-control">
                                  <option value="">Please Select One</option>
                                  <option value="1">Yes</option>
                                  <option value="2">No</option>
                              </select>
                          </div> --}}
                          <div class="form-group">
                              <label><b>Upload KRAs Excel: *</b></label>
                              <input required class="form-control" id="input-excel" name="file" type="file"
                                  onchange="validateFileType(this)">
                              <input type="hidden" class="form-control" name="teamids" id="teamid" value="">
                              <input type="hidden" class="form-control" name="designationids" id="designationid"
                                  value="">
                              <input type="hidden" class="form-control" name="templatejson" id="templatejson"
                                  value="">
                          </div>

                          <div class="container-confirm">
                              <div class="form-group">
                                  <span><b>Do you want to save as KRAs template ? </b></span>
                                  <input type="checkbox" id="enabletemplate1" style="margin: 5px;"
                                      title="You want to save as KRAs template then please click on the checkbox">
                              </div>
                              <div class="form-group" id="templateFieldWrapper1"></div>
                          </div>

                          <div class="container mt-5">
                              <div class="mt-3">
                                  <div style="max-height: 400px; overflow-y: auto;">
                                      <table class="table table-bordered">
                                          <thead id="table-header"></thead>
                                          <tbody id="table-body"></tbody>
                                      </table>
                                  </div>
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
                      </div>
                  </form>
              </div>
          </div>
      </div>

      <!-- validation on excel file  -->
      <script>
          function validateFileType(input) {
              const allowedExtensions = [".csv", ".xlsx", ".xls"];
              const fileName = input.value.toLowerCase();
              const extension = fileName.substring(fileName.lastIndexOf("."));

              if (!allowedExtensions.includes(extension)) {
                  alert("Please select an Excel (.csv, .xlsx, or .xls) file.");
                  input.value = "";
                  return false;
              }
              return true;
          }
      </script>

      {{-- for preview of an Excel fil  --}}
      <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
      {{-- <script>
          //   Global Variables:
          let excelData = [];
          let currentPage = 1;
          const rowsPerPage = 10;

          //   Excel Serial Date Conversion Function hare date formating
          function excelSerialToDate(serial) {
              const utc_days = Math.floor(serial - 25569);
              const utc_value = utc_days * 86400;
              return new Date(utc_value * 1000);
          }

          //   File Selection Handler
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

                  // Filter and remove empty rows
                  excelData = excelData.filter(row => {
                      return row.some(cell => cell !== null && cell !== undefined && cell.toString().trim() !==
                          '');
                  });

                  displayHeaderRow(excelData[0]);
                  displayData(currentPage);
              };
              reader.readAsArrayBuffer(file);
          }

          //   Header Capitalize Function
          function capitalizeFirstLetter(string) {
              return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
          }

          //   Display Header Row in Table
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

          //   Display Paginated Data
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
                          //  for date column  
                          //   if (j === 3 && !isNaN(cellValue)) {
                          //       const date = excelSerialToDate(cellValue);
                          //       cellValue = date.toLocaleDateString();
                          //   }
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

          //   Pagination Display Function
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

      <script>
          //   Global Variables:
          let excelData = [];
          let currentPage = 1;
          const rowsPerPage = 10;

          //   Excel Serial Date Conversion Function hare date formating
          function excelSerialToDate(serial) {
              const utc_days = Math.floor(serial - 25569);
              const utc_value = utc_days * 86400;
              return new Date(utc_value * 1000);
          }

          //   File Selection Handler
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

                  // Filter and remove empty rows
                  excelData = excelData.filter(row => {
                      return row.some(cell => cell !== null && cell !== undefined && cell.toString().trim() !==
                          '');
                  });

                  displayHeaderRow(excelData[0]);
                  displayData(currentPage);
              };
              reader.readAsArrayBuffer(file);
          }

          //   Header Capitalize Function
          function capitalizeFirstLetter(string) {
              return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
          }

          //   Display Header Row in Table
          function displayHeaderRow(headerRow) {
              const tableHeader = document.getElementById('table-header1');
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

          //   Display Paginated Data
          function displayData(page) {
              const startIndex = (page - 1) * rowsPerPage;
              const endIndex = startIndex + rowsPerPage;
              const totalPages = Math.ceil((excelData.length - 1) / rowsPerPage);

              const tableBody = document.getElementById('table-body1');
              tableBody.innerHTML = '';

              for (let i = startIndex + 1; i < endIndex + 1 && i < excelData.length; i++) {
                  const row = excelData[i];
                  const tr = document.createElement('tr');
                  for (let j = 0; j < excelData[0].length; j++) {
                      const td = document.createElement('td');
                      if (j < row.length) {
                          let cellValue = row[j];
                          //  for date column  
                          //   if (j === 3 && !isNaN(cellValue)) {
                          //       const date = excelSerialToDate(cellValue);
                          //       cellValue = date.toLocaleDateString();
                          //   }
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

          //   Pagination Display Function
          function displayPagination(totalPages) {
              const pagination = document.getElementById('pagination1');
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

          document.getElementById('input-excel1').addEventListener('change', handleFileSelect);
      </script> --}}

      <script>
          function initializeExcelUpload(inputId, tableHeaderId, tableBodyId, paginationId) {
              const input = document.getElementById(inputId);
              let excelData = [];
              let currentPage = 1;
              const rowsPerPage = 10;

              input.addEventListener('change', function(event) {
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
                          raw: false
                      });

                      // Remove empty rows
                      excelData = excelData.filter(row => row.some(cell => cell !== null && cell !== undefined &&
                          cell.toString().trim() !== ''));

                      displayHeaderRow(excelData[0]);
                      displayData(currentPage);
                  };
                  reader.readAsArrayBuffer(file);
              });

              function capitalizeFirstLetter(string) {
                  return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
              }

              function displayHeaderRow(headerRow) {
                  const tableHeader = document.getElementById(tableHeaderId);
                  tableHeader.innerHTML = '';
                  const tr = document.createElement('tr');
                  headerRow.forEach(header => {
                      const th = document.createElement('th');
                      th.textContent = capitalizeFirstLetter(header);
                      tr.appendChild(th);
                  });
                  tableHeader.appendChild(tr);
              }

              function displayData(page) {
                  const startIndex = (page - 1) * rowsPerPage;
                  const endIndex = startIndex + rowsPerPage;
                  const totalPages = Math.ceil((excelData.length - 1) / rowsPerPage);

                  const tableBody = document.getElementById(tableBodyId);
                  tableBody.innerHTML = '';

                  for (let i = startIndex + 1; i < endIndex + 1 && i < excelData.length; i++) {
                      const row = excelData[i];
                      const tr = document.createElement('tr');
                      for (let j = 0; j < excelData[0].length; j++) {
                          const td = document.createElement('td');
                          td.textContent = row[j] || "";
                          tr.appendChild(td);
                      }
                      tableBody.appendChild(tr);
                  }

                  displayPagination(totalPages);
              }

              function displayPagination(totalPages) {
                  const pagination = document.getElementById(paginationId);
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
          }
          initializeExcelUpload('input-excel', 'table-header', 'table-body', 'pagination');
          initializeExcelUpload('input-excel1', 'table-header1', 'table-body1', 'pagination1');
      </script>
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
          $("table[id^='example']").each(function() {
              let tableId = $(this).attr('id');
              let tableNumber = tableId.replace('example', '');
              let filename = 'KRAs Report' + tableNumber;
              //   console.log(filename);

              $('#' + tableId).DataTable({
                  "pageLength": 50,
                  dom: 'rtip',
                  "order": [
                      [1, "asc"]
                  ],
                  columnDefs: [{
                      targets: [0],
                      orderable: false
                  }],

                  buttons: [{
                          extend: 'copyHtml5',
                          exportOptions: {
                              columns: [0, ':visible']
                          }
                      },
                      {
                          extend: 'excelHtml5',
                          filename: filename,
                          exportOptions: {
                              columns: ':visible'
                          },
                          customize: function(xlsx) {
                              var sheet = xlsx.xl.worksheets['sheet1.xml'];
                              //   remove extra spaces
                              $('c', sheet).each(function() {
                                  var originalText = $(this).find('is t').text();
                                  var cleanedText = originalText.replace(/\s+/g,
                                      ' ').trim();
                                  $(this).find('is t').text(cleanedText);
                              });
                          }
                      },
                      {
                          extend: 'pdfHtml5',
                          exportOptions: {
                              columns: [2, 3]
                          }
                      },
                      {
                          extend: 'colvis',
                          text: 'Column Visibility',
                          columns: ':not(:nth-child(2)):not(:nth-child(6))'
                      }
                  ]
              });
          });

      });
  </script>

  <script>
      $(document).ready(function() {
          $('#krasupload').on('hidden.bs.modal', function() {
              $('#detailsForm')[0].reset();
              $('#input-excel').prop('disabled', false).attr('required', true);
              $('#table-header').empty();
              $('#table-body').empty();
              $('#pagination').empty();
              $('#templateFieldWrapper1').empty();
          });

          $('#krasupload500').on('hidden.bs.modal', function() {
              $('#detailsForm500')[0].reset();
              $('#input-excel1').prop('disabled', false).attr('required', true);
              $('#table-header1').empty();
              $('#table-body1').empty();
              $('#pagination1').empty();
          });

          $('.alert-success, .alert-danger').delay(5000).fadeOut(400);

          //   $('#kratemplatesdata').on('change', function() {
          //       var kratemplatesdataId = $(this).val();
          //       var templates = JSON.parse($('#krasupload input[name="templatejson"]').val());

          //       alert(kratemplatesdataId);
          //       if (kratemplatesdataId == '106') {
          //           $('#input-excel').prop('disabled', true).removeAttr('required');
          //           $('#table-header').empty();
          //       } else {
          //           $('#input-excel').prop('disabled', false).attr('required', true);
          //       }
          //   });

          $('#kratemplatesdata').on('change', function() {
              const kratemplatesdataId = $(this).val();
              const templates = JSON.parse($('#krasupload input[name="templatejson"]').val());
              const selectedTemplate = templates.find(t => t.id == kratemplatesdataId);
              const rowsPerPage = 10;
              let currentPage = 1;

              if (selectedTemplate) {
                  const templateData = JSON.parse(selectedTemplate.data || '[]');

                  if (templateData.length > 0) {
                      const headers = Object.keys(templateData[0]);

                      renderTableHeader(headers);
                      renderTableBody(templateData, headers, currentPage, rowsPerPage);
                      renderPagination(templateData.length, currentPage, rowsPerPage, templateData,
                          headers);

                      // Disable file input
                      $('#input-excel').prop('disabled', true).removeAttr('required');
                      $('.container-confirm').hide();
                      return;
                  }
              }

              // If no template found or no data
              clearTable();
              $('#input-excel').prop('disabled', false).attr('required', true);
              $('.container-confirm').show();

              // Functions

              function renderTableHeader(headers) {
                  const headerHtml = `<tr>${headers.map(header =>
                `<th>${formatHeader(header)}</th>`).join('')}</tr>`;
                  $('#table-header').html(headerHtml);
              }

              function renderTableBody(data, headers, page, perPage) {
                  const startIndex = (page - 1) * perPage;
                  const endIndex = Math.min(startIndex + perPage, data.length);
                  const rows = data.slice(startIndex, endIndex);

                  $('#table-body').empty();
                  rows.forEach(row => {
                      const rowHtml = `<tr>${headers.map(header =>
                    `<td>${row[header] || ''}</td>`).join('')}</tr>`;
                      $('#table-body').append(rowHtml);
                  });
              }

              function renderPagination(totalItems, currentPage, perPage, data, headers) {
                  const totalPages = Math.ceil(totalItems / perPage);
                  const pagination = $('#pagination');
                  pagination.empty();

                  // Previous button
                  pagination.append(getPageItem('&laquo;', currentPage - 1, currentPage === 1));

                  // Page numbers
                  for (let i = 1; i <= totalPages; i++) {
                      pagination.append(getPageItem(i, i, false, i === currentPage));
                  }

                  // Next button
                  pagination.append(getPageItem('&raquo;', currentPage + 1, currentPage === totalPages));

                  // Event binding (with .off() to prevent multiple bindings)
                  pagination.off('click').on('click', 'a.page-link', function(e) {
                      e.preventDefault();
                      const page = parseInt($(this).data('page'));
                      if (page >= 1 && page <= totalPages) {
                          currentPage = page;
                          renderTableBody(data, headers, currentPage, perPage);
                          renderPagination(totalItems, currentPage, perPage, data, headers);
                      }
                  });
              }

              function getPageItem(label, page, disabled, active = false) {
                  return `
                <li class="page-item ${disabled ? 'disabled' : ''} ${active ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${page}">${label}</a>
                </li>`;
              }

              function formatHeader(header) {
                  return header.split('_').map(word =>
                      word.charAt(0).toUpperCase() + word.slice(1)
                  ).join(' ');
              }

              function clearTable() {
                  $('#table-header, #table-body, #pagination').empty();
              }
          });

          $('#mappedId1').on('change', function() {
              var mappedId = $(this).val();
              if (mappedId == '1') {
                  $('#input-excel1').prop('disabled', true).removeAttr('required');
                  $('#table-header1').empty();
                  $('#table-body1').empty();
                  $('#pagination1').empty();
              } else {
                  $('#input-excel1').prop('disabled', false).attr('required', true);
              }
          });
      });


      $(document).on('click', '.uploadkrasModel', function() {
          let teamid = $(this).data('id');
          let designationid = $(this).data('column');
          const templates = $(this).data('templates');
          const $select = $('#kratemplatesdata');

          $select.empty().append('<option value="">Please Select One</option>');
          templates.forEach(template => {
              $select.append(`<option value="${template.id}">${template.template_name}</option>`);
          });

          $('#krasupload input[name="teamids"]').val(teamid);
          $('#krasupload input[name="designationids"]').val(designationid);
          $('#krasupload input[name="templatejson"]').val(JSON.stringify(templates));
      });

      $(document).on('click', '.uploadkrasModel500', function() {
          let designationid = $(this).data('id');
          let kraexist = $(this).data('kraexist1');
          $('#krasupload500 input[name="designationids"]').val(designationid);

          if (kraexist) {
              $('#mapped-section1').show();
              //   $('#template-section1').hide();
              //   $('#kratemplate1').removeAttr('required');
          } else {
              $('#mapped-section1').hide();
              //   $('#template-section1').show();
              $('#mappedId1').removeAttr('required');
          }
      });
  </script>


  {{-- Check box functionality start  --}}
  <script>
      function toggleUploadButton(tabPane) {
          const hasAnyChecked = tabPane.find('input[name="selected_items[]"]:checked').length > 0;
          const uploadButton = tabPane.find('.upload-button');
          if (hasAnyChecked) {
              uploadButton.removeClass('d-none');
          } else {
              uploadButton.addClass('d-none');
          }
      }

      $(document).on('change', '.select-all-checkbox', function() {
          const isChecked = $(this).is(':checked');
          const tabPane = $(this).closest('.tab-pane');
          tabPane.find('input[name="selected_items[]"]').prop('checked', isChecked);
          toggleUploadButton(tabPane);
      });

      $(document).on('change', 'input[name="selected_items[]"]', function() {
          const tabPane = $(this).closest('.tab-pane');
          const table = tabPane.find('table');
          const total = table.find('input[name="selected_items[]"]').length;
          const checked = table.find('input[name="selected_items[]"]:checked').length;
          const selectAll = tabPane.find('.select-all-checkbox');

          selectAll.prop('checked', total === checked);

          toggleUploadButton(tabPane);
      });
  </script>

  <script>
      function collectSelectedItems() {
          const selectedItems = [];

          // Only collect from active tab
          const activeTab = $('.tab-pane.active');
          const checkboxes = activeTab.find('input[name="selected_items[]"]:checked');

          checkboxes.each(function() {
              selectedItems.push($(this).val());
          });

          document.getElementById('selected_items_input').value = JSON.stringify(selectedItems);
      }
  </script>


  {{-- Check box functionality end hare   --}}

  <script>
      $(document).ready(function() {
          $('#enabletemplate').on('change', function() {
              const wrapper = $('#templateFieldWrapper');

              if ($(this).is(':checked')) {
                  const inputHtml = `
                <div>
                    <input type="text" class="form-control" name="templatename" placeholder="Enter template name">
                </div>
            `;
                  wrapper.html(inputHtml);
              } else {
                  wrapper.empty();
              }
          });
          $('#enabletemplate1').on('change', function() {
              const wrapper = $('#templateFieldWrapper1');

              if ($(this).is(':checked')) {
                  const inputHtml = `
                <div>
                    <label><b>Template Name: *</b></label>
                    <input required type="text" class="form-control" name="templatename1" placeholder="Enter template name">
                </div>
            `;
                  wrapper.html(inputHtml);
              } else {
                  wrapper.empty();
              }
          });
      });
  </script>
