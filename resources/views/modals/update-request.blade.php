<!-- Edit Modal HTML -->
<form class="theme-form login-form" method="post" action="{{ route('admin.update.request', $request->id) }}" novalidate>
    @csrf
<div id="editRequestModal-{{$request->id}}" class="modal fade bd-example-modal-lg">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
				<div class="modal-header bg-dark">
					<h4 class="modal-title">Update Request</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
	                <!--   <form class="theme-form" action="{{ route('admin.update.request', $request->id) }}"
                        method="post"> -->
                        @csrf
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="outreachcoodinator">Outreach Coordinator</label>
                                    <input class="form-control"  type="text"
                                        placeholder="Outreach Coordinator" name="coordinator" required
                                        value="{{ $request->Coordinator }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price">Price</label>
                                    <input class="form-control" type="text" placeholder="Price" name="price"
                                        required value="{{ $request->price }}">&nbsp;<span id="errmsg"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="companyprice">Company price</label>
                                    <input class="form-control"  type="text" placeholder="Company Price"
                                        name="company_price" required value="{{ $request->company_price }}">&nbsp;<span id="errmsg1"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category">Catoegory</label>
                                    <select name="categories[]" multiple class="select2 form-control" type="button"
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
                                        value="{{ $request->domain_authority }}">
                                </div>
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
                                        name="domain_rating" required value="{{ $request->domain_rating }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="organictraficahrefs">Organic Trafic (Ahrefs)</label>
                                    <input class="form-control"  type="text"
                                        placeholder="Organic Tranfic" name="organic_trafic_ahrefs" required
                                        value="{{ $request->organic_trafic_ahrefs }}">
                                </div>
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="trustflow">Trust Flow (Majestic)</label>
                                    <input class="form-control"  type="text" placeholder="Trust Flow"
                                        name="trust_flow" required value="{{ $request->trust_flow }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="citationflow">Citation Flow (Majestic)</label>
                                    <input class="form-control"  type="text" placeholder="Citation Flow"
                                        name="citation_flow" required value="{{ $request->citation_flow }}">
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

<script>
    $(document).ready(function() {
    $('body .select2').select2({
        tags: true,
    });
});
</script>

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