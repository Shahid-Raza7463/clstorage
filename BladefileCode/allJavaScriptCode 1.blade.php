<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
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
{{-- ! End hare --}}
{{-- * regarding datatable   --}}
{{--  Start Hare --}}

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
{{-- date sorting  --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            "pageLength": 10,
            dom: 'Bfrtip',
            "order": [
                [0, "desc"]
            ],

            columnDefs: [{
                    targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    orderable: false
                },
                {
                    targets: 0, // Date column
                    type: 'date', // assign date column 
                    render: function(data, type, row) {
                        // date value when sorting/filtering
                        if (type === 'sort' || type === 'type') {
                            return data ? moment(data, 'DD-MM-YYYY').format(
                                'YYYY-MM-DD') : '';
                        }
                        return data;
                    }
                }
            ],

            buttons: [{
                extend: 'excelHtml5',
                filename: 'My Application',
                text: 'Export to Excel',
                className: 'btn-excel',
                exportOptions: {
                    columns: ':visible',
                },
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    $('c', sheet).each(function() {
                        var originalText = $(this).find('is t').text();
                        var cleanedText = originalText.replace(/\s+/g, ' ').trim();
                        $(this).find('is t').text(cleanedText);
                    });
                }
            }, ]
        });
    });
</script>


<script>
    $(document).ready(function() {
        const hasPendingRequests = @json($hasPendingRequests);
        const nonOrderableColumns = hasPendingRequests ? [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11] : [1, 2, 3, 4, 5,
            6, 7, 8, 9
        ];
        console.log('jjjjjjjjjjjjjj');
        console.log(hasPendingRequests);

        $('#exampleee').DataTable({
            "pageLength": 10,
            // remove button 
            // dom: 'Bfrtip',

            // remove search box
            // dom: 'frtip',
            dom: 'rtip',
            "order": [
                [0, "desc"]
            ],

            columnDefs: [{
                    targets: nonOrderableColumns,
                    orderable: false
                },
                {
                    targets: 0, // Date column
                    type: 'date', // assign date column 
                    render: function(data, type, row) {
                        // date value when sorting/filtering
                        if (type === 'sort' || type === 'type') {
                            return data ? moment(data, 'DD-MM-YYYY').format(
                                'YYYY-MM-DD') : '';
                        }
                        return data;
                    }
                }
            ],

            // buttons: [{
            //     extend: 'excelHtml5',
            //     filename: 'Team Application',
            //     text: 'Export to Excel',
            //     className: 'btn-excel',
            //     exportOptions: {
            //         columns: ':visible',
            //     },
            //     customize: function(xlsx) {
            //         var sheet = xlsx.xl.worksheets['sheet1.xml'];
            //         $('c', sheet).each(function() {
            //             var originalText = $(this).find('is t').text();
            //             var cleanedText = originalText.replace(/\s+/g, ' ').trim();
            //             $(this).find('is t').text(cleanedText);
            //         });
            //     }
            // }, ]
        });
    });
</script>
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding jquery /  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
<script>
    const test1 = $("#datepickers1").val();
    const test2 = $("#datepickers1").val().split('-');
    const test3 = $("#datepickers1").val().split('-').reverse();
    const test4 = $("#datepickers1").val().split('-').reverse().join('-');

    // output is 
    // test1 10-04-2025
    // create:1111 test2 (3) ['10', '04', '2025']0: "10"1: "04"2: "2025"length: 3[[Prototype]]: Array(0)
    // create:1112 test3 (3) ['2025', '04', '10']
    // create:1113 test4 2025-04-10
</script>
{{--  Start Hare --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Download button click event
        $('#downloadzip').click(function() {
            // Disable the button to prevent multiple clicks
            $(this).prop('disabled', true);

            // You can also hide the button if needed
            // $(this).hide();
        });
    });
</script>
{{--  Start Hare --}}
{{-- ! End hare --}}



{{-- ########################################################################### --}}
{{-- 06-05-2025 --}}




</html>
