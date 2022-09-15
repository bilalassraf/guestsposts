<style>
.multi-range-heading.d-block {
    margin: 15px 0px 0px 15px;
}
.marginTop{
    margin-top: 8px;
}
.multi-range {
    height: 0;
}
@media screen and (max-width:425px){
    .marginTop {
        margin-top: 45px;
        margin-bottom: 45px;
    }
    span.multi-range-heading.d-block {
    margin-top: 50px;
    }
}
.mainFilterDiv{
    border: 1px solid #eee;
    padding: 13px;
    padding-bottom: 27px;
}
.filterRightDiv{
    border: 1px solid #eee;
    padding: 17px;
}
</style>
    <div class="col-md-12">
        <div class="collapse" id="advanceFilter">
            <div id="advance-filter">
                <div class="card">
                    <div class="card-header bg-green text-white">
                        <h1 class="card-title p-3" style="font-weight:500;font-size:28px !important;">Advance Filter</h1>
                    </div>    
                    <div class="card-body">
                        {{-- <form action="{{ route('filter.route') }}" method="POST">
                            @csrf --}}
                            <div class="row mt-2">
                               <div class="col-lg-9 col-md-12 sm-12 mainFilterDiv">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <span class="multi-range-heading d-block">
                                                    DA
                                                <span class="multi-range d-block">    
                                            </div>
                                            <div class="col-md-2">
                                                <div class="multi-range d-block">
                                                    <input type="number" min="1" max="{{ $filter->authority }}" name="domain_upper" class="domain_input range_input mt-2 form-control authority_upper_bar" value="1" id="domain_upper" oninput="document.getElementById('authority_upper_bar').value = this.value">
                                                </div>
                                            </div>
                                            <div class="col-md-7 margintop">
                                                <span class="multi-range d-block">
                                                    <input type="range" min="1" max="{{ $filter->authority }}" oninput="document.getElementById('domain_upper').value = this.value" class="range_input authority_upper_bar" name="domain_upper"  value="1" data-id="authority-upper" id="authority_upper_bar">
                                                    <input type="range" min="1" max="{{ $filter->authority }}" oninput="document.getElementById('domain_lower').value = this.value" class="range_input authority_lower_bar" name="domain_lower"  value="{{ $filter->authority }}" data-id="authority-lower" id="authority_lower_bar">
                                                </span>
                                                <p class="text-danger d-none" id="domainAuth" style="margin-top: 38px">Domain Authority should be allowed maximum 100</p>
                                            </div>    
                                            <div class="col-md-2">    
                                                <div class="multi-range d-block">
                                                    <input type="number" min="1" max="{{ $filter->authority  }}" name="domain_lower" class="domain_input range_input mt-2 form-control authority_lower_bar" value="{{ $filter->authority }}" id="domain_lower" oninput="document.getElementById('authority_lower_bar').value = this.value">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <span class="multi-range-heading d-block">
                                                    DR
                                                <span class="multi-range d-block">    
                                            </div>
                                            <div class="col-md-2">
                                                <div class="multi-range d-block">
                                                    <input type="number" min="1" max="{{ $filter->raitings  }}" name="raitings_upper" class="raitings_upper_bar domainRate_input range_input mt-2 form-control" value="1" id="raitings_upper" oninput="document.getElementById('raitings_upper_bar').value = this.value">
                                                </div>
                                            </div>
                                            <div class="col-md-7 margintop">
                                                <span class="multi-range d-block">
                                                    <input type="range" min="1" max="{{ $filter->raitings }}" class="range_input raitings_upper_bar" name="raitings_upper"  value="1"  oninput="document.getElementById('raitings_upper').value = this.value" id="raitings_upper_bar">
                                                    <input type="range" min="1" max="{{ $filter->raitings }}" class="range_input raitings_lower_bar" name="raitings_lower"  value="{{ $filter->authority }}" oninput="document.getElementById('raitings_lower').value = this.value" id="raitings_lower_bar">
                                                </span>
                                                <p class="text-danger d-none" id="domainRate" style="margin-top: 38px">Domain Rating should be allowed maximum 100</p>
                                            </div>    
                                            <div class="col-md-2">    
                                                <div class="multi-range d-block">
                                                    <input type="number" min="1" max="{{ $filter->raitings  }}" name="raitings_lower" class="raitings_lower_bar domainRate_input range_input mt-2 form-control" value="{{ $filter->raitings  }}" id="raitings_lower" oninput="document.getElementById('raitings_lower_bar').value = this.value">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <input type="range" id="raiting_input" name="raitings" class="range_input" value="{{ $filter->raitings }}}" min="1" max="100" oninput="document.getElementById('domain_Raitings').innerHTML = '0/'+this.value" /> --}}
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <span class="multi-range-heading d-block">
                                                    SS
                                                <span class="multi-range d-block">    
                                            </div>
                                            <div class="col-md-2">
                                                <div class="multi-range d-block">
                                                    <input type="number" min="1" max="{{ $filter->spam_score  }}" name="span_upper" class="span_upper_bar spamScore_input range_input mt-2 form-control" value="1" id="span_upper" oninput="document.getElementById('span_upper_bar').value = this.value">
                                                </div>
                                            </div>
                                            <div class="col-md-7 margintop">
                                                <span class="multi-range d-block">
                                                    <input type="range" min="1" max="{{ $filter->spam_score }}" class="range_input span_upper_bar" name="span_upper"  value="1" oninput="document.getElementById('span_upper').value = this.value" id="span_upper_bar">
                                                    <input type="range" min="1" max="{{ $filter->spam_score }}" class="range_input span_lower_bar" name="span_lower"  value="{{ $filter->spam_score }}" oninput="document.getElementById('span_lower').value = this.value" id="span_lower_bar">
                                                </span>
                                                <p class="text-danger d-none" id="spamScore" style="margin-top: 38px">Spam Score should be allowed maximum 100</p>
                                            </div>    
                                            <div class="col-md-2">    
                                                <div class="multi-range d-block">
                                                    <input type="number" min="1" max="{{ $filter->spam_score  }}" name="span_lower" class="span_lower_bar spamScore_input range_input mt-2 form-control" value="{{ $filter->spam_score  }}" id="span_lower" oninput="document.getElementById('span_lower_bar').value = this.value">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <span class="multi-range-heading d-block">
                                                    Ahr
                                                <span class="multi-range d-block">    
                                            </div>
                                            <div class="col-md-2">
                                                <div class="multi-range d-block">
                                                    <input type="number" min="1" max="{{ $filter->ahrefs_traffic  }}" name="traffic_upper" class="traffic_upper_bar orgTraffic_input range_input mt-2 form-control" value="1" id="traffic-upper" oninput="document.getElementById('traffic_upper_bar').value = this.value">
                                                </div>
                                            </div>
                                            <div class="col-md-7 margintop">
                                                <span class="multi-range d-block">
                                                    <input type="range" min="1" max="{{ $filter->ahrefs_traffic }}" class="range_input traffic_upper_bar" name="traffic_upper"  value="1" oninput="document.getElementById('traffic-upper').value = this.value" id="traffic_upper_bar">
                                                    <input type="range" min="1" max="{{ $filter->ahrefs_traffic }}" class="range_input traffic_lower_bar" name="traffic_lower"  value="{{ $filter->ahrefs_traffic }}" oninput="document.getElementById('traffic-lower').value = this.value" id="traffic_lower_bar">
                                                </span>
                                                <p class="text-danger d-none" id="orgTraffic" style="margin-top: 38px">Organic Traffic (Ahrefs) should be allowed maximum 10000000</p>
                                            </div>    
                                            <div class="col-md-2">    
                                                <div class="multi-range d-block">
                                                    <input type="number" min="1" max="{{ $filter->ahrefs_traffic  }}" name="traffic_lower" class="traffic_lower_bar orgTraffic_input range_input mt-2 form-control" value="{{ $filter->ahrefs_traffic  }}" id="traffic-lower" oninput="document.getElementById('traffic_lower_bar').value = this.value">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <span class="multi-range-heading d-block">
                                                    CP
                                                <span class="multi-range d-block">    
                                            </div>
                                            <div class="col-md-2">
                                                <div class="multi-range d-block">
                                                    <input type="number" min="1" max="{{ $filter->company_price  }}" name="company_upper" class="company_upper_bar company_input range_input mt-2 form-control" value="1" id="company_upper" oninput="document.getElementById('company_upper_bar').value = this.value">
                                                </div>
                                            </div>
                                            <div class="col-md-7 margintop">
                                                <span class="multi-range d-block">
                                                    <input type="range" min="1" max="{{ $filter->company_price }}" class="range_input company_upper_bar" name="company_upper"  value="1" oninput="document.getElementById('company_upper').value = this.value" id="company_upper_bar">
                                                    <input type="range" min="1" max="{{ $filter->company_price }}" class="range_input company_lower_bar" name="company_lower"  value="{{ $filter->company_price }}" oninput="document.getElementById('company_lower').value = this.value" id="company_lower_bar">
                                                </span>
                                                <p class="text-danger d-none" id="companyPrice" style="margin-top: 38px">Company Price should be allowed maximum 8000</p>
                                            </div>    
                                            <div class="col-md-2">    
                                                <div class="multi-range d-block">
                                                    <input type="number" min="1" max="{{ $filter->company_price  }}" name="company_lower" class="company_lower_bar company_input range_input mt-2 form-control" value="{{ $filter->company_price  }}" id="company_lower" oninput="document.getElementById('company_lower_bar').value = this.value">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <span class="multi-range-heading d-block">
                                                    ST
                                                <span class="multi-range d-block">    
                                            </div>
                                            <div class="col-md-2">
                                                <div class="multi-range d-block">
                                                    <input type="number" min="1" max="{{ $filter->sem_traffic  }}" name="organic_upper" class="semTraffic_input range_input mt-2 form-control organic_upper_bar" value="1" id="organic_upper" oninput="document.getElementById('organic_upper_bar').value = this.value">
                                                </div>
                                            </div>
                                            <div class="col-md-7 margintop">
                                                <span class="multi-range d-block">
                                                    <input type="range" min="1" max="{{ $filter->sem_traffic }}" class="range_input organic_upper_bar" name="organic_upper"  value="1" oninput="document.getElementById('organic_upper').value = this.value" id="organic_upper_bar">
                                                    <input type="range" min="1" max="{{ $filter->sem_traffic }}" class="range_input organic_lower_bar" name="organic_lower"  value="{{ $filter->sem_traffic }}" oninput="document.getElementById('organic_lower').value = this.value" id="organic_lower_bar">
                                                </span>
                                                <p class="text-danger d-none" id="semTraffic" style="margin-top: 38px">Organic Traffic (SEMrush) should be allowed maximum 10000000</p>
                                            </div>    
                                            <div class="col-md-2">    
                                                <div class="multi-range d-block">
                                                    <input type="number" min="1" max="{{ $filter->sem_traffic  }}" name="organic_lower" class="semTraffic_input range_input mt-2 form-control organic_lower_bar" value="{{ $filter->sem_traffic  }}" id="organic_lower" oninput="document.getElementById('organic_lower_bar').value = this.value">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <span class="multi-range-heading d-block">
                                                    WP
                                                <span class="multi-range d-block">    
                                            </div>
                                            <div class="col-md-2">
                                                <div class="multi-range d-block">
                                                    <input type="number" min="1" max="{{ $filter->web_price  }}" name="web_upper" class="webPrice_input range_input mt-2 form-control web_upper_bar" value="1" id="web_upper"  oninput="document.getElementById('web_upper_bar').value = this.value">
                                                </div>
                                            </div>
                                            <div class="col-md-7 margintop">
                                                <span class="multi-range d-block">
                                                    <input type="range" min="1" max="{{ $filter->web_price }}" class="range_input web_upper_bar" name="web_upper"  value="1" oninput="document.getElementById('web_upper').value = this.value" id="web_upper_bar">
                                                    <input type="range" min="1" max="{{ $filter->web_price }}" class="range_input web_lower_bar" name="web_lower"  value="{{ $filter->web_price }}" oninput="document.getElementById('web_lower').value = this.value" id="web_lower_bar">
                                                </span>
                                                <p class="text-danger d-none" id="webPrice" style="margin-top: 38px">Web Price should be allowed maximum 5000</p>
                                            </div>    
                                            <div class="col-md-2">    
                                                <div class="multi-range d-block">
                                                    <input type="number" min="1" max="{{ $filter->web_price  }}" name="web_lower" class="webPrice_input range_input mt-2 form-control web_lower_bar" value="{{ $filter->web_price  }}" id="web_lower" oninput="document.getElementById('web_lower_bar').value = this.value">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               </div>
                               <div class="col-lg-3 col-md-12 filterRightDiv">
                                    <div class="col-md-12">
                                        <label>Categories</label><br>
                                        {{-- <input type="text" name="category" class="mb-2" style="width:100%"> --}}
                                            <select name="category" class="form-control mb-2" id="categoryOpt">
                                                <option value="">All</option>  
                                                @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                                                @endforeach
                                            </select>
                                            <p class="text-danger d-none" id="categoryP">Please select an Category!</p>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="cars">Status:</label><br>
                                        <select name="status" class="form-control mb-2" id="status"> 
                                            <option value="">All</option>
                                            <option value="Approved">Approved</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Rejected">Rejected</option>
                                            <option value="Deleted">Deleted</option>
                                        </select>
                                        <p class="text-danger d-none" id="statusOpt">Please select an Status!</p>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="cars">Date Of the last Update:</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control datepicker hasDatepicker" name="from" id="dateFrom">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-group mt-3">
                                            <input type="date" class="form-control" name="to" id="dateTo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <input class=" float-right mt-3 bg-dark border-0 p-2 mx-auto" type="submit" id="btnSubmit" value="Search For Site"> --}}
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    
    $('.domain_input').on('change', function(ev) {  
        $('#domainAuth').addClass('d-none'); 
        var value = $(this).val();
        if(value > 100){
            $('#domainAuth').removeClass('d-none');
        }
    });

    $('.domainRate_input').on('change', function(ev) {  
        $('#domainRate').addClass('d-none'); 
        var value = $(this).val();
        if(value > 100){
            $('#domainRate').removeClass('d-none');
        }
    });

    $('.spamScore_input').on('change', function(ev) {  
        $('#spamScore').addClass('d-none'); 
        var value = $(this).val();
        if(value > 100){
            $('#spamScore').removeClass('d-none');
        }
    });

    $('.orgTraffic_input').on('change', function(ev) {  
        $('#orgTraffic').addClass('d-none'); 
        var value = $(this).val();
        if(value > 10000000){
            $('#orgTraffic').removeClass('d-none');
        }
    });

    $('.semTraffic_input').on('change', function(ev) {  
        $('#semTraffic').addClass('d-none'); 
        var value = $(this).val();
        if(value > 10000000){
            $('#semTraffic').removeClass('d-none');
        }
    });

    $('.company_input').on('change', function(ev) {  
        $('#companyPrice').addClass('d-none'); 
        var value = $(this).val();
        if(value > 8000){
            $('#companyPrice').removeClass('d-none');
        }
    });

    $('.webPrice_input').on('change', function(ev) {  
        $('#webPrice').addClass('d-none'); 
        var value = $(this).val();
        if(value > 5000){
            $('#webPrice').removeClass('d-none');
        }
    });
    
</script>