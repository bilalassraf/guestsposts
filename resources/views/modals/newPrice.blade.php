
<div class="modal" id="newPriceModel-{{ $request->id }}" tabindex="-1" data-backdrop="false" aria-labelledby="exampleModalLabel1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header  bg-green">
        <h5 class="modal-title" id="exampleModalLabel1">Change Your Price</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
              <div class="input-group">
                  <span class="input-group-text"><i class="fa fa-list-alt"></i></span>
                  <input class="form-control allow-numeric @error('new_price') is-invalid @enderror" type="text" id="update_price{{$request->id}}" value="{{ old('new_price') }}" required autocomplete="off" />
                  <span class="error" style="color: red; display: none">* Input digits (0 - 9)</span>
                  @error('new_price')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancle</button>
              <input type="button" onclick='showModal({{ $request->id }})' value="Save" class="btn bg-lightblack text-white mybutton">
            </div>

      </div>
    </div>
  </div>
</div>

<div class="modal myModal" id="myModal-{{$request->id}}" data-backdrop="false" aria-labelledby="exampleModalLabel1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1"><b>Are You Sure ?</b></h5>
      </div>
      <div class="modal-body">
        <form id="updatePriceModal-{{$request->id}}" action="{{ route('user.new.price',$request->id) }}" method="post">
          @csrf
          <div class="form-group">
              <p>Changing the price will require admin approval.
              <br>If we do not approve,then you will be required to change price again to fit out model</p>
          </div>
          <input type="hidden" name="new_price" id="new_price{{$request->id}}">
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="myModal">Cancle</button>
              <button type="submit" value="" class="btn bg-lightblack text-white mybutton">Understand</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $("#updatePriceModal-{{$request->id}}").off("submit").on("submit", function(event) {
        // Your AJAX code here
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: "POST", // Change this to the appropriate method (e.g., POST, PUT, etc.)
            url: $(this).attr("action"), // URL to send the request
            data: formData, // The serialized form data
            success: function(response) {
                $('#myModal-{{$request->id}}').hide('#myModal');
                toastr.success('New Price Updated Successfully');
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
