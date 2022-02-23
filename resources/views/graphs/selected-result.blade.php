@extends('layouts.default')
@section('title')
    Dashboard
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row ">
                        <div class="col-md-2">
                            <div class="card income-card card-primary">
                                <div class="card-body text-center">
                                    <div class="round-box">
                                        <!-- <img src="{{ asset('assets/images/dashboard/check.png') }}" style="width: 60%; height: 60%;"> -->
                                        <i class="fa fa-check" style="font-size: 30px; padding: 10px;"></i>
                                    </div>
                                    <h5>{{ $approved }}</h5>
                                    <a href="{{ route('request.data', 'approved') }}" class="text-green">
                                        <p>Approved Sites</p>
                                    </a>
                                    <div class="parrten">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card income-card card-primary">
                                <div class="card-body text-center">
                                    <div class="round-box">
                                        <img src="{{ asset('images/Capture.jpg') }}" height="50px" width="50px">
                                        <!-- <i class="fa fa-user-times" style="font-size: 30px; padding: 10px;"></i> -->
                                    </div>
                                    <h5>{{ $pending }}</h5>
                                    <a href="{{ route('request.data', 'pending') }}" class="text-green">
                                        <p>Pending Sites</p>
                                    </a>
                                    <div class="parrten">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card income-card card-primary">
                                <div class="card-body text-center approved">
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
                        </div>
                        <div class="col-md-2">
                            <div class="card income-card card-primary">
                                <div class="card-body text-center">
                                    <div class="round-box">
                                        <img src="{{ asset('images/4532517.png') }}" height="50px" width="50px">
                                        <!--  <i class="fa fa-ban" style="font-size: 30px; padding: 10px;"></i> -->
                                    </div>
                                    <h5>{{ $rejected }}</h5>
                                    <a href="{{ route('request.data', 'rejected') }}" class="text-green">
                                        <p>Rejected Sites</p>
                                    </a>
                                    <div class="parrten">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card income-card card-primary">
                                <div class="card-body text-center">
                                    <div class="round-box">
                                        <!-- <img src="{{ asset('assets/images/dashboard/check.png') }}" style="width: 60%; height: 60%;"> -->
                                        <i class="fa fa-trash" style="font-size: 30px; padding: 10px;"></i>
                                    </div>
                                    <h5>{{ $deleted }}</h5>
                                    <a href="{{ route('request.data', 'deleted') }}" class="text-green">
                                        <p>Deleted Sites</p>
                                    </a>
                                    <div class="parrten">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row p-2">
                    <div class="col-lg-12 col-md-12 col-sm-12">

                        <div class="card">
                            <div class="card-header border-0  bg-green p-4 fon">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">User Requests Overview</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="get" action="{{ route('custom.range', $status) }}" id="chart-form">
                                    @csrf
                                    <div class="chart-date-area d-flex justify-content-end align-items-center">

                                        <div class="chart-date-input-area">
                                            <div class="d-flex chart-input">
                                                <label class="text-green pt-1 pr-2">From</label><br>
                                                <div class="drop2-icon">
                                                    <input autocomplete="off" type="date"
                                                        class="form-control datepicker border-0 from" id="form"
                                                        style="background:#E9ECEF;" name="from">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chart-date-input-area">
                                            <div class="d-flex chart-input">
                                                <label class="text-green pt-1 pl-2 pr-2">To</label>
                                                <div class="drop2-icon">
                                                    <input autocomplete="off" type="date"
                                                        class="form-control datepicker border-0 to" id="to"
                                                        style="background:#E9ECEF;" name="to">
                                                </div>
                                            </div>
                                        </div>
                                             <button type="submit" class="btn search">Serach</button>
                                    </div>
                                    <!-- <button type="submit" class="btn ">Serach</button> -->
                            </div>

                            </form>
                            <div class="dropdown show" id="chart_menu">
                                <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Dropdown link
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="{{ route('today', $status) }}">Today</a>
                                    <a class="dropdown-item" href="{{ route('yesterday', $status) }}">Yesterday</a>
                                    <a class="dropdown-item" href="{{ route('seven.days', $status) }}">Last 7 days</a>
                                    <a class="dropdown-item" href="{{ route('thirty.days', $status) }}">Last 30 days</a>
                                    <a class="dropdown-item" href="{{ route('this.month', $status) }}">This month</a>
                                    <a class="dropdown-item" href="{{ route('last.month', $status) }}">Last month</a>
                                    <a class="dropdown-item" href="#" id="custom_range">Custom Range</a>
                                </div>
                            </div>

                            <div class="position-relative mb-4">
                                <canvas id="visitors-chart" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
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
                                            <td><a
                                                    href="{{ route('user.profile', $user->id) }}"><span>{{ $user->name }}</span></a>
                                            </td>
                                            <td>
                                                <p>{{ $user->email }}</p>
                                            </td>
                                            <td>
                                                <p>{{ $user->phone }}</p>
                                            </td>
                                            <td>{{ $user->gender }}</td>
                                            <td>
                                                <p class="ml-5">{{ $user->user_request()->count() }}</p>
                                            </td>
                                            <td>
                                                <p>{{ $user->created_at->diffForHumans() }}</p>
                                            </td>
                                            <td>
                                                <a href="{{ route('user.profile', $user->id) }}" class="btn"
                                                    style="background-color:#242939;color:white;">more details</a>
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
        // /* global Chart:false */

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
                        borderColor: '#242939',
                        pointBorderColor: '#00695B',
                        pointBackgroundColor: '#fff',
                        fill: false
                        // pointHoverBackgroundColor: '#007bff',
                        // pointHoverBorderColor    : '#007bff'
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

        // // lgtm [js/unused-local-variable]
    </script>
@endsection


@section('user')
    <div class="content-wrapper p-3">
        <div class="col-lg-12 col-md-8 col-sm-8">
            <div class="card height-equal">
                <div class="card-header bg-green p-3">
                    <h5 style="font-weight:700">Add Website</h5>
                </div>
                <div class="contact-form card-body">
                    <form class="theme-form" action="{{ route('user.store.website') }}" method="post">
                        @csrf
                        <div class="form-icon"><i class="icofont icofont-envelope-open"></i></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="websitename">Website Name</label>
                                    <input class="form-control @error('websitename') is-invalid @enderror" id="websitename"
                                        type="text" placeholder="Website Name" name="web_name" required>
                                </div>
                            </div>
                            <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="outreachcoodinator">Outreach Coordinator</label>
                                    <input class="form-control" id="outreachcoodinator" type="text"
                                        placeholder="Outreach Coordinator" name="coordinator" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price">Price</label>
                                    <input class="form-control" id="price" type="text" placeholder="Price" name="price"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="companyprice">Company price</label>
                                    <input class="form-control" id="companyprice" type="text" placeholder="Company Price"
                                        name="company_price" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category">Catoegory</label>
                                    <select name="category" id="category" class="dropdown-toggle form-control"
                                        type="button" data-toggle="dropdown" required>
                                        {{-- @foreach ($categories as $category)
                                            <option value="{{ $category->category }}">{{ $category->category }}</option>
                                            @endforeach --}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="domainauthority">Domain Authority(Moz)</label>
                                    <input class="form-control" id="domainauthority" type="text"
                                        placeholder="Domain Authority" name="domain_authority" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="spanscore">Span Score</label>
                                    <input class="form-control" id="spanscore" type="text" placeholder="Span Score"
                                        name="span_score" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="domainrating">Domain Rating(Ahrefs)</label>
                                    <input class="form-control" id="domainrating" type="text" placeholder="Domain Rating"
                                        name="domain_rating" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="organictraficahrefs">Organic Trafic (Ahrefs)</label>
                                    <input class="form-control" id="organictrafic" type="text"
                                        placeholder="Organic Tranfic" name="organic_trafic_ahrefs" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="organictraficsemrush">Organic Trafic (SEMrush)</label>
                                    <input class="form-control" id="organictraficsemrush" type="text"
                                        placeholder="Organic Trafic" name="organic_trafic_sem" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="trustflow">Trust Flow (Majestic)</label>
                                    <input class="form-control" id="trustflow" type="text" placeholder="Trust Flow"
                                        name="trust_flow" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="citationflow">Citation Flow (Majestic)</label>
                                    <input class="form-control" id="citationflow" type="text" placeholder="Citation Flow"
                                        name="citation_flow" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="emailwebmaster">Email (Webmaster)</label>
                                    <input class="form-control" id="emailwebmaster" type="email" placeholder="Email"
                                        name="email" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="websitedescription">Website Description</label>
                            <script type="text/javascript">
                                bkLib.onDomLoaded(nicEditors.allTextAreas);
                            </script>
                            <textarea class="form-control textarea" rows="3" cols="50" id="websitedescription"
                                placeholder="Your Message" name="web_description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="specialnote">Special Notes</label>
                            <script type="text/javascript">
                                bkLib.onDomLoaded(nicEditors.allTextAreas);
                            </script>
                            <textarea class="form-control textarea" id="specialnote" rows="3" cols="50"
                                placeholder="Your Message" required name="special_note"></textarea>
                        </div>
                        <div class="text-sm-end">
                            <button type="submit" class="btn btn-primary bg-green outline-none">Send Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<style type="text/css">
    #dropdownMenuLink{
        margin-right: 12.5px;
        margin-top: -15px;
        float: right;
        color: white;
    }
    .dropdown-menu.show {
    left: -17px !important;
}
    .btn{
        background-color: #242939 !important;
        color: white;
    }
    button.btn.search {
    color: white;
    background-color: #242939 !important;
    /*float: right;*/
}
a#dropdownMenuLink {
    margin-top: -30px;
}
</style>
{{-- <style type="text/css">
    @media screen and (max-width:  768px)
    {
    .card-body.text-center.approved
    {
    height: 167px !important;
    }
    }
    @media screen and (max-width:  1024px)
    {
        .card-body.text-center.approved
        {
        height: 167px !important;
        }
    }
    @media screen and (max-width:  1197px)
    {
        .card-body.text-center.approved
        {
        height: 165px !important;
        }
    }
</style> --}}
