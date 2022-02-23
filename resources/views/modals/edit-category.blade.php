

        <div class="modal" id="editCategory-{{$category->id}}" tabindex="-1" data-backdrop="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header bg-green">
                  <h5 class="modal-title text-black-50 text-white" id="exampleModalLabel">Edit Category</h5>
                  <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('admin.edit.category',$category->id) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text"><i class="material-icons text-green">edit</i></span>
                            <input class="form-control @error('category') is-invalid @enderror" type="text" name="category" value="{{ $category->category }}" required />
                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-lightblack text-white border-0">Update Category</button>
                      </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

