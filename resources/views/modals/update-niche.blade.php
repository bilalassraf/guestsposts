<!-- Edit Modal HTML -->
<div id="editNicheModal-{{ $niche->id }}" class="modal fade bd-example-modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Update Niche</h4>
                <button type="button" id="editNicheModalClose-{{ $niche->id }}" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form class="theme-form" id="updateNicheForm-{{$niche->id}}" action="{{ route('admin.chnage.niche', $niche->id) }}" method="post" novalidate>
                    @csrf
                    <div class="form-icon"><i class="icofont icofont-envelope-open"></i></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="websitename">Website Name</label>
                                <input class="form-control @error('websitename') is-invalid @enderror" id="websitename" type="text" placeholder="Website Name" value="{{ $niche->web_name }}" name="web_name" required>
                            </div>
                        </div>
                        <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
                        @if (auth()->user()->type == "Admin" || auth()->user()->type == "Moderator")
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="outreachcoodinator1">Outreach Coordinator</label><br>
                                    <select class="form-control" name="coordinator_id" id="outreachcoodinator1" style="width: 100%;">
                                        @foreach ($guestCoordinator as $guestCoordinator)
                                            <option {{$niche->coordinator_id == $guestCoordinator->id ? "selected" : ''}} value="{{$guestCoordinator->id}}">{{$guestCoordinator->name}} , {{$guestCoordinator->email}}</option>
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
                                <input class="form-control" id="priceNiche-{{$niche->id}}" type="text" placeholder="Price" name="price" required value="{{ $niche->price }}">
                            </div>
                        </div>
                        @if (auth()->user()->type == "Admin")
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="companyprice">Company price</label>
                                    <input class="form-control companyprice-{{$niche->id}}" type="text" placeholder="Company Price" name="company_price" required value="{{ $niche->company_price }}">
                                </div>
                            </div>
                        @else
                        <input class="form-control companyprice-{{$niche->id}}" type="hidden" placeholder="Company Price" name="company_price" required value="{{ $niche->company_price }}">
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category">Catoegory</label>
                                <select name="categories[]" multiple class="select2 form-control selectCategory" type="button"
                                    data-toggle="dropdown" required style="width: 100%">
                                    @php
                                        $request_cats = $niche->categories->pluck('id')->toArray();
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
                                <input class="form-control" id="domainauthorityNiche" type="text" placeholder="Domain Authority" name="domain_authority" required value="{{ $niche->domain_authority }}">
                            </div>
                            <p class="text-danger d-none" id="domainAuthNiche">Minimum Domain Authority(Moz) should be allowed atleast 25+</p>    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="spanscore">Spam Score</label>
                                <input class="form-control" id="spanscore" type="text" placeholder="Spam Score" name="span_score" required value="{{ $niche->span_score }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="domainrating">Domain Rating(Ahrefs)</label>
                                <input class="form-control" id="domainratingNiche" type="text" placeholder="Domain Rating" name="domain_rating" required value="{{ $niche->domain_rating }}">
                            </div>
                            <p class="text-danger d-none" id="domainRateNiche">Minimum Domain Rating(Ahrefs) should be allowed atleast 25+</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="organictraficahrefs">Organic Traffic (Ahrefs)</label>
                                <input class="form-control" id="organictraficNiche" type="text" placeholder="Organic Traffic" name="organic_trafic_ahrefs" required value="{{ $niche->organic_trafic_ahrefs }}">
                            </div>
                            <p class="text-danger d-none" id="organicTrasNiche">Minimum Organic Traffic (Ahrefs) should be allowed atleast 1000+</p>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="organictraficsemrush">Organic Traffic (SEMrush)</label>
                                <input class="form-control" id="organictraficsemrush" type="text" placeholder="Organic Traffic" name="organic_trafic_sem" required value="{{ $niche->organic_trafic_sem }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="emailwebmaster">Email (Webmaster)</label>
                                <input class="form-control" id="emailwebmaster" type="email" placeholder="Email" name="email" required value="{{ $niche->email_webmaster }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="site">Site Quality</label>
                                <select name="site_quality" class="form-control mb-2" id="site_quality"> 
                                    <option value="" disabled selected>Select Site Quality</option>
                                    <option {{ $niche->good == 1 ? 'selected' : '' }} value="Good">Good Site</option>
                                    <option {{ $niche->black_hat == 1 ? 'selected' : '' }} value="Black">Black Hat</option>
                                </select>
                            </div>    
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label>Website Url</label>
                                <input class="form-control" type="url" placeholder="Email" name="web_url" required value="{{ $niche->web_url }}">
                            </div>
                        </div>
                    </div> --}}
                    <div class="mb-3">
                        <label class="col-form-label" for="websitedescription">Website Description</label>
                        <script type="text/javascript">
                            bkLib.onDomLoaded(nicEditors.allTextAreas);

                        </script>
                        <textarea class="form-control textarea" rows="3" cols="50" id="websitedescription" placeholder="Your Message" name="web_description" required>{{ $niche->web_description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label" for="specialnote">Special Notes</label>
                        <script type="text/javascript">
                            bkLib.onDomLoaded(nicEditors.allTextAreas);
                        </script>
                        <textarea class="form-control textarea" id="specialnote" rows="3" cols="50" placeholder="Your Message" required name="special_note">{{ $niche->special_note }}</textarea>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn bg-lightblack text-white" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
    $('.select2').select2();
    $(".select2").on("select2:select", function (evt) {
        var element = evt.params.data.element;
        var $element = $(element);
        
        $element.detach();
        $(this).append($element);
        $(this).trigger("change");
    });
    $(document).ready(function(){
        $("#outreachcoodinator1").select2();
    });
    $("#priceNiche-{{$niche->id}}").keyup(function(){
        var price = $("#priceNiche-{{$niche->id}}").val();
        var percentage = price ;
        var company = parseInt(price *8/100 + 50) + parseInt(price);
        $(".companyprice-{{$niche->id}}").val(company);
    });
    $('#domainauthorityNiche').on('change', function(ev) {  
        $('#domainAuthNiche').addClass('d-none'); 
        var value = $(this).val();
        if(value < 25){
            $('#domainAuthNiche').removeClass('d-none');
        }
    });
    $('#domainratingNiche').on('change', function(ev) {  
        $('#domainRateNiche').addClass('d-none'); 
        var value = $(this).val();
        if(value < 25){
            $('#domainRateNiche').removeClass('d-none');
        }
    });
    $('#organictraficNiche').on('change', function(ev) {  
        $('#organicTrasNiche').addClass('d-none'); 
        var value = $(this).val();
        if(value < 1000){
            $('#organicTrasNiche').removeClass('d-none');
        }
    });
    $(document).ready(function() {
        $("#updateNicheForm-{{$niche->id}}").off("submit").on("submit", function(event) {
            // Your AJAX code here
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: "POST", // Change this to the appropriate method (e.g., POST, PUT, etc.)
                url: $(this).attr("action"), // URL to send the request
                data: formData, // The serialized form data
                success: function(response) {
                    $('#editNicheModalClose-{{$niche->id}}').trigger('click');
                    toastr.success('Request has been Updated');
                    table.draw();
                },
                error: function(error) {
                    // Handle errors here (if needed)
                    console.error("Error occurred:", error);
                }
            });
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
