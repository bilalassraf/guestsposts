<style>
.multi-range-heading.d-block {
    margin: 15px 0px 0px 15px;
}
.marginTop{
    margin-top: 8px;
}
</style>
    <div class="col-md-10 offset-2">
        <div class="collapse" id="advanceFilter">
            <div id="advance-filter">
                <div class="card p-5">
                    <div class="card-body">
                        <form action="{{ route('filter.route') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Categories</label><br>
                                    {{-- <input type="text" name="category" class="mb-2" style="width:100%"> --}}
                                        <select name="category" id="" class="form-control mb-2">
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="cars">Status:</label><br>
                                    <select name="status" class="form-control mb-2">
                                        <option value="approved">Approved</option>
                                        <option value="Pending">Pending</option>
                                        <option value="rejected">Rejected</option>
                                        <option value="deleted">Deleted</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-12 col-md-6">
                                    <div>
                                        {{-- <label>Domain Authority (Moz)
                                        <span id="authority-upper">0</span> / <span id="authority-lower">{{ $filter->authority }}</span> --}}
                                        {{-- </label> --}}
                                        <div class="row">
                                            <div class="col-lg-1">
                                                <span class="multi-range-heading d-block">
                                                    DA
                                                <span class="multi-range d-block">    
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="multi-range d-block">
                                                    <input type="input" min="0" max="{{ $filter->authority  }}" name="domain-upper" class="range_input mt-2 form-control" value="0" data-id="traffic_upper">
                                                </div>
                                            </div>
                                            <div class="col-lg-7 margintop">
                                                <span class="multi-range d-block">
                                                    <input type="range" min="0" max="{{ $filter->authority }}" class="range_input" name="domain-upper"  value="0" data-id="authority-upper">
                                                    <input type="range" min="0" max="{{ $filter->authority }}" class="range_input" name="domain-lower"  value="{{ $filter->authority }}" data-id="authority-lower">
                                                </span>
                                            </div>    
                                            <div class="col-lg-2">    
                                                <div class="multi-range d-block">
                                                    <input type="input" min="0" max="{{ $filter->authority  }}" name="domain-lower" class="range_input mt-2 form-control" value="{{ $filter->ahrefs_traffic  }}" oninput="document.getElementById('traffic_lower').innerHTML = ''+this.value" data-id="traffic_lower">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <input type="range" id="doamin_input" name="domain" class="range_bar" value="{{ $filter->authority }}" min="0" max="100" oninput="document.getElementById('domain_Authority').innerHTML = '0/'+this.value" /> --}}
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-6">
                                    <div>
                                        {{-- <label>Domain Rating (Ahrefs)
                                        <span id="raitings_upper">0</span> / <span id="raitings_lower">{{ $filter->raitings }}</span>
                                        </label> --}}
                                        <div class="row">
                                            <div class="col-lg-1">
                                                <span class="multi-range-heading d-block">
                                                    DR
                                                <span class="multi-range d-block">    
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="multi-range d-block">
                                                    <input type="input" min="0" max="{{ $filter->raitings  }}" name="raitings_upper" class="range_input mt-2 form-control" value="0" data-id="traffic_upper">
                                                </div>
                                            </div>
                                            <div class="col-lg-7 margintop">
                                                <span class="multi-range d-block">
                                                    <input type="range" min="0" max="{{ $filter->raitings }}" class="range_input" name="raitings_upper"  value="0">
                                                    <input type="range" min="0" max="{{ $filter->raitings }}" class="range_input" name="raitings_lower"  value="{{ $filter->authority }}">
                                                </span>
                                            </div>    
                                            <div class="col-lg-2">    
                                                <div class="multi-range d-block">
                                                    <input type="input" min="0" max="{{ $filter->raitings  }}" name="raitings_lower" class="range_input mt-2 form-control" value="{{ $filter->raitings  }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <input type="range" id="raiting_input" name="raitings" class="range_input" value="{{ $filter->raitings }}}" min="0" max="100" oninput="document.getElementById('domain_Raitings').innerHTML = '0/'+this.value" /> --}}
                                </div>
                                <div class="col-lg-12 col-md-6">
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-1">
                                                <span class="multi-range-heading d-block">
                                                    TF
                                                <span class="multi-range d-block">    
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="multi-range d-block">
                                                    <input type="input" min="0" max="{{ $filter->trust  }}" name="trust_upper" class="range_input mt-2 form-control" value="0">
                                                </div>
                                            </div>
                                            <div class="col-lg-7 margintop">
                                                <span class="multi-range d-block">
                                                    <input type="range" min="0" max="{{ $filter->trust }}" class="range_input" name="trust_upper"  value="0">
                                                    <input type="range" min="0" max="{{ $filter->trust }}" class="range_input" name="trust_lower"  value="{{ $filter->trust }}">
                                                </span>
                                            </div>    
                                            <div class="col-lg-2">    
                                                <div class="multi-range d-block">
                                                    <input type="input" min="0" max="{{ $filter->trust  }}" name="trust_lower" class="range_input mt-2 form-control" value="{{ $filter->trust  }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-6">
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-1">
                                                <span class="multi-range-heading d-block">
                                                    CF
                                                <span class="multi-range d-block">    
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="multi-range d-block">
                                                    <input type="input" min="0" max="{{ $filter->citation  }}" name="citation_upper" class="range_input mt-2 form-control" value="0">
                                                </div>
                                            </div>
                                            <div class="col-lg-7 margintop">
                                                <span class="multi-range d-block">
                                                    <input type="range" min="0" max="{{ $filter->citation }}" class="range_input" name="citation_upper"  value="0">
                                                    <input type="range" min="0" max="{{ $filter->citation }}" class="range_input" name="citation_lower"  value="{{ $filter->citation }}">
                                                </span>
                                            </div>    
                                            <div class="col-lg-2">    
                                                <div class="multi-range d-block">
                                                    <input type="input" min="0" max="{{ $filter->citation  }}" name="citation_lower" class="range_input mt-2 form-control" value="{{ $filter->citation  }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-6">
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-1">
                                                <span class="multi-range-heading d-block">
                                                    SS
                                                <span class="multi-range d-block">    
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="multi-range d-block">
                                                    <input type="input" min="0" max="{{ $filter->spam_score  }}" name="span_upper" class="range_input mt-2 form-control" value="0">
                                                </div>
                                            </div>
                                            <div class="col-lg-7 margintop">
                                                <span class="multi-range d-block">
                                                    <input type="range" min="0" max="{{ $filter->spam_score }}" class="range_input" name="span_upper"  value="0">
                                                    <input type="range" min="0" max="{{ $filter->spam_score }}" class="range_input" name="span_lower"  value="{{ $filter->spam_score }}">
                                                </span>
                                            </div>    
                                            <div class="col-lg-2">    
                                                <div class="multi-range d-block">
                                                    <input type="input" min="0" max="{{ $filter->spam_score  }}" name="span_lower" class="range_input mt-2 form-control" value="{{ $filter->spam_score  }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-6">
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-1">
                                                <span class="multi-range-heading d-block">
                                                    Trf (Ahrefs)
                                                <span class="multi-range d-block">    
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="multi-range d-block">
                                                    <input type="input" min="0" max="{{ $filter->ahrefs_traffic  }}" name="traffic-upper" class="range_input mt-2 form-control" value="0">
                                                </div>
                                            </div>
                                            <div class="col-lg-7 margintop">
                                                <span class="multi-range d-block">
                                                    <input type="range" min="0" max="{{ $filter->ahrefs_traffic }}" class="range_input" name="traffic-upper"  value="0">
                                                    <input type="range" min="0" max="{{ $filter->ahrefs_traffic }}" class="range_input" name="traffic-lower"  value="{{ $filter->ahrefs_traffic }}">
                                                </span>
                                            </div>    
                                            <div class="col-lg-2">    
                                                <div class="multi-range d-block">
                                                    <input type="input" min="0" max="{{ $filter->ahrefs_traffic  }}" name="traffic-lower" class="range_input mt-2 form-control" value="{{ $filter->ahrefs_traffic  }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-6">
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-1">
                                                <span class="multi-range-heading d-block">
                                                    CP
                                                <span class="multi-range d-block">    
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="multi-range d-block">
                                                    <input type="input" min="0" max="{{ $filter->company_price  }}" name="company_upper" class="range_input mt-2 form-control" value="0">
                                                </div>
                                            </div>
                                            <div class="col-lg-7 margintop">
                                                <span class="multi-range d-block">
                                                    <input type="range" min="0" max="{{ $filter->company_price }}" class="range_input" name="company_upper"  value="0">
                                                    <input type="range" min="0" max="{{ $filter->company_price }}" class="range_input" name="company_lower"  value="{{ $filter->company_price }}">
                                                </span>
                                            </div>    
                                            <div class="col-lg-2">    
                                                <div class="multi-range d-block">
                                                    <input type="input" min="0" max="{{ $filter->company_price  }}" name="company_lower" class="range_input mt-2 form-control" value="{{ $filter->company_price  }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-6">
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-1">
                                                <span class="multi-range-heading d-block">
                                                    T(SEMRush)
                                                <span class="multi-range d-block">    
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="multi-range d-block">
                                                    <input type="input" min="0" max="{{ $filter->sem_traffic  }}" name="organic_upper" class="range_input mt-2 form-control" value="0">
                                                </div>
                                            </div>
                                            <div class="col-lg-7 margintop">
                                                <span class="multi-range d-block">
                                                    <input type="range" min="0" max="{{ $filter->sem_traffic }}" class="range_input" name="organic_upper"  value="0">
                                                    <input type="range" min="0" max="{{ $filter->sem_traffic }}" class="range_input" name="organic_lower"  value="{{ $filter->sem_traffic }}">
                                                </span>
                                            </div>    
                                            <div class="col-lg-2">    
                                                <div class="multi-range d-block">
                                                    <input type="input" min="0" max="{{ $filter->sem_traffic  }}" name="organic_lower" class="range_input mt-2 form-control" value="{{ $filter->sem_traffic  }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-6">
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-1">
                                                <span class="multi-range-heading d-block">
                                                    WP
                                                <span class="multi-range d-block">    
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="multi-range d-block">
                                                    <input type="input" min="0" max="{{ $filter->web_price  }}" name="web_upper" class="range_input mt-2 form-control" value="0">
                                                </div>
                                            </div>
                                            <div class="col-lg-7 margintop">
                                                <span class="multi-range d-block">
                                                    <input type="range" min="0" max="{{ $filter->web_price }}" class="range_input" name="web_upper"  value="0">
                                                    <input type="range" min="0" max="{{ $filter->web_price }}" class="range_input" name="web_lower"  value="{{ $filter->web_price }}">
                                                </span>
                                            </div>    
                                            <div class="col-lg-2">    
                                                <div class="multi-range d-block">
                                                    <input type="input" min="0" max="{{ $filter->web_price  }}" name="web_lower" class="range_input mt-2 form-control" value="{{ $filter->web_price  }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                            <div class="row mt-2">
                                <div class="col-md-6" style="margin-top: 30px;">
                                    <label for="cars">Date Of the last Update:</label><br>
                                    <div class="input-group">
                                        <input type="date" class="form-control" name="to">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-ellipsis-h"></i></span>
                                        </div>
                                        <input type="date" class="form-control datepicker hasDatepicker" name="from">
                                    </div>
                                </div>
                            </div>
                            <input class=" float-right mt-3 bg-dark border-0 p-2 mx-auto" type="submit" value="Search For Site">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
