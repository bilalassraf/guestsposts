<div class="row" style="width: 100% !important">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body" style="background-color:rgba(36, 41, 57, 0.09);">
                <div class="row">

                    <div class="col-sm-3">
                        <div class="your-details">
                            <h6 class="f-w-600">Website Name</h6>
                            {{$guest_request->web_name}}
                        </div>
                    </div>


                    <div class="col-sm-3">
                        <div class="your-details your-details-xs">
                            <h6 class="f-w-600">OutreachCoordinator </h6>
                            @if( in_array('Outreach Coordinator',$user_permissions))
                            {{$guest_request->Coordinator}}
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="your-details">
                            <h6 class="f-w-600">Webmaster Price</h6>
                            {{$guest_request->price}}
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="your-details">
                            <h6 class="f-w-600">Status</h6>
                            {{$guest_request->status}}
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
                            @foreach ($guest_request->categories as $c)
                            {{$c->category}}
                            @endforeach
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
                    <div class="col-sm-2">
                        <div class="your-details">
                            <h6 class="f-w-600">Domain Rating</h6>
                            @if( in_array('Domain Rating',$user_permissions))
                            {{$guest_request->domain_rating}}
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="your-details your-details-xs">
                            <h6 class="f-w-600">Organic Traffic  (Ahrefs)</h6>
                            @if( in_array('Orgainic Traffic (Sem)',$user_permissions))
                            {{$guest_request->organic_trafic_ahrefs}}
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="your-details">
                            <h6 class="f-w-600">Orgainic Traffic (Sem)</h6>
                            @if( in_array('Orgainic Traffic (Sem)',$user_permissions))
                            {{$guest_request->organic_trafic_sem}}
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="your-details">
                            <h6 class="f-w-600">Trust Flow</h6>
                            @if( in_array('Citation Flow',$user_permissions))
                            {{$guest_request->trust_flow}}
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="your-details">
                            <h6 class="f-w-600">Citation Flow</h6>
                            @if( in_array('Citation Flow',$user_permissions))
                            {{$guest_request->citation_flow}}
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="your-details your-details-xs">
                            <h6 class="f-w-600">Email (Webmaster)</h6>
                            {{$guest_request->email_webmaster}}
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="your-details your-details-xs">
                            <h6 class="f-w-600">Website Description</h6>
                            {{$guest_request->web_description}}
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
