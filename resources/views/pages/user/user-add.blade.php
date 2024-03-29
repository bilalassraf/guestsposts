@extends('layouts.default')
@section('user')
<div class="content-wrapper p-3">
    <div class="row">
        <div class="col-md-12">
            <div class="col-lg-12 col-md-8 col-sm-8 float-right">
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
                                <input class="form-control @error('websitename') is-invalid @enderror" id="websitename" value="{{  old('web_name') }}" type="text" placeholder="Website Name" name="web_name" autocomplete="off" required>
                            </div>
                        </div>
                        <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
                        @if (auth()->user()->type == "Admin")
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="outreachcoodinator1">Outreach Coordinator</label>
                                    <select class="form-control" name="coordinator[]" id="outreachcoodinator1">
                                        @foreach ($guestCoordinator as $Coordinator)
                                            <option>{{$Coordinator}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <div class="mb-3">
                                <input class="form-control" id="outreachcoodinator" type="hidden" value="{{ auth()->user()->id }}" name="coordinator_id" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price">Price</label>
                                <input class="form-control" id="price1" type="text" placeholder="Price" name="price" value="{{  old('price') }}" autocomplete="off" required>&nbsp;<span id="errmsg"></span>
                            </div>
                        </div>
                        @if (auth()->user()->type == "Admin")
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="companyprice">Company price</label>
                                <input class="form-control" id="companyprice" type="text" placeholder="Company Price" autocomplete="off" readonly required>&nbsp;<span id="errmsg1"></span>
                            </div>
                        </div>
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
                                <label for="domainauthority">Domain Authority(Moz)</label>
                                <input class="form-control" id="domainauthority" type="text" value="{{  old('domain_authority') }}" placeholder="Domain Authority" name="domain_authority" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="spanscore">Spam Score</label>
                                <input class="form-control" id="spanscore" type="text" placeholder="Spam Score" value="{{  old('span_score') }}" name="span_score" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="domainrating">Domain Rating(Ahrefs)</label>
                                <input class="form-control" id="domainrating" type="text" placeholder="Domain Rating" value="{{  old('domain_rating') }}" name="domain_rating" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="organictraficahrefs">Organic Traffic (Ahrefs)</label>
                                <input class="form-control" id="organictrafic" type="text" placeholder="Organic Traffic" value="{{  old('organic_trafic_ahrefs') }}" name="organic_trafic_ahrefs" autocomplete="off" required>
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="trustflow">Trust Flow (Majestic)</label>
                                <input class="form-control" id="trustflow" type="text" placeholder="Trust Flow" name="trust_flow" value="{{  old('trust_flow') }}" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="citationflow">Citation Flow (Majestic)</label>
                                <input class="form-control" id="citationflow" type="text" placeholder="Citation Flow" value="{{  old('citation_flow') }}" name="citation_flow" autocomplete="off" required>
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
                                <button type="submit" class="btn bg-lightblack text-white outline-none">Submit for Approval</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<style>
    .select2-search__field{
        display: none;
    }.select2-container--default .select2-selection--multiple .select2-selection__choice__display {
    padding-left: 17px !important;
    }.select2-selection__choice__remove:hover {
    color: black !important;
    margin-left: 0px !important;
    }
</style>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script type="text/javascript">
     $(document).ready(function() {
        $('.select2').select2({
            tags: true,
        });
    });
    $(document).ready(function() {
        //called when key is pressed in textbox
        $("#price1").keypress(function(e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                $("#errmsg").html("Please Enter Integer Value!!").show().fadeOut("slow").css('color', 'red');
                return false;
            }
        });
        $("#price1").keyup(function(){
            var price = $("#price1").val();
            var percentage = price ;
            var company = parseInt(price *8/100 + 50) + parseInt(price);
            $("#companyprice").val(company);
        });
    });
</script>
