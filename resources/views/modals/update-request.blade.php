<!-- Edit Modal HTML -->
<div id="editRequestModal-{{$request->id}}" class="modal fade bd-example-modal-lg">
	<div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="theme-form login-form" id="updateForm-{{$request->id}}" action="{{ route('admin.update.request', $request->id) }}" method="POST" novalidate>
                @csrf
				<div class="modal-header bg-dark">
					<h4 class="modal-title">Update Request</h4>
					<button type="button" class="close" id="editRequestModalClose-{{$request->id}}" data-dismiss="modal" aria-hidden="true">&times;</button>
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
                                            <option {{$request->coordinator_id == $guestCoordinator->id ? "selected" : ''}} value="{{$guestCoordinator->id}}">{{$guestCoordinator->name}} , {{$guestCoordinator->email}}</option>
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
                                    <input class="form-control" id="price-{{$request->id}}" type="text" placeholder="Price" name="price"
                                        required value="{{$request->new_price >0 ? $request->new_price : $request->price}}">&nbsp;<span id="errmsg"></span>
                                </div>
                            </div>
                            @if (auth()->user()->type == "Admin")
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="companyprice">Company price</label>
                                        <input class="form-control companypricerequest-{{$request->id}}" type="text" placeholder="Company Price" name="company_price" required value="{{ $request->company_price }}">
                                    </div>
                                </div>
                            @else
                            <input class="form-control companypricerequest-{{$request->id}}" type="hidden" placeholder="Company Price" name="company_price" required value="{{ $request->company_price }}">
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
                                        value="{{ $request->domain_authority }}" id="domainauthoritys">
                                        <p class="text-danger d-none" id="domainAuthss">Minimum Domain Authority(Moz) should be allowed atleast 25+</p>    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="spanscore">Spam Score</label>
                                    <input class="form-control"  type="text" placeholder="Span Score"
                                        name="span_score" required value="{{ $request->span_score }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="domainrating">Domain Rating(Ahrefs)</label>
                                    <input class="form-control"  type="text" placeholder="Domain Rating"
                                        name="domain_rating" required value="{{ $request->domain_rating }}" id="domainratings">
                                    <p class="text-danger d-none" id="domainRatess">Minimum Domain Rating(Ahrefs) should be allowed atleast 25+</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="organictraficahrefs">Organic Trafic (Ahrefs)</label>
                                    <input class="form-control"  type="text"
                                        placeholder="Organic Tranfic" name="organic_trafic_ahrefs" required
                                        value="{{ $request->organic_trafic_ahrefs }}" id="organictraficss">
                                        <p class="text-danger d-none" id="organicTras">Minimum Organic Traffic (Ahrefs) should be allowed atleast 1000+</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="organictraficsemrush">Organic Trafic (SEMrush)</label>
                                    <input class="form-control"  type="text"
                                        placeholder="Organic Trafic" name="organic_trafic_sem" required
                                        value="{{ $request->organic_trafic_sem }}" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="emailwebmaster">Email (Webmaster)</label>
                                    <input class="form-control"  type="email" placeholder="Email"
                                        name="email" required value="{{ $request->email_webmaster }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="site">Site Quality</label>
                                    <select name="site_quality" class="form-control mb-2" id="site_quality"> 
                                        <option value="" disabled selected>Select Site Quality</option>
                                        <option {{ $request->good == 1 ? 'selected' : '' }} value="Good">Good Site</option>
                                        <option {{ $request->black_hat == 1 ? 'selected' : '' }} value="Black">Black Hat</option>
                                    </select>
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

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script>
    $(document).ready(function() {
        $(document).ready(function(){
            $("#outreachcoodinator1").select2();
        });
        $('.select2').select2();
        $(".select2").on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);
            
            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        });
        $("#price-{{$request->id}}").keyup(function(){
            var price = $("#price-{{$request->id}}").val();
            var percentage = price ;
            var company = parseInt(price *8/100 + 50) + parseInt(price);
            $(".companypricerequest-{{$request->id}}").val(company);
        });
        $('#domainauthoritys').on('change', function(ev) { 
            $('#domainAuthss').addClass('d-none'); 
            var value = $(this).val();
            if(value < 25){
                $('#domainAuthss').removeClass('d-none');
            }
        });
        $('#domainratings').on('change', function(ev) {  
            $('#domainRatess').addClass('d-none'); 
            var value = $(this).val();
            if(value < 25){
                $('#domainRatess').removeClass('d-none');
            }
        });
        $('#organictraficss').on('change', function(ev) {  
            $('#organicTras').addClass('d-none'); 
            var value = $(this).val();
            if(value < 1000){
                $('#organicTras').removeClass('d-none');
            }
        });
    });
    $(document).ready(function() {
        $("#updateForm-{{$request->id}}").off("submit").on("submit", function(event) {
            // Your AJAX code here
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: "POST", // Change this to the appropriate method (e.g., POST, PUT, etc.)
                url: $(this).attr("action"), // URL to send the request
                data: formData, // The serialized form data
                success: function(response) {
                    $('#editRequestModalClose-{{$request->id}}').trigger('click');
                    toastr.success('Request has been Updated');
                    guest_table.draw();
                },
                error: function(error) {
                    // Handle errors here (if needed)
                    console.error("Error occurred:", error);
                }
            });
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
    
</style>
