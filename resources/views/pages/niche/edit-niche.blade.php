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
                    <h5 style="font-weight:700">Edit Niche</h5>
                </div>
                <div class="contact-form card-body">
                    <form class="theme-form" action="{{ route('admin.chnage.niche', $niche_request->id) }}"
                        method="post">
                        @csrf
                        <div class="form-icon"><i class="icofont icofont-envelope-open"></i></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="websitename">Website Name</label>
                                    <input class="form-control @error('websitename') is-invalid @enderror"
                                        type="text" placeholder="Website Name" value="{{ $niche_request->web_name }}"
                                        name="web_name" required>
                                </div>
                            </div>
                            <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="outreachcoodinator">Outreach Coordinator</label>
                                    <input class="form-control" type="text"
                                        placeholder="Outreach Coordinator" name="coordinator" required
                                        value="{{ $niche_request->Coordinator }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price">Price</label>
                                    <input class="form-control" type="text" placeholder="Price"
                                        required value="{{ $niche_request->price }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="companyprice">Company price</label>
                                    <input class="form-control" type="text" placeholder="Company Price"
                                        name="company_price" required value="{{ $niche_request->company_price }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category">Catoegory</label>
                                    <select name="category" class="dropdown-toggle form-control" type="button"
                                        data-toggle="dropdown" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->category }}">{{ $category->category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="domainauthority">Domain Authority(Moz)</label>
                                    <input class="form-control"  type="text"
                                        placeholder="Domain Authority" name="domain_authority" required
                                        value="{{ $niche_request->domain_authority }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="spanscore">Spam Score</label>
                                    <input class="form-control" type="text" placeholder="Spam Score"
                                        name="span_score" required value="{{ $niche_request->span_score }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="domainrating">Domain Rating(Ahrefs)</label>
                                    <input class="form-control" type="text" placeholder="Domain Rating"
                                        name="domain_rating" required value="{{ $niche_request->domain_rating }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="organictraficahrefs">Organic Traffic (Ahrefs)</label>
                                    <input class="form-control" type="text"
                                        placeholder="Organic Traffic" name="organic_trafic_ahrefs" required
                                        value="{{ $niche_request->organic_trafic_ahrefs }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="organictraficsemrush">Organic Traffic (SEMrush)</label>
                                    <input class="form-control" type="text"
                                        placeholder="Organic Traffic" name="organic_trafic_sem" required
                                        value="{{ $niche_request->organic_trafic_sem }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="trustflow">Trust Flow (Majestic)</label>
                                    <input class="form-control"  type="text" placeholder="Trust Flow"
                                        name="trust_flow" required value="{{ $niche_request->trust_flow }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="citationflow">Citation Flow (Majestic)</label>
                                    <input class="form-control"  type="text" placeholder="Citation Flow"
                                        name="citation_flow" required value="{{ $niche_request->citation_flow }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="emailwebmaster">Email (Webmaster)</label>
                                    <input class="form-control" id="emailwebmaster" type="email" placeholder="Email"
                                        name="email" required value="{{ $niche_request->email_webmaster }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Website Url</label>
                                    <input class="form-control" type="url" placeholder="Email"
                                        name="web_url" required value="{{ $niche_request->web_url }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="websitedescription">Website Description</label>
                            <script type="text/javascript">
                                bkLib.onDomLoaded(nicEditors.allTextAreas);
                            </script>
                            <textarea class="form-control textarea" rows="3" cols="50" id="websitedescription"
                                placeholder="Your Message" name="web_description"
                                required>{{ $niche_request->web_description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label" for="specialnote">Special Notes</label>
                            <script type="text/javascript">
                                bkLib.onDomLoaded(nicEditors.allTextAreas);
                            </script>
                            <textarea class="form-control textarea" rows="3" cols="50"
                                placeholder="Your Message" required
                                name="special_note">{{ $niche_request->special_note }}</textarea>
                        </div>
                        <div class="text-sm-end">
                            <button type="submit" class="btn btn-primary bg-green outline-none">Submit for Approval</button>
                        </div>
                    </form>
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

<script>
     $(document).ready(function() {
        $('.select2').select2({
            tags: true,
        });
    });

</script>
