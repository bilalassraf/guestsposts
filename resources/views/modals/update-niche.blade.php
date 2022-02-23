<!-- Edit Modal HTML -->
<div id="editNicheModal-{{ $niche->id }}" class="modal fade bd-example-modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title">Update Niche</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form class="theme-form" action="{{ route('admin.chnage.niche', $niche->id) }}" method="post" novalidate>
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="outreachcoodinator">Outreach Coordinator</label>
                                <input class="form-control" id="outreachcoodinator" type="text" placeholder="Outreach Coordinator" name="coordinator" required value="{{ $niche->Coordinator }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price">Price</label>
                                <input class="form-control" id="price" type="text" placeholder="Price" name="price" required value="{{ $niche->price }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="companyprice">Company price</label>
                                <input class="form-control" id="companyprice" type="text" placeholder="Company Price" name="company_price" required value="{{ $niche->company_price }}">
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
                                <input class="form-control" id="domainauthority" type="text" placeholder="Domain Authority" name="domain_authority" required value="{{ $niche->domain_authority }}">
                            </div>
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
                                <input class="form-control" id="domainrating" type="text" placeholder="Domain Rating" name="domain_rating" required value="{{ $niche->domain_rating }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="organictraficahrefs">Organic Traffic (Ahrefs)</label>
                                <input class="form-control" id="organictrafic" type="text" placeholder="Organic Traffic" name="organic_trafic_ahrefs" required value="{{ $niche->organic_trafic_ahrefs }}">
                            </div>
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
                                <label for="trustflow">Trust Flow (Majestic)</label>
                                <input class="form-control" id="trustflow" type="text" placeholder="Trust Flow" name="trust_flow" required value="{{ $niche->trust_flow }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="citationflow">Citation Flow (Majestic)</label>
                                <input class="form-control" id="citationflow" type="text" placeholder="Citation Flow" name="citation_flow" required value="{{ $niche->citation_flow }}">
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
                                <label>Website Url</label>
                                <input class="form-control" type="url" placeholder="Email" name="web_url" required value="{{ $niche->web_url }}">
                            </div>
                        </div>
                    </div>
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
                    <div class="text-sm-end">
                        <input type="submit" class="btn bg-dark outline-none" value="Send Request">
                    </div>
                </form>
            </div>
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
