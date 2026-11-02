<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EXPERTAFF</title>

    {{-- Get yajra table --}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    {{-- Bootstrap CSS --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    {{-- DataTables Bootstrap CSS --}}
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    {{-- jQuery Validate --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    {{--  DataTables jQuery plugin --}}
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    {{--  Bootstrap JavaScript --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    {{--  DataTables Bootstrap JavaScript --}}
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    {{-- Get yajra table end hare --}}
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel=" stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- javascript library for sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    {{-- <script src="{{ asset('admin/js/jquery.js') }}"></script> --}}
    <!-- fontawesom icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    {{-- summernote implementation on admin panel --}}
    <!-- include libraries(jQuery, bootstrap) -->
    {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet"> --}}
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    {{-- network registration on admin panel --}}
    <!-- multi select 22-->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    {{-- end  network registration on admin panel --}}
</head>

<body class=" hold-transition sidebar-mini layout-navbar-fixed">
    <style>
        #required {
            color: red;
        }

        div.validation {
            font-size: 16px;
            color: red;
        }
    </style>
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <input type="submit" value="Logout" class="btn btn-sm  mt-3">
                </form>
            </ul>
        </nav>
        <!-- /navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link elevation-4">
                <img src="{{ asset('web/images/logo1.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">EXPERTAFF</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>
                {{-- <script>
                    $(document).ready(function() {
                        var subNavLinks = $('.nav-treeview .nav-link');
                        var parentNavLinks = $('.nav-pills .nav-link');
                        var parentNavItems = $('.nav-pills .nav-item');

                        subNavLinks.on('click', function(e) {

                            subNavLinks.removeClass('active');
                            parentNavLinks.removeClass('active');

                            $(this).addClass('active');

                            $(this).closest('.menu-open').parent().addClass('menu-open');
                            //  add active class ancor tag of home
                            $(this).closest('.menu-open').find('.nav-link').first().addClass('active');
                        });
                    });
                </script> --}}
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        {{-- Home --}}

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Home
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Index 1</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- Networks --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-network-wired"></i>
                                <p>
                                    Networks
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                {{-- <li class="nav-item">
                                    <a href="{{ url('/') }}/admin/networks/create" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create Networks</p>
                                    </a>
                                </li> --}}
                                <li class="nav-item">
                                    <a href="{{ url('/') }}/admin/networks-list/create" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create New Network</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/') }}/admin/networks-list" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Networks</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/') }}/admin/sponsored" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Sponsored</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/') }}/admin/top-networks" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Top 10 Networks</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/') }}/admin/featured-networks" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Featured Networks</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- Offersall_sponsored_networks --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tag"></i>
                                <p>
                                    Offers
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/') }}/admin/offers" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Offers</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/') }}/admin/top-offers" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Top 10 Offers</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/') }}/admin/featured-offers" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Featured Offers</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/') }}/admin/latest-offers" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Latest Offers</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{--  Resources --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-folder-open"></i>
                                <p>
                                    Resources
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/') }}/admin/resourcelist" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Show Resources</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/') }}/admin/resourcelist/create" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create Resources</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{--  Reviews --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-star"></i>
                                <p>
                                    Reviews
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/') }}/admin/reviewslist" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Show Reviews</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- Home --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Ads
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                {{-- Adspaces --}}
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-bullhorn"></i>

                                        <p>
                                            Home Page Ads
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/adspaces/create" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create New Ads</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/adspaces" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>All Ads</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/network-ads" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Network Of The months</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/carousel-ads" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Home Page Carousel</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/inpage-ads" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>In Page Ads</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/sponsored-ads" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Sponsored Ads</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/sponsored-small" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Sponsored Small Ads</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/featured-ads" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Featured Network Ads</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>


                        {{-- Blogs --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-pencil-alt"></i>
                                <p>
                                    Blogs
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/') }}/admin/blog/create" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create Blogs</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/') }}/admin/blog" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Show Blogs</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- Contact Us --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-pencil-alt"></i>
                                <p>
                                    Contact Us
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/') }}/admin/contact-us" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Contact Us</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- Settings --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>
                                    Settings
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/') }}/admin/systemsettings" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Settings Features</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('/') }}/admin/seo-meta" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage Seo Meta</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- Preferences --}}
                        <li class="nav-item  ">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-sliders-h"></i>
                                <p>
                                    Preferences
                                    <i class="fas fa-angle-left right"></i>
                                    {{-- <span class="badge badge-info right">6</span> --}}
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                {{-- Users --}}
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-user"></i>
                                        <p>
                                            Users
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/users/create" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create User</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/users" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Show Users</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                {{-- Roles --}}
                                <li class="nav-item  ">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-user-shield"></i>
                                        <p>
                                            Roles
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/roles/create" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create Roles</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/roles" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Show Roles</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                {{-- Offers Api --}}
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-code"></i>
                                        <p>
                                            Offers Api
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/offers-api/create" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create Offers Api</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/offers-api" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Show Offers Api</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                {{-- Commission Types --}}
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-user"></i>
                                        <p>
                                            Commission Types
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/commissiontype/create"
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create CommissionType</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/commissiontype" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Show CommissionType</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                {{-- Networks Software --}}
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-laptop"></i>
                                        <p>
                                            Networks Software
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/networksoftware/create"
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create Networks Software</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/networksoftware" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Show Networks Software</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                {{-- Verticals --}}
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-sitemap"></i>
                                        <p>
                                            Verticals
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/verticals/create" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create Verticals</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/verticals" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Show Verticals</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                {{-- Frequency Lists --}}
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-clock"></i>

                                        <p>
                                            Frequency Lists
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/paymentfrequency/create"
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create Frequency Lists</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/paymentfrequency" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Show Frequency Lists</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                {{-- Payment Lists --}}
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-credit-card"></i>

                                        <p>
                                            Payment Lists
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/paymentmethod/create"
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Create Payment Lists</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('/') }}/admin/paymentmethod" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Show Payment Lists</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            @yield('content')
                        </div>
                        <div class="col-12">
                            @yield('additional')
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Expertaff</b> 2023
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    {{-- <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script> --}}
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    {{-- Sweet alert script add hare --}}
    <script src="{{ asset('admin/js/jquery.js') }}"></script>


    {{-- network register page on admin panel --}}
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="index.js"></script>
    <!-- Latest compiled and minified JavaScript 222-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>

    <script>
        new MultiSelectTag('countries') // id
        new MultiSelectTag('commission') // id
        new MultiSelectTag('payment') // id
        new MultiSelectTag('paymentmethod') // id
    </script>
    {{-- end network register page on admin panel --}}
</body>

</html>
