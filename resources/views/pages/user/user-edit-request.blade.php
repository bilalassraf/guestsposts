@extends('layouts.default')
@section('user')
<div class="content-wrapper p-3">
<div class="card">
<div class="card-header bg-green">
    <h1 class="card-title p-3" style="font-weight:500;font-size:32px;">Update Website Request</h1>
</div>
  <div class="card-body">

   <form class="theme-form" action="{{ route('user.edit.request.post',$request->id) }}" method="post">
                                    @csrf
                                <div class="form-icon"><i class="icofont icofont-envelope-open"></i></div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="websitename">Website Name</label>
                                                <input class="form-control @error('websitename') is-invalid @enderror" id="websitename" type="text" placeholder="Website Name" name="web_name" value="{{ $request->web_name }}" required>
                                            </div>
                                        </div>
                                        <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="outreachcoodinator">Outreach Coordinator</label>
                                                <input class="form-control" id="outreachcoodinator" type="text" placeholder="Outreach Coordinator" name="coordinator" value="{{ $request->Coordinator }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="price">Price</label>
                                                <input class="form-control" id="price" type="text" placeholder="Price" name="price" value="{{ $request->price }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="companyprice">Company price</label>
                                                <input class="form-control" id="companyprice" type="text" readonly value="{{ $request->company_price }}" name="company_price" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="category">Catoegory</label>
                                                    <select name="category" id="category" class="dropdown-toggle form-control" type="button" data-toggle="dropdown" required>
                                                        @foreach ($categories as $category)
                                                        <option value="{{ $category->category }}">{{ $category->category }}</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="domainauthority">Domain Authority(Moz)</label>
                                                <input class="form-control" id="domainauthority" type="text" placeholder="Domain Authority" name="domain_authority" required value="{{ $request->domain_authority }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="spanscore">Spam Score</label>
                                                <input class="form-control" id="spanscore" type="text" placeholder="Spam Score" name="span_score" required value="{{ $request->span_score }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="domainrating">Domain Rating(Ahrefs)</label>
                                                <input class="form-control" id="domainrating" type="text" placeholder="Domain Rating" name="domain_rating" required value="{{ $request->domain_rating }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="organictraficahrefs">Organic Trafic (Ahrefs)</label>
                                                <input class="form-control" id="organictrafic" type="text" placeholder="Organic Tranfic" name="organic_trafic_ahrefs" required value="{{ $request->organic_trafic_ahrefs }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="organictraficsemrush">Organic Trafic (SEMrush)</label>
                                                <input class="form-control" id="organictraficsemrush" type="text" placeholder="Organic Trafic" name="organic_trafic_sem" required value="{{ $request->organic_trafic_sem }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="trustflow">Trust Flow (Majestic)</label>
                                                <input class="form-control" id="trustflow" type="text" placeholder="Trust Flow" name="trust_flow" required value="{{ $request->trust_flow }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="citationflow">Citation Flow (Majestic)</label>
                                                <input class="form-control" id="citationflow"  type="text" placeholder="Citation Flow" name="citation_flow" required value="{{ $request->citation_flow }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="emailwebmaster">Email (Webmaster)</label>
                                                <input class="form-control" id="emailwebmaster" type="email" readonly name="email" required value="{{ $request->email_webmaster }}">
                                            </div>
                                        </div>
                                    </div>
                                      <div class="mb-3">
                                    <label class="col-form-label" for="websitedescription">Website Description</label>
                                    <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
                                    <textarea class="form-control textarea" rows="3" cols="50" id="websitedescription" placeholder="Your Message" name="web_description" required>{{ $request->web_description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label" for="specialnote">Special Notes</label>
                                    <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
                                    <textarea class="form-control textarea" id="specialnote" rows="3" cols="50" placeholder="Your Message" required name="special_note">{{ $request->special_note }}</textarea>
                                </div>
                                <div class="text-sm-end">
                                    <button type="submit" class="btn bg-green">Send Request</button>
                                </div>
                            </form>
  </div>
</div>

@endsection
