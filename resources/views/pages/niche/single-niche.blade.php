@extends('layouts.default')
@section('content')
    <div class="content-wrapper p-3">
        @include('filter')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header social-header p-3">
                        <h5 class="text-bold">
                            Niche Information<span class="pull-right"><i data-feather="more-vertical"></i></span>
                        </h5>
                    </div>
                    <div class="card-body pt-3">
                        <div class="row details-about">
                            <div class="col-sm-3">
                                <div class="your-details">
                                    <h6 class="f-w-600">Website Name</h6>
                                    <p>{{ $request->web_name }}</p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="your-details your-details-xs">
                                    <h6 class="f-w-600">Webmaste Email</h6>
                                    </h6>
                                    <p>{{ $request->email_webmaster }}</p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="your-details">
                                    <h6 class="f-w-600">Coordinator</h6>
                                    <p>{{ $request->Coordinator }}</p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="your-details">
                                    <h6 class="f-w-600">Price</h6>
                                    <p>{{ $request->price }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row details-about">
                            <div class="col-sm-3">
                                <div class="your-details">
                                    <h6 class="f-w-600">Category</h6>
                                    <p>{{ $request->category }}</p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="your-details your-details-xs">
                                    <h6 class="f-w-600">Company Price</h6>
                                    </h6>
                                    <p>{{ $request->company_price }}</p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="your-details">
                                    <h6 class="f-w-600">Domain Authority</h6>
                                    <p>{{ $request->domain_authortity }}</p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="your-details">
                                    <h6 class="f-w-600">Spam Score</h6>
                                    <p>{{ $request->span_score }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row details-about">
                            <div class="col-sm-3">
                                <div class="your-details">
                                    <h6 class="f-w-600">Organic Traffic (ahrefs)</h6>
                                    <p>{{ $request->organic_trafic_ahrefs }}</p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="your-details your-details-xs">
                                    <h6 class="f-w-600">Organic Traffic (sem)</h6>
                                    </h6>
                                    <p>{{ $request->organic_trafic_sem }}</p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="your-details">
                                    <h6 class="f-w-600">Trust Flow</h6>
                                    <p>{{ $request->trust_flow }}</p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="your-details">
                                    <h6 class="f-w-600">Sitation Flow</h6>
                                    <p>{{ $request->sitation_flow }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row details-about">
                            <div class="col-sm-12">
                                <div class="your-details">
                                    <h6 class="f-w-600">Website Description</h6>
                                    <p>{{ $request->web_description }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row details-about">
                            <div class="col-sm-12">
                                <div class="your-details">
                                    <h6 class="f-w-600">Special Note</h6>
                                    <p>{{ $request->special_note }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
