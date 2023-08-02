<div id="deleteGuestModal-{{$request->id}}" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form  id="guestDeleteModal-{{$request->id}}" action="{{ route('admin.guest.delete.request',$request->id) }}" method="get" novalidate>
                @csrf
				<div class="modal-header">
					<h4 class="modal-title">Delete User</h4>
					<button type="button" id="deleteGuestModalClose-{{$request->id}}" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to remove this user"</p>
					<p class="text-warning"><small>This action cannot be undone.</small></p>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-danger" value="Delete">
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$("#guestDeleteModal-{{$request->id}}").off("submit").on("submit", function(event) {
			event.preventDefault();
			var formData = $(this).serialize();
			$.ajax({
				type: "get",
				url: $(this).attr("action"),
				data: formData,
				success: function(response) {
					$('#deleteGuestModalClose-{{$request->id}}').trigger('click');
					toastr.success('Guest Request has been deleted');
					guest_table.draw();
				},
				error: function(error) {
					console.error("Error occurred:", error);
				}
			});
		});
	});
</script>