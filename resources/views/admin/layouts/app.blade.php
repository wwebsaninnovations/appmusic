<!doctype html>

@php $html_class="light-style layout-navbar-fixed layout-menu-fixed"; @endphp
@auth
    @if(Auth::user()->theme_mode =='dark')
    @php $html_class="layout-navbar-fixed dark-style layout-menu-fixed "; @endphp
    @endif
@endauth    
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
  
  class="{{$html_class}}"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('/') }}"
  data-template="vertical-menu-template-starter"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Karhari Media Industry') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <!-- <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> -->


<!-- THEME INT START-->

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
<!-- Icons -->
<link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<!-- Icons -->
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />

<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.1/css/fixedColumns.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/2.0.3/css/select.bootstrap5.css">


<!-- Page CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css')}}" />
<!-- Helpers -->
<script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
<script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{ asset('assets/js/config.js') }}"></script>
<style>tr.selected {
    background:blue;
}
tr.selected td{
    color:#fff;
}
</style>

<!-- Core CSS -->
@php $classDark =""; @endphp
@auth
    @if(Auth::user()->theme_mode =='dark')
    @php  $classDark = "dark-mode"; @endphp
     
        <link rel="stylesheet"  type="text/css" href="{{ asset('assets/vendor/css/rtl/core-dark.css') }}"  />
        <link rel="stylesheet"  type="text/css" href="{{ asset('assets/vendor/css/rtl/theme-default-dark.css') }}" />
    @else
    @php  $classDark = "white-mode"; @endphp
    
        <link rel="stylesheet"  type="text/css" href="{{ asset('assets/vendor/css/rtl/core.css') }}"  />
        <link rel="stylesheet"  type="text/css" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" />
    @endif

    @else
       <link rel="stylesheet"  type="text/css" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
       <link rel="stylesheet"  type="text/css" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
@endauth

      <link rel="stylesheet"  type="text/css" href="{{ asset('assets/custom/css/custom.css') }}"/>

</head>
<body class="{{$classDark}}">
    <div id="app">
        <main class="py-0">
          <div class="site-container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="layout-wrapper layout-content-navbar">
                            <div class="layout-container">
                            @auth 
                                @include('admin.layouts.aside') 
                                <div class="layout-page">
                                    @include('admin.layouts.nav')
                                    @yield('content')
                                </div>
                            @else
                                 @yield('content') 
                            @endauth
                    </div>
               </div>
          </div>

        </main>
    </div>


<div class="layout-overlay layout-menu-toggle"></div>
    <div class="drag-target"></div>
</div>
<!-- jQuery and other libraries -->


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
<!-- <script src="{{ asset('js/app.js') }}"></script>     -->
<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

<script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>

<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- FormValidation Plugin and its dependencies -->
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>

<!-- Vendors JS -->
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>
<!-- Page JS -->
<script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
<script src="{{ asset('assets/js/pages-auth.js') }}"></script>
<script src="{{ asset('assets/custom/js/custom.js') }}"></script>

  <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> -->
  <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.bootstrap5.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>

  <script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/dataTables.fixedColumns.js"></script>
  <script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/fixedColumns.bootstrap5.js"></script>

  <script src="https://cdn.datatables.net/select/2.0.3/js/dataTables.select.js"></script>
  <script src="https://cdn.datatables.net/select/2.0.3/js/select.bootstrap5.js"></script>




<script type="text/javascript">

  //   dataSrc: function (json) {
        //         // Update your HTML elements with the response data
        //         $('#recordsTotal').text(json.recordsTotal);
        //         $('#totalApproved').text(json.totalApproved);
        //         $('#totalPending').text(json.totalPending);
        //         $('#totalRejected').text(json.totalRejected);
        //         $('#totalIncomplete').text(json.totalIncomplete);

        //         // Return the data to DataTables for rendering
        //         return json.data;
        //     }

//DataTables
$('#example').DataTable({
        ajax: {
          url: '/releases/getReleaseData',
          type: 'GET',
      
        },
        columns: [
          { data: '' },  
          { data: 'id' },
          { 
            data: 'thumbnail',
            render: function(data, type, full, meta) {
              return '<img src="/storage/' + data + '" width="50px" />';
            }
          },
          { data: 'release_name' },
          { 
            data: 'format',
            render: function(data, type, full, meta) {
                let badgeClass = '';
                if (data === 'single') {
                    badgeClass = 'badge bg-primary';
                } else if (data === 'ep') {
                    badgeClass = 'badge bg-info';
                } else if (data === 'album') {
                    badgeClass = 'badge bg-secondary';
                }
                return `<span class="${badgeClass}">${data}</span>`;
            }
           },
          { data: 'code' },
          { data: 'upc' },
          { 
            data: 'status',
            render: function(data, type, full, meta) {
                let badgeClass = '';
                if (data === 'Pending') {
                    badgeClass = 'badge bg-warning text-dark';
                } else if (data === 'Approved') {
                    badgeClass = 'badge bg-success';
                } else if (data === 'Rejected') {
                    badgeClass = 'badge bg-danger';
                }
                return `<span class="${badgeClass}">${data}</span>`;
            }
           },
          {
            data: 'form_status',
            render: function(data, type, full, meta) {
                let badgeClass = '';
                if (data === 'Incomplete') {
                    badgeClass = 'badge bg-danger';
                } else if (data === 'Complete') {
                    badgeClass = 'badge bg-success';
                }
                return `<span class="${badgeClass}">${data}</span>`;
            }
          },
          { 
            data: null,
            orderable: false,
            render: function(data, type, full, meta) {
                const editUrl = `/releases/create/step2?release_id=${data.id}&level=basic`;
                return `
                    <a class="badge bg-label-primary rounded p-2 " href="${editUrl}">
                        <i class="bx bxs-edit bx-sm"></i>
                    </a>
                    <a href="#" class="badge bg-label-danger rounded p-2 delete-btn" data-id="${data.id}">
                        <i class="bx bx-trash bx-sm"></i>
                    </a>`;
            }
         }
        ],

        columnDefs: [
        {
            orderable: false,
            render: DataTable.render.select(),
            targets: 0
        }
    ],
    select: {
        style: 'multi',
        selector: 'td:first-child',
        headerCheckbox: 'select-all'
    },


        processing: true,
        serverSide: true,
        paging: true,
        lengthMenu: [10, 25, 50, 100],
        pageLength: 10,
        order: [[1, 'desc']],
        searchDelay: 500 ,
        dom: 'Blfrtip',  //enabel all datatables functionality
        buttons: [
                {
                    extend: 'excel',
                    text: 'Download Excelsheet',
                    exportOptions: {
                        columns: ':not(:first-child):not(:last-child)' 
                    }
                },
        ]

       
       
    });


  // Listen for the `xhr` event to update HTML elements with summary information
  $('#example').on('xhr.dt', function (e, settings, json, xhr) {
        // Update your HTML elements with the response data
        $('#recordsTotal').text(json.recordsTotal);
        $('#totalApproved').text(json.totalApproved);
        $('#totalPending').text(json.totalPending);
        $('#totalRejected').text(json.totalRejected);
        $('#totalComplete').text(json.totalComplete);
        $('#totalIncomplete').text(json.totalIncomplete);
        $('#totalTracks').text(json.totalTracks);
        $('#totalTracksApproved').text(json.totalTracksApproved);
    });




// Handle delete button click
$('#example').on('click', '.delete-btn', function (e) {
    e.preventDefault();
    const releaseId = $(this).data('id');

    if (confirm('Are you sure you want to delete this release?')) {
        $.ajax({
            url: `/releases/delete`,
            type: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                 id : releaseId
            },
            success: function(response) {
                $('#example').DataTable().ajax.reload(null, false); // Reload the table data without resetting pagination
                console.log("Release deleted successfully: " + response);
            },
            error: function(xhr, status, error) {
                console.error("Error deleting release: " + error);
            }
        });
    }
});









  const myDropzone = new Dropzone('#dropzone-basic', {
    thumbnailWidth: 200,
    paramName: "file",
    maxFilesize: 5, // in MB
    addRemoveLinks: true, 
    maxFiles: 1,
    acceptedFiles: 'image/jpeg, image/jpg, image/tiff, image/tif', // Specify accepted file types
    init: function() {
        // Event listener for when a file is added
        this.on("addedfile", function(file) {
            // Ensure file has a preview element
            if (!file.previewElement) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    const width = img.width;
                    const height = img.height;
                    if (width < 3000 || height < 3000 || width > 6000 || height > 6000) { 
                        // Remove the file if it doesn't meet the criteria
                        myDropzone.removeFile(file);
                        $('.artwork_error').css("display","block");
                        $('.artwork_error').html("Image must be a width between 3000 and 6000 pixels.");
                    } else if ( width !== height) {
                        $('.artwork_error').css("display","block");
                        $('.artwork_error').html("Image must be a square");
                    } 
                    else {
                        $('.artwork_error').css("display","none");
                        $('.artwork_error').html("");
                        // Proceed with AJAX request if validation passes
                        var name = file.name; 
                        var release_id = $('#artwork_release_id').val();
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('releases.artwork.get') }}",
                            data: { fn: name, release_id: release_id, _token: "{{ csrf_token() }}" },
                            dataType: 'html',
                            success: function(response) {
                                var path = "{{ asset('storage') }}/" + response;
                                $('#existing-thumbnail').css('display', 'none');
                                $('#uploaded_current_artwork').css('display', 'block');
                                $('#uploaded_current_artwork').attr('src', path);
                                console.log("File path: " + response);
                            },
                            error: function(xhr, status, error) {
                                console.error("File getting error: " + error);
                            }
                        });
                    }
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        });

        // Event listener for when a file is removed
        this.on("removedfile", function(file) {
            if (!file.previewElement) return;

            // Get the file name
            var name = file.name; 
            var release_id = $('#artwork_release_id').val();
            $.ajax({
                type: 'POST',
                url: "{{ route('releases.artwork.remove') }}",
                data: { fn: name, release_id: release_id, _token: "{{ csrf_token() }}" },
                dataType: 'html',
                success: function(response) {
                    $('#uploaded_current_artwork').css('display', 'none');
                    $('#uploaded_current_artwork').attr('src', "");
                    console.log("File deleted successfully: " + response);
                },
                error: function(xhr, status, error) {
                    console.error("File deletion error: " + error);
                }
            });
        });
    }
});


 // Initialize Dropzone

 const releaseFormat = $('#release_format').val();
    let maxTracks;

    switch (releaseFormat) {
        case 'ep':
            maxTracks = 5;
            break;
        case 'album':
            maxTracks = 30;
            break;
        case 'single':
            maxTracks = 1;
            break;
        default:
            maxTracks = 10;
    }

var dropzone = new Dropzone('#image-upload', {
    thumbnailWidth: 200,
    paramName: "file",
    maxFilesize: 10, // in MB
    acceptedFiles: "audio/*",
    addRemoveLinks: true, 
    uploadMultiple: true,
    parallelUploads: 10,
    maxFiles: maxTracks,
    init: function() {

        this.on("success", function(file, response) {
            // Handle the response here
          //  console.log("File uploaded successfully:", response);
            if (response.status === 'success') {
                $('.track_upload_success').html(response.message);
                $('.track_upload_success').show();
                $('.track_upload_error').hide();
                //console.log("Server response message: " + response.message);
             
            } else {
                $('.track_upload_error').html(response.message);
                $('.track_upload_success').hide();
                $('.track_upload_error').show();
                // console.error("Server error message: " + response.message);
            }
        });

        this.on("removedfile", function(file) {

            $('.track_upload_success').hide();
            $('.track_upload_error').hide();
            // Ensure file has a preview element
            if (!file.previewElement) return;

            // Get the file name
            var name = file.name; 
            var release_id = $('#release_id').val();
            // AJAX request to delete the file
            $.ajax({
                type: 'POST',
                url: "{{ route('releases.uploadTrack.remove') }}",
                data: { fn: name, release_id:release_id,  _token: "{{ csrf_token() }}" },
                dataType: 'html',
                success: function(response) {
                    console.log("File deleted successfully: " + response);
                },
                error: function(xhr, status, error) {
                    console.error("File deletion error: " + error);
                }
            });
        });
    }
});


  
</script>

</body>
</html>
