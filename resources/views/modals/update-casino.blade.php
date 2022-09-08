<!-- Edit Modal HTML -->
<form class="theme-form login-form" method="post" action="{{ route('admin.update.casino', $request->id) }}" novalidate>
    @csrf
<div id="editRequestModal-{{$request->id}}" class="modal fade bd-example-modal-lg">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
				<div class="modal-header bg-dark">
					<h4 class="modal-title">Update Request</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
                        <div class="form-icon"><i class="icofont icofont-envelope-open"></i></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="websitename">Website Name</label>
                                    <input class="form-control @error('websitename') is-invalid @enderror"
                                        type="text" placeholder="Website Name" value="{{ $request->web_name }}"
                                        name="web_name" required>
                                </div>
                            </div>
                            <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
                        @if (auth()->user()->type == "Admin" || auth()->user()->type == "Moderator")
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="outreachcoodinator1">Outreach Coordinator</label><br>
                                    <select class="form-control" name="coordinator_id" id="outreachcoodinator1" style="width: 100%;">
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
                                    <input class="form-control" id="price" type="text" placeholder="Price" name="price"
                                        required value="{{$request->new_price >0 ? $request->new_price : $request->price}}">&nbsp;<span id="errmsg"></span>
                                </div>
                            </div>
                            @if (auth()->user()->type == "Admin")
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="companyprice">Company price</label>
                                        <input class="form-control" id="companyprice" type="text" placeholder="Company Price" name="company_price" required value="{{ $request->company_price }}">
                                    </div>
                                </div>
                            @else
                            <input class="form-control" id="companyprice" type="hidden" placeholder="Company Price" name="company_price" required value="{{ $request->company_price }}">
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category">Catoegory</label>
                                    <select name="categories[]" multiple class="select2 form-control selectCategory" type="button"
                                        data-toggle="dropdown" required style="width: 100%">
                                        @php
                                            $request_cats = $request->categories->pluck('id')->toArray();
                                        @endphp
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ in_array( $category->id, $request_cats)?'selected':'' }}>{{ $category->category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="domainauthority">Domain Authority(Moz)</label>
                                    <input class="form-control"  type="text"
                                        placeholder="Domain Authority" name="domain_authority" required
                                        value="{{ $request->domain_authority }}" id="domainauthorityCasino">
                                </div>
                                <p class="text-danger d-none" id="domainAuthCasino">Minimum Domain Authority(Moz) should be allowed atleast 25+</p>    
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="spanscore">Span Score</label>
                                    <input class="form-control"  type="text" placeholder="Span Score"
                                        name="span_score" required value="{{ $request->span_score }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="domainrating">Domain Rating(Ahrefs)</label>
                                    <input class="form-control"  type="text" placeholder="Domain Rating"
                                        name="domain_rating" required value="{{ $request->domain_rating }}" id="domainratingCasino">
                                </div>
                                <p class="text-danger d-none" id="domainRateCasino">Minimum Domain Rating(Ahrefs) should be allowed atleast 25+</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="organictraficahrefs">Organic Trafic (Ahrefs)</label>
                                    <input class="form-control"  type="text"
                                        placeholder="Organic Tranfic" name="organic_trafic_ahrefs" required
                                        value="{{ $request->organic_trafic_ahrefs }}" id="organictraficCasino">
                                </div>
                                <p class="text-danger d-none" id="organicTrasCasino">Minimum Organic Traffic (Ahrefs) should be allowed atleast 1000+</p>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="organictraficsemrush">Organic Trafic (SEMrush)</label>
                                    <input class="form-control"  type="text"
                                        placeholder="Organic Trafic" name="organic_trafic_sem" required
                                        value="{{ $request->organic_trafic_sem }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="emailwebmaster">Email (Webmaster)</label>
                                    <input class="form-control"  type="email" placeholder="Email"
                                        name="email" required value="{{ $request->email_webmaster }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="websitedescription">Website Description</label>
                            {{-- <script type="text/javascript">
                                bkLib.onDomLoaded(nicEditors.allTextAreas);
                            </script> --}}
                            <textarea class="form-control textarea" rows="3" cols="50"
                                placeholder="Your Message" name="web_description"
                                required>{{ $request->web_description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="specialnote">Special Notes</label>
                            {{-- <script type="text/javascript">
                                bkLib.onDomLoaded(nicEditors.allTextAreas);
                            </script> --}}
                            <textarea class="form-control textarea"  rows="3" cols="50"
                                placeholder="Your Message" required
                                name="special_note">{{ $request->special_note }}</textarea>
                        </div>

				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn bg-lightblack text-white" value="Update">
				</div>
			</form>
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

    $(document).ready(function() {
    $('.select2').select2({
        tags: true,
    });
    $(document).ready(function(){
        $("#outreachcoodinator1").select2();
    });
    $("#price").keyup(function(){
        var price = $("#price").val();
        var percentage = price ;
        var company = parseInt(price *8/100 + 50) + parseInt(price);
        $("#companyprice").val(company);
    });
    $('#domainauthorityCasino').on('change', function(ev) {  
        $('#domainAuthCasino').addClass('d-none'); 
        var value = $(this).val();
        if(value < 25){
            $('#domainAuthCasino').removeClass('d-none');
        }
    });
    $('#domainratingCasino').on('change', function(ev) {  
        $('#domainRateCasino').addClass('d-none'); 
        var value = $(this).val();
        if(value < 25){
            $('#domainRateCasino').removeClass('d-none');
        }
    });

    $('#organictraficCasino').on('change', function(ev) {  
        $('#organicTrasCasino').addClass('d-none'); 
        var value = $(this).val();
        if(value < 1000){
            $('#organicTrasCasino').removeClass('d-none');
        }
    });
});
</script>
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        padding-left: 20px !important;
        color: black;
    }
    textarea.select2-search__field {
        border: none !important;
    }
    .select2-container--default .select2-selection--single {
    height: 38px !important;
    }
     .selectCategory span.select2-selection.select2-selection--single {
        display: none;
    }
</style>
