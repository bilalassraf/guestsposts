 <table class="table table-hover text-nowrap" id="example">
                                <thead>
                                    <tr>
                                        <th scope="col"><input type="checkbox" class="check-all"></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Phone #no</th>
                                        <th>Website</th>
                                         <th >Outreach Coordinator</th>
                                         <th>Webmaster Price</th>
                                          <th>Status</th>
                                             <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($guest_requests as $request)
                                        <tr data-widget="expandable-table" aria-expanded="false">
                                            <td><input type="checkbox" class="check" value="{{ $request->id }}" name="ids[]"><i class="expandable-table-caret fas fa-caret-right fa-fw"></i></td>
                                            <td>{{ $request->web_name }}</td>
                                            <td>{{ $request->email_webmaster }}</td>
                                            <td>{{ $request->Coordinator }}</td>
                                            <td>{{ Str::limit($request->web_description, 50, ' (...)') }}</td>
                                             <td>{{ $request->web_name }}</td>
                                             <td>{{ $request->Coordinator }}</td>
                                             <td>{{ $request->price }}</td>
                                            <td>{{ $request->status }}</td>
                                            <td>{{ $request->updated_at->todatestring() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>