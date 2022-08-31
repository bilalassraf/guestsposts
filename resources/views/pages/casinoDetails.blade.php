<div class="row" style="width: 100% !important">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body" style="background-color:rgba(36, 41, 57, 0.09);">
                <div class="row">

                    <div class="col-sm-3">
                        <div class="your-details">
                            <h6 class="f-w-600">Website Name</h6>
                            @if( in_array('Website Name',$user_permissions))
                            {{$guest_request->web_name}}
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="your-details your-details-xs">
                            <h6 class="f-w-600">OutreachCoordinator </h6>
                            @if( in_array('Outreach Coordinator',$user_permissions))
                            {{$guest_request->Coordinator?$guest_request->Coordinator->name: "N/A"}}
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="your-details">
                            <h6 class="f-w-600">Webmaster Price</h6>
                            @if( in_array('Webmaster Price',$user_permissions))
                            {{$guest_request->price}}
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="your-details">
                            <h6 class="f-w-600">Status</h6>
                            @if( in_array('Status',$user_permissions))
                            {{$guest_request->status}}
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="your-details">
                            <h6 class="f-w-600">Company Price</h6>
                            @if( in_array('Company Price',$user_permissions))
                            {{$guest_request->company_price}}
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="your-details your-details-xs">
                            <h6 class="f-w-600">Category </h6>
                            @if( in_array('Categories',$user_permissions))
                            @foreach ($guest_request->categories as $c)
                            {{$c->category}}
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="your-details">
                            <h6 class="f-w-600">Domain Authority</h6>
                            @if( in_array('Domain Authority',$user_permissions))
                            {{$guest_request->domain_authority}}
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="your-details">
                            <h6 class="f-w-600">Spam Score</h6>
                            @if( in_array('Spam Score',$user_permissions))
                            {{$guest_request->span_score}}
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="your-details">
                            <h6 class="f-w-600">Domain Rating</h6>
                            @if( in_array('Domain Rating',$user_permissions))
                            {{$guest_request->domain_rating}}
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="your-details your-details-xs">
                            <h6 class="f-w-600">Organic Traffic  (Ahrefs)</h6>
                            @if( in_array('Orgainic Traffic (Sem)',$user_permissions))
                            {{$guest_request->organic_trafic_ahrefs}}
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="your-details">
                            <h6 class="f-w-600">Orgainic Traffic (Sem)</h6>
                            @if( in_array('Orgainic Traffic (Sem)',$user_permissions))
                            {{$guest_request->organic_trafic_sem}}
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="your-details your-details-xs">
                            <h6 class="f-w-600">Email (Webmaster)</h6>
                            @if( in_array('Email (Webmaster)',$user_permissions))
                            {{$guest_request->email_webmaster}}
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="your-details your-details-xs">
                            <h6 class="f-w-600">Website Description</h6>
                            @if( in_array('Website Description',$user_permissions))
                            {{$guest_request->web_description}}
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="your-details your-details-xs">
                            <h6 class="f-w-600">Special Note</h6>
                            @if( in_array('Special Note',$user_permissions))
                            {{$guest_request->special_note}}
                            @endif
                        </div>
                    </div>
                </div>
             </div>
            </div>
        </div>
    </div>
