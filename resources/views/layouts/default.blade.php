<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport"  content="width=device-width, initial-scale=1">
  <meta name="csrf-token"  content="{{ csrf_token() }}">
  <title>@yield('title')</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

<script src="{{asset('plugins/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"></script>


<style>
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  background: none;
  color: black!important;
  /*change the hover text color*/
}

/*below block of css for change style when active*/

.dataTables_wrapper .dataTables_paginate .paginate_button:active {
  background: none;
  color: black!important;
}
</style>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css')}}">
  <!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js')}}"></script>

<!-- Bootstrap -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE -->
<script src="{{ asset('dist/js/adminlte.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{ asset('dist/js/demo.js')}}"></script> --}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard3.js')}}"></script>
  <style>
    .nav-pills .nav-link.active, .nav-pills .show>.nav-link
    {
    color: #242939 !important;
    background-color: #fff !important;
}
.site:hover{
    color: #242939 !important;
}
  .bg-green{
      background-color:#242939 !important;
  }
  .text-green{
      color:#242939 !important;
  }
  .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #242939 !important;
    /*background-color: #fff !important;*/
}
a.nav-link.text-white.active {
    /*background: white !important;*/
    color: #242939 !important;
}
.greeting-div {
    background-color: rgba(255,255,255,0.7);
    padding: 15px;
}
.details-about .your-details p {
    color: #999 !important;
    line-height: 1.6 !important;
}
h6{
    font-weight:700;
}
.user-panel img {
    object-fit: cover !important;
    height: 8.5vh !important;
    width: 5rem !important;

}
.profile-user-img {
    object-fit: cover !important;
}
.main-sidebar > .bg-green > .elevation-4 > a:hover{
    color:white !important;
}
.text-lightblack
{
  color: #242939 !important;
}
.bg-lightblack
{
    background-color: #242939 !important;
}
.text-white{
    color: #fff;
}
.card-primary.card-outline {
    border-top: 3px solid #242939 !important;
}
 .nav-link.active,  .show>.nav-link {
    color: #fff !important;
    background-color: #242939 !important;
}
.request .site.active, .request .show>.site {
    color: #fff !important;
    background-color: #242939 !important;
}
#chart-form{
    display: none;
}
        .slidecontainer {
            width: 100%;
            /* Width of the outside container */
        }

        /* The slider itself */
        .slider {
            -webkit-appearance: none;
            /* Override default CSS styles */
            appearance: none;
            width: 100%;
            /* Full-width */
            height: 25px;
            /* Specified height */
            background: #d3d3d3;
            /* Grey background */
            outline: none;
            /* Remove outline */
            opacity: 0.7;
            /* Set transparency (for mouse-over effects on hover) */
            -webkit-transition: .2s;
            /* 0.2 seconds transition on hover */
            transition: opacity .2s;
        }

        /* Mouse-over effects */
        .slider:hover {
            opacity: 1;
            /* Fully shown on mouse-over */
        }

        /* The slider handle (use -webkit- (Chrome, Opera, Safari, Edge) and -moz- (Firefox) to override default look) */
        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            /* Override default look */
            appearance: none;
            width: 25px;
            /* Set a specific slider handle width */
            height: 25px;
            /* Slider handle height */
            background: #242939;
            /* Green background */
            cursor: pointer;
            /* Cursor on hover */
            border-radius:50%;
        }

        .slider::-moz-range-thumb {
            width: 25px;
            /* Set a specific slider handle width */
            height: 25px;
            /* Slider handle height */
            background: #04AA6D;
            /* Green background */
            cursor: pointer;
            /* Cursor on hover */
        }
        #userEmails{
            width:100%;
            height:4.3vh;
            border:1px solid gray;
            text-align:center;
        }
    label{
        font-weight:600;
    }
  </style>

<style>

input[type=range] {
    width: 100%;
  box-sizing: border-box;
  -webkit-appearance: none;
     -moz-appearance: none;
          appearance: none;
  overflow: hidden;
  margin: 0;
  padding: 0 2px;
  /* Add some L/R padding to ensure box shadow of handle is shown */
  overflow: hidden;
  border: 0;
  border-radius: 1px;
  outline: none;
  background: linear-gradient(grey, grey) no-repeat center;
  /* Use a linear gradient to generate only the 2px height background */
  background-size: 100% 2px;
  pointer-events: none;
}
input[type=range]:active,
input[type=range]:focus {
  outline: none;
}
input[type=range]::-webkit-slider-thumb {
  height: 28px;
  width: 28px;
  border-radius: 28px;
  background-color: #242939;
  position: relative;
  margin: 5px 0;
  /* Add some margin to ensure box shadow is shown */
  cursor: pointer;
  -webkit-appearance: none;
          appearance: none;
  pointer-events: all;
  box-shadow: 0 1px 4px 0.5px rgba(0, 0, 0, 0.25);
}
input[type=range]::-webkit-slider-thumb::before {
  content: ' ';
  display: block;
  position: absolute;
  top: 13px;
  left: 100%;
  width: 2000px;
  height: 2px;
}

.multi-range {
  position: relative;
  height: 50px;
}
.multi-range input[type=range] {
  position: absolute;
}
.multi-range input[type=range]:nth-child(1)::-webkit-slider-thumb::before {
  background-color: red;
}
.multi-range input[type=range]:nth-child(2) {
  background: none;
}
.multi-range input[type=range]:nth-child(2)::-webkit-slider-thumb::before {
  background-color: grey;
}
span.select2-selection.select2-selection--single {
    display: none !important;
}
</style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  @include('layouts.partials.navbar')
  <!-- /.navbar -->


  <!-- Main Sidebar Container -->
@include('layouts.partials.sidebar')

  <!-- Content Wrapper. Contains page content -->
@if(auth()->user()->type == 'Admin' |auth()->user()->user_info == 'on'|auth()->user()->add_category == 'on' | auth()->user()->view_all_categories == 'on' |auth()->user()->add_guest_post == 'on' |auth()->user()->view_all_guest_post == 'on' |auth()->user()->view_deleted_guest_post == 'on' |auth()->user()->add_niche == 'on' |auth()->user()->view_niches == 'on'| auth()->user()->deleted_niches == 'on' |auth()->user()->add_casino_post == 'on' |auth()->user()->view_all_casino_post == 'on' |auth()->user()->view_deleted_casino_post == 'on' )
  @yield('content')
@endif
@if(auth()->user()->type == 'User' || auth()->user()->type == 'Outreach Coordinator' || auth()->user()->type == 'Moderator')
    @yield('user')
@endif
  <!-- /.content-wrapper -->




</div>
<!-- ./wrapper -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script>

$(document).ready(function(){

    $("#custom_range").click(function(){
      $("#chart_menu").hide();
      $("#cart-form").css('display', 'block');
      $("#chart-form").slideToggle(700);
    });
    $("#close-button").click(function(){
      $("#toggle-button").show();
      $("#close-button").hide();
      $("#theme-navbar").hide(800);
    });
    $('#example1').DataTable( {
        "lengthMenu": [[15, 25, 50, -1], [15, 25, 50, "All"]],
        "pagingType": "full_numbers"
    });

});
</script>
@yield('scripts')
<!-- REQUIRED SCRIPTS -->

@include('sweetalert::alert')



