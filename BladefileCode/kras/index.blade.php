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

      <style>
          table {
              table-layout: fixed;
              width: 100%;
          }
      </style>

      <div class="content-header row align-items-center m-0">
          <div class="col-sm-8 header-title p-0">
              <div class="media">
                  <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
                  <div class="media-body">
                      <a href="{{ url('home') }}">
                          <h1 class="font-weight-bold" style="color:black;">Home</h1>
                      </a>
                      <small>Key Responsibility Areas List</small>
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
                  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="background-color: #f1ece742">
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
                                  <br>
                                  <div class="card-head" style="width:830px;height: 10px;">
                                      <b style="float:left;margin-top: -17px;">
                                          <a data-toggle="modal" data-target=".exampleModal1556-modal-lg"
                                              class="btn btn-info-soft btn-sm">
                                              Upload KRAs File
                                          </a>
                                      </b>
                                  </div>
                                  <hr>
                                  {{-- <table id="example{{ $loop->iteration }}" class="display nowrap"> --}}
                                  <table id="example{{ $loop->iteration }}"
                                      class="table display table-bordered table-striped table-hover">
                                      @if (count($designationData[$roleKey]['data']) > 0)
                                          <thead>
                                              <tr>
                                                  <th class="textfixed" style="width: 50px;">S.N</th>
                                                  @foreach ($designationData[$roleKey]['headings'] as $heading)
                                                      <th class="textfixed" style="width: 361.094px;">
                                                          {{ ucwords(str_replace('_', ' ', $heading)) }}</th>
                                                  @endforeach
                                                  @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 12 || Auth::user()->role_id == 18)
                                                      <th class="textfixed" style="width: 50px;">Action</th>
                                                  @endif
                                              </tr>
                                          </thead>
                                          <tbody>
                                              {{-- @foreach ($designationData[$roleKey]['data'] as $row)
                                                  <tr>
                                                      <td>{{ $loop->iteration }}</td>
                                                      @foreach ($designationData[$roleKey]['headings'] as $heading)
                                                          <td>{{ $row[$heading] ?? '' }}</td>
                                                      @endforeach
                                                      @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 12 || Auth::user()->role_id == 18)
                                                          <td>
                                                              <a href="{{ route('kras.edit', $designationData[$roleKey]['id']) }}"
                                                                  class="btn btn-info-soft btn-sm"><i
                                                                      class="far fa-edit"></i></a>
                                                              <a href="{{ url('/kras/destroy/' . $designationData[$roleKey]['id']) }}"
                                                                  onclick="return confirm('Are you sure you want to delete this item?');"
                                                                  class="btn btn-danger-soft btn-sm"><i
                                                                      class="far fa-trash-alt"></i></a>
                                                          </td>
                                                      @endif
                                                  </tr>
                                              @endforeach --}}
                                              @foreach ($designationData[$roleKey]['data'] as $row)
                                                  <tr>
                                                      <td>{{ $loop->iteration }}</td>
                                                      @foreach ($designationData[$roleKey]['headings'] as $heading)
                                                          <td>
                                                              <a
                                                                  href="{{ route('kras.edit.column', ['id' => $designationData[$roleKey]['id'], 'column' => $heading]) }}">
                                                                  {{ $row[$heading] ?? '' }}
                                                              </a>
                                                          </td>
                                                      @endforeach
                                                      @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 12 || Auth::user()->role_id == 18)
                                                          <td>
                                                              <a href="{{ route('kras.edit', $designationData[$roleKey]['id']) }}"
                                                                  class="btn btn-info-soft btn-sm"><i
                                                                      class="far fa-edit"></i></a>
                                                              <a href="{{ url('/kras/destroy/' . $designationData[$roleKey]['id']) }}"
                                                                  onclick="return confirm('Are you sure you want to delete this item?');"
                                                                  class="btn btn-danger-soft btn-sm"><i
                                                                      class="far fa-trash-alt"></i></a>
                                                          </td>
                                                      @endif
                                                  </tr>
                                              @endforeach

                                          </tbody>
                                      @endif
                                  </table>
                              </div>
                          </div>
                      @endforeach
                  </div>
              </div>

          </div>
      </div>

      <div class="modal modal-success fade exampleModal1556-modal-lg" tabindex="-1" role="dialog"
          aria-labelledby="exampleModalLabel3" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <form id="detailsForm" method="post" action="{{ url('kras/excelupload') }}"
                      enctype="multipart/form-data">
                      @csrf
                      <div class="modal-header" style="background: #37A000">
                          <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">
                              Upload Excel to Key Responsibility Areas
                          </h5>
                          {{-- <div>
                              <ul>
                                  @foreach ($errors->all() as $e)
                                      <li style="color:red;">{{ $e }}</li>
                                  @endforeach
                              </ul>
                          </div> --}}
                          <button id="refreshButtonexcel" type="button" class="close" data-dismiss="modal"
                              aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="details-form-field form-group row">
                              <label for="name" class="col-sm-3 col-form-label font-weight-600">KRAs Type:</label>
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
                                  Excel:</label>
                              <div class="col-sm-9">
                                  <input required class="form-control" id="input-excel" name="file" type="file"
                                      onchange="validateFileType(this)">
                              </div>

                          </div>

                          {{-- <div class="details-form-field form-group row">
                              <label for="address" class="col-sm-3 col-form-label font-weight-600">Sample Excel:</label>
                              <div class="col-sm-9">
                                  <a href="{{ url('backEnd/confirmationsfile.xlsx') }}"
                                      class="btn btn-success btn">Download<i class="fas fa-file-excel"
                                          style="margin-left: 3px;font-size: 20px;"></i></a>

                              </div>
                          </div> --}}
                          <!-- Responsive table container -->
                          {{-- <div class="container mt-5">
                              <div class="mt-3">
                                  <table class="table table-bordered">
                                      <thead id="table-header"></thead>
                                      <tbody id="table-body"></tbody>
                                  </table>
                              </div>
                              <nav aria-label="Page navigation example">
                                  <ul class="pagination" id="pagination"></ul>
                              </nav>
                          </div> --}}

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
                  </form>
              </div>
          </div>
      </div>

      <script>
          document.getElementById("refreshButtonexcels").addEventListener("click", function() {
              location.reload();
          });

          document.getElementById("refreshButtonexcel").addEventListener("click", function() {
              location.reload();
          });
      </script>
      <!-- validation on excel file  -->
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

      {{-- for preview of an Excel fil  --}}
      <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
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
                  dom: 'Bfrtip',
                  columnDefs: [{
                      targets: [1, 2, 3, 4, 5],
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
