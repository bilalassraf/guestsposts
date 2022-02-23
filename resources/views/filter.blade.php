
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
                                        <option value="rejected">rejected</option>
                                        <option value="deleted">deleted</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-6">
                                    <div>
                                        <label>Domain Authority (Moz)
                                        <span id="authority-upper">0</span> / <span id="authority-lower">{{ $filter->authority }}</span>
                                        </label>
                                        <span class="multi-range d-block">
                                            <input type="range" min="0" max="{{ $filter->authority }}" class="range_input" name="domain-upper"  value="0" data-id="authority-upper">
                                            <input type="range" min="0" max="{{ $filter->authority }}" class="range_input" name="domain-lower"  value="{{ $filter->authority }}" data-id="authority-lower">
                                        </span>
                                        {{-- <input type="range" id="doamin_input" name="domain" class="range_bar" value="{{ $filter->authority }}" min="0" max="100" oninput="document.getElementById('domain_Authority').innerHTML = '0/'+this.value" /> --}}
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div>
                                        <label>Domain Rating (Ahrefs)
                                        <span id="raitings_upper">0</span> / <span id="raitings_lower">{{ $filter->raitings }}</span>
                                        </label>
                                        <span class="multi-range d-block">
                                            <input type="range" min="0" max="{{ $filter->raitings }}" name="raitings_upper" class="range_input" value="0" data-id="raitings_upper">
                                            <input type="range" min="0" max="{{ $filter->raitings }}" name="raitings_lower" class="range_input" value="{{ $filter->raitings }}" data-id="raitings_lower">
                                        </span>
                                    </div>
                                    {{-- <input type="range" id="raiting_input" name="raitings" class="range_input" value="{{ $filter->raitings }}}" min="0" max="100" oninput="document.getElementById('domain_Raitings').innerHTML = '0/'+this.value" /> --}}
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div>
                                        <label>Trust Flow
                                        <span id="trust_upper">0</span> / <span id="trust_lower">{{ $filter->trust }}</span>
                                        </label>
                                        <span class="multi-range d-block">
                                            <input type="range" min="0" max="{{ $filter->trust }}" name="trust_upper" class="range_input" value="0" data-id="trust_upper" >
                                            <input type="range" min="0" max="{{ $filter->trust }}" name="trust_lower" class="range_input" value="{{ $filter->trust }}" data-id="trust_lower">
                                        </span>
                                        {{-- <input type="range" id="trust_input" name="trust" class="range_input" value="{{ $filter->trust }}" min="0" max="100" oninput="document.getElementById('trust_flow').innerHTML = '0/'+this.value" /> --}}
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div>
                                        <label>Citation Flow
                                        <span id="citation_upper">0</span> / <span id="citation_lower">{{ $filter->citation }}</span>
                                        </label>
                                        <span class="multi-range d-block">
                                            <input type="range" min="0" max="{{ $filter->citation }}" name="citation_upper" class="range_input" value="0" data-id="citation_upper" >
                                            <input type="range" min="0" max="{{ $filter->citation }}" name="citation_lower" class="range_input" value="{{ $filter->citation }}" data-id="citation_lower">
                                        </span>
                                        {{-- <input type="range" id="citation_input" name="citation" class="range_input" value="{{ $filter->citation }}" min="0" max="100" oninput="document.getElementById('citation_flow').innerHTML = '0/'+this.value" /> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-2 col-md-4">
                                    <div class="form-group">
                                        <label>Spam Score
                                        <span id="span_upper">0</span> / <span id="span_lower">{{ $filter->spam_score }}</span>
                                        </label>
                                        <span class="multi-range d-block">
                                            <input type="range" min="0" max="{{ $filter->spam_score }}" name="span_upper" class="range_input" value="0" data-id="span_upper">
                                            <input type="range" min="0" max="{{ $filter->spam_score }}" name="span_lower" class="range_input" value="{{ $filter->spam_score }}" data-id="span_lower">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="row">
                                        <div class="col-lg-2 mt-1 text-right">
                                            <span>FROM</span><br>
                                            <input type="input" min="0" max="{{ $filter->ahrefs_traffic  }}" name="traffic_upper" class="range_input mt-2 form-control" value="0" data-id="traffic_upper" style="width: 90px; border-radius: 17px">
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <label>Monthly Organic Traffic (Ahrefs)
                                                <span id="traffic_upper">0</span> / <span id="traffic_lower">{{ $filter->ahrefs_traffic }}</span>
                                                </label>
                                                <span class="multi-range d-block">
                                                    <input type="range" min="0" max="{{ $filter->ahrefs_traffic }}" name="traffic-lower" class="range_input" value="0" data-id="traffic_upper">
                                                    <input type="range" min="0" max="{{ $filter->ahrefs_traffic }}" name="traffic-upper" class="range_input" value="{{ $filter->ahrefs_traffic }}" data-id="traffic_lower">
                                                </span>
                                                {{-- <input type="range" id="traffic_ahrefs_input" name="ahref_traffic" class="range_input" value="{{ $filter->ahrefs_traffic }}" min="0" max="100" oninput="document.getElementById('traffic_ahrefs').innerHTML = '0/'+this.value" /> --}}
                                            </div>
                                        </div>
                                        <div class="col-lg-2 mt-1 text-center">
                                            <span>TO</span><br>
                                            <input type="input" min="0" max="{{ $filter->ahrefs_traffic  }}" name="traffic_lower" class="range_input mt-2 form-control" value="{{ $filter->ahrefs_traffic  }}" oninput="document.getElementById('traffic_lower').innerHTML = ''+this.value" data-id="traffic_lower" style="width:  90px; border-radius: 17px">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="row">
                                        <div class="col-lg-2 mt-1 text-center">
                                            <span>FROM</span><br>
                                            <input type="input" min="0" max="{{ $filter->company_price }}" name="company_upper" class="range_input mt-2 form-control " value="0" data-id="company_upper" style="width: 90px;border-radius: 17px">
                                        </div>
                                        <div class="col-md-8">
                                            <div>
                                                 <label>Company Price
                                                 <span id="company_upper">0</span> / <span id="company_lower">{{ $filter->company_price }}</span>
                                                </label>
                                                <span class="multi-range d-block">
                                                    <input type="range" min="0" max="{{ $filter->company_price }}" name="company_upper" class="range_input" value="0" data-id="company_upper">
                                                    <input type="range" min="0" max="{{ $filter->company_price }}" name="company_lower" class="range_input" value="{{ $filter->company_price }}" data-id="company_upper">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 mt-1 text-center">
                                            <span>TO</span><br>
                                            <input type="input" min="0" max="{{ $filter->company_price }}" name="company_lower" class="range_input mt-2 form-control" value="{{ $filter->company_price }}" style="width: 90px;border-radius: 17px" oninput="document.getElementById('company_lower').innerHTML = ''+this.value" data-id="company_lower">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-2 mt-1 text-center">
                                            <span>FROM</span><br>
                                            <input type="input" min="0" max="{{ $filter->sem_traffic  }}" name="organic_upper" class="range_input mt-2 form-control" value="0" data-id="organic_upper" style="width: 90px; border-radius: 17px">
                                        </div>
                                        <div class="col-lg-8">
                                            <div>
                                                <label>Monthly Organic Traffic (SEMRush)
                                                <span id="organic_upper">0</span> / <span id="organic_lower">{{ $filter->sem_traffic }}</span>
                                                </label>
                                                <span class="multi-range d-block">
                                                    <input type="range" min="0" max="{{ $filter->sem_traffic }}" name="organic_upper" class="range_input" value="0" min="0" max="100" data-id="organic_upper">
                                                    <input type="range" min="0" max="{{ $filter->sem_traffic }}" name="organic_lower" class="range_input" value="{{ $filter->sem_traffic }}" min="0" max="100" data-id="organic_lower">
                                                </span>
                                                {{-- <input type="range" id="traffic_sem_input" name="sem_traffic" class="range_input" value="{{ $filter->sem_traffic }}" min="0" max="100" oninput="document.getElementById('traffic_sem').innerHTML = '0/'+this.value" /> --}}
                                            </div>
                                        </div>
                                        <div class=" col-lg-2 mt-1 text-center">
                                            <span>TO</span><br>
                                            <input type="input" min="0" max="{{ $filter->sem_traffic  }}" name="organic_lower" class="range_input mt-2 form-control" value="{{ $filter->sem_traffic  }}" oninput="document.getElementById('organic_lower').innerHTML = ''+this.value" data-id="organic_lower" style="width: 90px; border-radius: 17px">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class=" col-lg-2 mt-1 text-center">
                                            <span>FROM</span>
                                            <input type="input" min="0" max="{{ $filter->web_price }}" name="web_upper" class="range_input mt-2 form-control" value="0" style="width: 90px; border-radius: 17px" data-id="web_upper">
                                        </div>
                                        <div class="col-md-8">
                                            <div>
                                                <label>Webmaster's Price
                                                <span id="web_upper">0</span> / <span id="web_lower">{{ $filter->web_price }}</span>
                                                </label>
                                                <span class="multi-range d-block">
                                                    <input type="range" min="0" max="{{ $filter->web_price }}" name="web_upper" class="range_input" value="0" data-id="web_upper">
                                                    <input type="range" min="0" max="{{ $filter->web_price }}" name="web_lower" class="range_input" value="{{ $filter->web_price }}" data-id="web_lower">
                                                </span>
                                                {{-- <input type="range" id="price_input" name="web_price" class="range_input" value="{{ $filter->web_price }}" min="0" max="100" oninput="document.getElementById('web_price').innerHTML = '0/'+this.value" /> --}}
                                            </div>
                                        </div>
                                        <div class=" col-lg-2 mt-1 text-center">
                                            <span>TO</span>
                                            <input type="input" min="0" max="{{ $filter->web_price }}" name="web_lower" class="range_input form-control mt-2" value="{{ $filter->web_price }}" style="width: 90px;border-radius: 17px" oninput="document.getElementById('web_lower').innerHTML = ''+this.value" data-id="web_lower">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
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
                            <input class=" float-right mt-3 bg-dark border-0 p-2 mx-auto" type="submit" value="Filter">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
