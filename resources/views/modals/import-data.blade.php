

        <div class="modal" id="importData" tabindex="-1" data-backdrop="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header  bg-green">
                  <h5 class="modal-title" id="exampleModalLabel">Import Data From Computer</h5>
                  <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <form action="{{route('import.excel')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="m-2 d-flex flex-column">
                                <input type="file" class="form-control p-1" name="file">
                                <input type="submit" class="mt-2 bg-dark" value="upload" class="bg-dark text-white ml-3">
                            </div>
                            <!-- <input type="submit" value="upload" class="bg-dark text-white p-2"> -->
                    </form>
                </div>
              </div>
            </div>
          </div>

    