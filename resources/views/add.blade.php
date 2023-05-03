<div id="addEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="add-employee">
				@csrf
				<div class="modal-header">						
					<h4 class="modal-title">Add Employee</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="form-control" required>
						<span class="error-name error-messages text-danger"></span>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="email" class="form-control" required>
						<span class="error-email error-messages text-danger"></span>
					</div>
					<div class="form-group">
						<label>Address</label>
						<textarea class="form-control" name="address" required></textarea>
						<span class="error-address error-messages text-danger"></span>
					</div>
					<div class="form-group">
						<label>Phone</label>
						<input type="text" name="phone" class="form-control" required>
						<span class="error-phone error-messages text-danger"></span>
					</div>					
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-success add-employee" value="Add">
				</div>
			</form>
		</div>
	</div>
</div>