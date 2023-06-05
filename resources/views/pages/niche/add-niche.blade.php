@extends('layouts.default')
@section('title')
    Add Niche
@endsection
@section('content')
    <div class="content-wrapper p-3">
        @include('filter')
        <div class="col-lg-12 col-md-8 col-sm-8">
            <div class="card height-equal">
                <div class="card-header bg-green p-3">
                    <h5 style="font-weight:700">Add Niche</h5>
                </div>
                <div class="contact-form card-body">
                    <form class="theme-form" action="{{ route('admin.store.niche') }}" method="POST">
                        @csrf
                        <div class="form-icon"><i class="icofont icofont-envelope-open"></i></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="websitename">Website Name</label>
                                    <input class="webname form-control @error('websitename') is-invalid @enderror" id="websitename"
                                        type="text" placeholder="Website Name" name="web_name" value="{{  old('web_name') }}" autocomplete="off" required>
                                        <div id="div2" class="text-danger"></div>
                                </div>
                            </div>
                            <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
                            @if (auth()->user()->type == "Admin" || auth()->user()->type == "Moderator")
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="outreachcoodinator1">Outreach Coordinator</label>
                                    <select class="form-control" name="coordinator_id" id="outreachcoodinator1">
                                        @foreach ($guestCoordinator as $guestCoordinator)
                                            <option value="{{$guestCoordinator->id}}">{{$guestCoordinator->name}} , {{$guestCoordinator->email}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @else
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input class="form-control" id="outreachcoodinator" type="hidden" value="{{ auth()->user()->id }}" name="coordinator_id" autocomplete="off" required>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price">Price</label>
                                    <input class="form-control" id="price" type="text" placeholder="Price" autocomplete="off" value="{{  old('price') }}" name="price"
                                        required>&nbsp;<span id="errmsg"></span>
                                </div>
                            </div>
                            @if (auth()->user()->type == "Admin")
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="companyprice">Company price</label>
                                    <input class="form-control" name="company_price" id="companyprice" type="text" placeholder="Company Price" autocomplete="off" readonly required>&nbsp;<span id="errmsg1"></span>
                                </div>
                            </div>
                            @else
                                <input class="form-control" name="company_price" id="companyprice" type="hidden" autocomplete="off" required>&nbsp;<span id="errmsg1"></span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="categories[]" id="category" multiple="multiple" class="select2 form-control" type="button" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @if(old('categories')) {{ in_array( $category->id, old('categories'))?'selected':'' }} @endif>{{ $category->category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="domainauthority">Domain Authority(Moz)</label>
                                    <input class="form-control" id="domainauthority" type="text"
                                        placeholder="Domain Authority" name="domain_authority" value="{{  old('domain_authority') }}" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="spanscore">Spam Score</label>
                                    <input class="form-control" id="spanscore" type="text" autocomplete="off" placeholder="Spam Score"
                                        name="span_score" value="{{  old('span_score') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="domainrating">Domain Rating(Ahrefs)</label>
                                    <input class="form-control" id="domainrating" type="text" autocomplete="off" placeholder="Domain Rating"
                                        name="domain_rating" value="{{  old('domain_rating') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="organictraficahrefs">Organic Traffic (Ahrefs)</label>
                                    <input class="form-control" id="organictrafic" type="text"
                                        placeholder="Organic Traffic" name="organic_trafic_ahrefs" value="{{  old('organic_trafic_ahrefs') }}" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="organictraficsemrush">Organic Traffic (SEMrush)</label>
                                    <input class="form-control" id="organictraficsemrush" type="text"
                                        placeholder="Organic Traffic" name="organic_trafic_sem" value="{{  old('organic_trafic_sem') }}" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="trustflow">Trust Flow (Majestic)</label>
                                    <input class="form-control" id="trustflow" type="text" autocomplete="off" placeholder="Trust Flow"
                                        name="trust_flow" value="{{  old('trust_flow') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="citationflow">Citation Flow (Majestic)</label>
                                    <input class="form-control" id="citationflow" type="text" autocomplete="off" placeholder="Citation Flow"
                                        name="citation_flow" value="{{  old('citation_flow') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="emailwebmaster">Email (Webmaster)</label>
                                    <input class="form-control" id="emailwebmaster" type="email" autocomplete="off" placeholder="Email"
                                        name="email" value="{{  old('email') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="url">Website Url</label>
                                    <input class="form-control ent" id="url" type="url" autocomplete="off" placeholder="https://www.google.com/"
                                        name="web_url" value="{{  old('web_url') }}" required>
                                    <div id="div1" class="text-danger"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="websitedescription">Website Description</label>
                            <script type="text/javascript">
                                bkLib.onDomLoaded(nicEditors.allTextAreas);
                            </script>
                            <textarea class="form-control textarea" rows="3" cols="50" id="websitedescription"
                                placeholder="Your Message" name="web_description"  autocomplete="off" required>{{  old('web_description') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="specialnote">Special Notes</label>
                            <script type="text/javascript">
                                bkLib.onDomLoaded(nicEditors.allTextAreas);
                            </script>
                            <textarea class="form-control textarea" rows="3" cols="50"
                                placeholder="Your Message" name="special_note"  autocomplete="off">{{  old('special_note') }}</textarea>
                        </div>
                        <div class="text-sm-end">
                            <button type="submit" id="submitBtn" class="btn btn-primary bg-green outline-none">Submit for Approval</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        padding-left: 20px !important;
    }
    textarea.select2-search__field {
        border: none !important;
    }
    </style>

    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $(".ent").on('change', function(ev){
            var value = $(this).val();
            $.ajax({url: "{{route('getUrl')}}",
            data:{'value': value},
             success: function(result){
                if(result){
                    $("#div1").html(result);
                    $('#submitBtn').addClass("disabled");
                }else{
                    $("#div1").html(result);
                    $('#submitBtn').removeClass("disabled");
                }
            }});
        });
        $(".webname").on('change', function(ev){
            var webname = $(this).val();
            $.ajax({url: "{{ route('getName') }}",
            data:{'webname': webname},
             success: function(result){
                if(result){
                    $("#div2").html(result);
                    $('#submitBtn').addClass("disabled");
                }else{
                    $("#div2").html(result);
                    $('#submitBtn').removeClass("disabled");
                }
            }});
        });

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
            var percentage = price ;
            var company = parseInt(price *8/100 + 50) + parseInt(price);
            $("#companyprice").val(company);
        });
    });
    $(document).ready(function() {
        $('.select2').select2({
        });
    });
    $(document).ready(function(){
        $("#outreachcoodinator1").select2();
    });
</script>
