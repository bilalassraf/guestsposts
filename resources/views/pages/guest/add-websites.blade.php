@extends('layouts.default')
@section('title')

Add Website
@endsection

@section('content')

<div class="content-wrapper p-3">
    @include('filter')
    <div class="col-lg-12 col-md-8 col-sm-8">
        <div class="card height-equal">
            <div class="card-header bg-green p-3">
                <h5 style="font-weight:700">Add Website</h5>
            </div>
            <div class="contact-form card-body">
                <form class="theme-form" action="{{ route('admin.store.guest.request') }}" method="post">
                    @csrf
                    <div class="form-icon"><i class="icofont icofont-envelope-open"></i></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="websitename">Website Name</label>
                                <input class="websitename webname form-control @error('websitename') is-invalid @enderror" id="websitename"
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
                                            <option value="{{$guestCoordinator->id}}">{{$guestCoordinator->email}}</option>
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
                                <input class="form-control" id="price" type="text" placeholder="Price" name="price" value="{{  old('price') }}" autocomplete="off" required>&nbsp;<span id="errmsg"></span>
                                <div id="price_error_div"></div>
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
                            <input class="form-control" name="company_price" id="companyprice" type="hidden" placeholder="Company Price" autocomplete="off" readonly required>&nbsp;<span id="errmsg1"></span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category">Category</label>
                                <select name="categories[]" id="category" multiple="multiple" class="select2 form-control" type="button" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="spanscore">Spam Score</label>
                                <input class="form-control" id="spanscore" type="text" autocomplete="off" placeholder="Spam Score"
                                    name="span_score" value="{{  old('span_score') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="domainauthority">Domain Authority(Moz)</label>
                                <input class="form-control" id="domainauths" minlength="25" min="25" type="number" value="{{  old('domain_authority') }}" placeholder="Domain Authority" name="domain_authority" autocomplete="off" required>
                                <p class="text-danger d-none domainAuth" id="domainAuth">Minimum Domain Authority(Moz) should be allowed atleast 25+</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="domainrating">Domain Rating(Ahrefs)</label>
                                <input class="form-control" id="domainrating" type="number" placeholder="Domain Rating" value="{{  old('domain_rating') }}" name="domain_rating" autocomplete="off" required>
                                <p class="text-danger d-none domainRate" id="domainRate">Minimum Domain Rating(Ahrefs) should be allowed atleast 25+</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="organictraficahrefs">Organic Traffic (Ahrefs)</label>
                                <input class="form-control" id="organictrafic" type="text" placeholder="Organic Traffic" value="{{  old('organic_trafic_ahrefs') }}" name="organic_trafic_ahrefs" autocomplete="off" required>
                                <p class="text-danger d-none" id="organicTra">Minimum Organic Traffic (Ahrefs) should be allowed atleast 1000+</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="organictraficsemrush">Organic Traffic (SEMrush)</label>
                                <input class="form-control" id="organictraficsemrush" type="text" placeholder="Organic Traffic" value="{{  old('organic_trafic_sem') }}" name="organic_trafic_sem" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="emailwebmaster">Email (Webmaster)</label>
                                <input class="form-control" id="emailwebmaster" type="email" placeholder="Email" value="{{  old('email') }}" name="email" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label" for="websitedescription">Website Description</label>
                        <script type="text/javascript">
                            bkLib.onDomLoaded(nicEditors.allTextAreas);

                        </script>
                        <textarea class="form-control textarea" rows="3" cols="50" id="websitedescription" value="{{  old('web_description') }}"  placeholder="Your Message" name="web_description" autocomplete="off" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label" for="specialnote">Special Notes</label>
                        <script type="text/javascript">
                            bkLib.onDomLoaded(nicEditors.allTextAreas);

                        </script>
                        <textarea class="form-control textarea" id="specialnote" rows="3" cols="50" placeholder="Your Message" autocomplete="off" value="{{  old('special_note') }}" name="special_note"></textarea>
                    </div>
                    <div class="text-sm-end">
                        <button type="submit" id="submitBtn" class="btn text-white bg-lightblack outline-none">Submit for Approval</button>
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
        $(".webname").on('change', function (ev) {
        var webname = $(this).val();
            $.ajax({
                url: "{{ route('guestName') }}",
                data: { 'webname': webname },
                success: function (response) {
                var result = response.result;
                    if (response.status === 'fail') {
                        // Display the result message in div2
                        $("#div2").html(result);
                        // Prevent form submission
                        $('#submitBtn').addClass("d-none");
                    }
                    if(response.status === 'pass') {
                        $("#div2").html(result);
                        // Allow form submission
                        $('#submitBtn').removeClass("d-none");
                    }
                    if(response.status === '' && response.result === ''){
                        $("#div2").html("");
                        $('#submitBtn').removeClass("d-none");
                    }
                }
            });
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
        $("#price").on('change', function (ev) {
            var price = $("#price").val();
            var percentage = price;
            var company = parseInt(price * 8 / 100 + 50) + parseInt(price);
            $("#companyprice").val(company);
            var webName = $(".webname").val();
            $.ajax({
                url: "{{ route('guestCheckPrice') }}",
                data: {'price': price, 'webName': webName},
                success: function (response) {
                    var result = response.result;
                    var color = response.color;

                    $("#price_error_div").html(result);
                    $("#price_error_div").css('color', color);

                    if (color === "red") {
                        $('#submitBtn').addClass("disabled");
                    } else {
                        $('#submitBtn').removeClass("disabled");
                    }
                }
            });
        });
        $('#domainauths').on('change', function() {
            $('.domainAuth').addClass('d-none');  
            var vals = $(this).val();
            if(vals < 25){
                $('.domainAuth').removeClass('d-none');
            }
        });
        $('#domainrating').on('change', function(ev) {  
            $('.domainRate').addClass('d-none'); 
            var value = $(this).val();
            if(value < 25){
                $('.domainRate').removeClass('d-none');
            }
        });

        $('#organictrafic').on('change', function(ev) {  
            $('#organicTra').addClass('d-none'); 
            var value = $(this).val();
            if(value < 1000){
                $('#organicTra').removeClass('d-none');
            }
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
    $(document).ready(function() {
        $('.select2').select2();
        $(".select2").on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);
            
            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        });
    });
    $(document).ready(function(){
        $("#outreachcoodinator1").select2();
    });
</script>
