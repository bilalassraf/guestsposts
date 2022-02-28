@extends('layouts.default')
@section('title')
Dashboard
@endsection
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
</script>

@if (auth()->user()->type == 'admin')
<div class="content-wrapper">

    @include('filter')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="container-fluid">
                    <div class="row ">
                        <div class="col-md-2">
                            <div class="card card-body income-card card-primary text-center">
                                    <input type="checkbox" name="approved" id="approved" class="text-right status">
                                    <label for="approved">
                                    <div class="round-box">
                                        <!-- <img src="{{ asset('assets/images/dashboard/check.png') }}" style="width: 60%; height: 60%;"> -->
                                        <i class="fa fa-check" style="font-size: 30px; padding: 10px;"></i>
                                    </div>
                                    <h5>{{ $approved }}</h5>
                                    {{-- <a href="{{ route('request.data', 'approved') }}" class="text-green"></a> --}}
                                        <p>Approved Sites</p>

                                    <div class="parrten">
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card income-card card-primary card-body text-center">
                                    <input type="checkbox" name="approved" id="pending" class="float-right status">
                                    <label for="pending">
                                    <div class="round-box">
                                        {{-- <img src="{{ asset('images/Capture.jpg') }}" height="50px" width="50px"> --}}
                                        <i class="fa fa-user-times" style="font-size: 30px; padding: 10px;"></i>
                                    </div>
                                    <h5>{{ $pending }}</h5>
                                    {{-- <a href="{{ route('request.data', 'pending') }}" class="text-green"></a> --}}
                                        <p>Pending Sites</p>
                                    <div class="parrten">
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-body income-card card-primary text-center approved" style="height: 178px;">
                                    <div class="round-box">
                                        <!-- <img src="{{ asset('assets/images/dashboard/check.png') }}" style="width: 60%; height: 60%;"> -->
                                        <i class="fa fa-users" style="font-size: 30px; padding: 10px;"></i>
                                    </div>
                                    <h5>{{ $users->where('type', 'user')->count() }}</h5>
                                    <p>Outreach Coordinator</p>
                                    <div class="parrten">
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card income-card card-primary card-body text-center" id="mid-card">
                                    <input type="checkbox" name="rejected" id="rejected" class="float-right status">
                                    <label for="rejected">
                                    <div class="round-box">
                                        <img src="{{ asset('public/images/4532517.png') }}" height="50px" width="50px">
                                        <!--  <i class="fa fa-ban" style="font-size: 30px; padding: 10px;"></i> -->
                                    </div>
                                    <h5>{{ $rejected }}</h5>
                                    {{-- <a href="{{ route('request.data', 'rejected') }}" class="text-green"></a> --}}
                                        <p>Rejected Sites</p>
                                    <div class="parrten">
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card income-card card-primary card-body text-center">
                                    <input type="checkbox" id="deleted" class="float-right status" name="delete">
                                    <label for="deleted">
                                    <div class="round-box">
                                        <!-- <img src="{{ asset('assets/images/dashboard/check.png') }}" style="width: 60%; height: 60%;"> -->
                                        <i class="fa fa-trash" style="font-size: 30px; padding: 10px;"></i>
                                    </div>
                                    <h5>{{ $deleted }}</h5>
                                    {{-- <a href="{{ route('request.data', 'deleted') }}" class="text-green"></a> --}}
                                        <p>Deleted Sites</p>

                                    <div class="parrten">
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row p-2">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header border-0  bg-green p-4 fon">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Guest Posts Overview</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="get" action="{{ route('ajaxChart') }}" id="" class="mt-5 float-right">
                                    @csrf
                                    <div class="chart-date-area d-flex justify-content-end align-items-center">

                                        <div class="chart-date-input-area">
                                            <div class="d-flex chart-input">
                                                <label class="text-green pt-1 pr-2">From</label><br>
                                                <div class="drop2-icon">
                                                    <input autocomplete="off" type="date" class="form-control datepicker border-0 from" id="form" style="background:#E9ECEF;" name="from">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chart-date-input-area">
                                            <div class="d-flex chart-input">
                                                <label class="text-green pt-1 pl-2 pr-2">To</label>
                                                <div class="drop2-icon">
                                                    <input autocomplete="off" type="date" class="form-control datepicker border-0 to" id="to" style="background:#E9ECEF;" name="to">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="position-relative mb-4">
                                <canvas id="visitors-chart" height="300"></canvas>
                            </div>
                            <div class="d-flex flex-row justify-content-end p-3">
                                <span class="mr-2">
                                    <i class="fas fa-square" style="color:#ced4da;"></i> Pending
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-square" style="color:#00695B;"></i> Approved
                                </span><span class="mr-2">
                                    <i class="fas fa-square" style="color:#98h640;"></i> Deleted
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-square" style="color:#86950B;"></i> Rejected
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end graph --}}

                <!-- /.card -->
                <div class="col-md-12">
                    <div class="card" style="width: 100% !important;">
                        <div class="card-header bg-green border-0">
                            <h1 class="card-title">Users Information</h1>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped table-valign-middle">
                                <thead>
                                    <tr>
                                        <th>#id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile no.</th>
                                        <th>Gender</th>
                                        <th>Total Requests</th>
                                        <th>Requested at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td><a href="{{ route('user.profile', $user->id) }}"><span>{{ $user->name }}</span></a>
                                        </td>
                                        <td>
                                            <p>{{ $user->email }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $user->phone }}</p>
                                        </td>
                                        <td>{{ $user->gender }}</td>
                                        <td>
                                            <p class="ml-5">{{ $user->user_request()->count() }}
                                            </p>
                                        </td>
                                        <td>
                                            <p>{{ $user->created_at->diffForHumans() }}</p>
                                        </td>
                                        <td>
                                            <a href="{{ route('user.profile', $user->id) }}" class="btn" style="background-color:#242939 !important;color:white;">more
                                                details</a>
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
</div>
<script>
    $(".status").change(function() {
        var approved = $("#approved").is(":checked");

        var pending = $("#pending").is(":checked");
        var rejected = $("#rejected").is(":checked");
        var deleted = $("#deleted").is(":checked");
        var to = $('#to').val()
        var from = $('#from').val()
        $.ajax({
            type: 'GET'
            , url: "{{ route('specific.chart') }}"
            , data: {
                "approved": approved
                , "pending": pending
                , "rejected": rejected
                , "deleted": deleted
            }
            , success: function(chart_data_array) {
                countChart(chart_data_array);
            }
        });

    });
    $(function() {
        ajaxGetChartData()
        $('#to').change(function() {
            var to = $('#to').val()
            var from = $('#from').val()
            ajaxGetChartData(to, from)
        });

    })

    function ajaxGetChartData(to = null, from = null) {
        $.ajax({
            type: 'GET'
            , url: "{{ route('ajaxChart') }}"
            , 'data': {
                _token: "{{ csrf_token() }}"
                , to: to
                , from: from
            }
            , success: function(data) {
                countChart(data)
            }
        });
    }

    function countChart(data) {
        var ticksStyle = {
            fontColor: '#495057'
            , fontStyle: 'bold'
        }

        var mode = 'index'
        var intersect = true

        var $visitorsChart = $('#visitors-chart')
        // eslint-disable-next-line no-unused-vars
        var chartData = "{{ $chartdata }}";
        var visitorsChart = new Chart($visitorsChart, {

            data: {
                labels: data.days
                , datasets: [{
                    type: 'line'
                    , data: data.approved_request
                    , backgroundColor: 'tansparent'
                    , borderColor: '#00695B'
                    , pointBorderColor: '#000'
                    , pointBackgroundColor: '#fff'
                    , fill: false
                    // pointHoverBackgroundColor: '#ced4da',
                    // pointHoverBorderColor    : '#ced4da'
                }, {
                    type: 'line'
                    , data: data.pending_request
                    , backgroundColor: 'tansparent'
                    , borderColor: '#ced4da'
                    , pointBorderColor: '#000'
                    , pointBackgroundColor: '#fff'
                    , fill: false
                    // pointHoverBackgroundColor: '#ced4da',
                    // pointHoverBorderColor    : '#ced4da'
                }, {
                    type: 'line'
                    , data: data.deleted_request
                    , backgroundColor: 'tansparent'
                    , borderColor: '#000'
                    , pointBorderColor: '#fff'
                    , pointBackgroundColor: '#fff'
                    , fill: false
                    // pointHoverBackgroundColor: '#ced4da',
                    // pointHoverBorderColor    : '#ced4da'
                }, {
                    type: 'line'
                    , data: data.rejected_request
                    , backgroundColor: 'tansparent'
                    , borderColor: '#86950B'
                    , pointBorderColor: '#98h640'
                    , pointBackgroundColor: '#fff'
                    , fill: false
                    // pointHoverBackgroundColor: '#ced4da',
                    // pointHoverBorderColor    : '#ced4da'
                }]
            }
            , options: {
                maintainAspectRatio: false
                , tooltips: {
                    mode: mode
                    , intersect: intersect
                }
                , hover: {
                    mode: mode
                    , intersect: intersect
                }
                , legend: {
                    display: false
                }
                , scales: {
                    yAxes: [{
                        // display: false,
                        gridLines: {
                            display: true
                            , lineWidth: '4px'
                            , color: 'rgba(0, 0, 0, .2)'
                            , zeroLineColor: 'transparent'
                        }
                        , ticks: $.extend({
                            beginAtZero: true
                            , suggestedMax: data.max
                        }, ticksStyle)
                    }]
                    , xAxes: [{
                        display: true
                        , gridLines: {
                            display: false
                        }
                        , ticks: ticksStyle
                    }]
                }
            }
        })
    }

</script>
@endif
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endsection

@section('user')
<div class="content-wrapper p-3">
    <div class="row p-2">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header border-0  bg-green p-4 fon">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">User Requests Overview</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <h3 style="color:#17a2b8;">Request Graph</h3>
                    </div>
                </div>
                <div class="position-relative mb-4">
                    <canvas id="visitors-chart" height="300"></canvas>
                </div>
                <div class="d-flex flex-row justify-content-end p-3">
                    <span class="mr-2">
                        <i class="fas fa-square" style="color:#17a2b8;"></i> Request
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        //called when key is pressed in textbox
        $("#price").keypress(function(e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                $("#errmsg").html("Please Enter Integer Value!!").show().fadeOut("slow").css('color', 'red');
                return false;
            }
        });
        $("#price").keyup(function(){
            var price = $("#price").val();
            var percentage = 8/100 * price;
            var company = parseInt(price * percentage + 50) + parseInt(price);
            $("#companyprice").val(company);

        });
    });
    $(document).ready(function() {
        //called when key is pressed in textbox
        $("#companyprice").keypress(function(e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                $("#errmsg1").html("Please Enter Integer Value!!").show().fadeOut("slow").css('color', 'red');
                return false;
            }
        });
    });

</script>

<script>

    $(function() {
            'use strict'
            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }

            var mode = 'index'
            var intersect = true

            //

            var $visitorsChart = $('#visitors-chart');
            // eslint-disable-next-line no-unused-vars
            var visitorsChart = new Chart($visitorsChart, {
                data: {
                    labels: @json($days),
                    datasets: [{
                        type: 'line',
                        data: @json($count_data),
                        backgroundColor: 'transparent',
                        borderColor: '#17a2b8',
                        pointBorderColor: '#000',
                        pointBackgroundColor: '#fff',
                        fill: false
                    }, ]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            // display: false,
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: $.extend({
                                beginAtZero: true,
                                suggestedMax: 10
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: true
                            },
                            ticks: ticksStyle
                        }]
                    }
                }
            })
        })
</script>
<script type="text/javascript">

    $(document).ready(function () {
  //called when key is pressed in textbox
  $("#price").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 &&(e.which < 48 || e.which > 57)) {
        //display error message
        $("#errmsg").html("Please Enter Integer Value!!").show().fadeOut("slow").css('color', 'red');
               return false;
    }
   });
});
      $(document).ready(function () {
  //called when key is pressed in textbox
  $("#companyprice").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 &&(e.which < 48 || e.which > 57)) {
        //display error message
        $("#errmsg1").html("Please Enter Integer Value!!").show().fadeOut("slow").css('color', 'red');
               return false;
    }
   });
});

</script>
<style type="text/css">
    @media screen and (max-width: 768px) {
        .card-body.text-center.approved {
            height: 167px !important;
        }
    }

    @media screen and (max-width: 1024px) {
        .card-body.text-center.approved {
            height: 167px !important;
        }
    }

    @media screen and (max-width: 1197px) {
        .card-body.text-center.approved {
            height: 165px !important;
        }
    }

    @media screen and (max-width: 1440px) {
        button#checkbox-select {
            width: 9%;
        }

        div#checbox-button {
            padding-left: 15px;
        }

        .chart-date-area.d-flex.justify-content-end.align-items-center {
            margin-top: -38px;
            margin-right: -100px;
        }
    }

    @media screen and (max-width: 2560px) {
        button#checkbox-select {
            width: 12%;
        }

        div#checbox-button {
            padding-left: 15px;
            font-size: 20px;
        }

        .chart-date-area.d-flex.justify-content-end.align-items-center {
            margin-top: -38px !important;
            padding-right: 10% !important;
        }
    }

</style>
@endsection

