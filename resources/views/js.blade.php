<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function(){
        // Activate tooltip
        $('[data-toggle="tooltip"]').tooltip();
        
        // Select/Deselect checkboxes
        var checkbox = $('table tbody input[type="checkbox"]');
        $("#selectAll").click(function(){
            if(this.checked){
                checkbox.each(function(){
                    this.checked = true;                        
                });
            } else{
                checkbox.each(function(){
                    this.checked = false;                        
                });
            } 
        });
        checkbox.click(function(){
            if(!this.checked){
                $("#selectAll").prop("checked", false);
            }
        });
    });
</script>

<script>
    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Show Employee Data
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('employee.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'address', name: 'address'},
                {data: 'phone', name: 'phone'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        // Add Employee
        $('body').on('click', '.add-employee', function(e){
            e.preventDefault();
            $('.error-messages').html('');
            $.ajax({
                url: "{{ route('employee.store') }}",
                type: "POST",
                data: $('#add-employee').serialize(),
                success: function(response){
                    table.draw();
                    $('#addEmployeeModal').hide();
                    $('.modal-backdrop').remove();
                    if(response){
                        alert(response.success);
                        $('#add-employee')[0].reset(); 
                    }   
                },

                error: function(error){
                    if(error){
                        $('.error-name').html(error.responseJSON.errors.name);
                        $('.error-email').html(error.responseJSON.errors.email);
                        $('.error-address').html(error.responseJSON.errors.address);
                        $('.error-phone').html(error.responseJSON.errors.phone);
                    }
                }
            });
        });

        // Edit Employee
        $('body').on('click', '.edit', function(){
            const id = $(this).data('id');

            $.get('employee/' + id + '/edit', function(data){
                $('#EditEmployeeModal').html(data.html);                
            });

            $('.edit-employee').click(function(e){
                e.preventDefault();
                $.ajax({
                    url: "{{ route('employee.update', '') }}" + '/' + id,
                    type: "PUT",
                    data: $('#edit-employee').serialize(),
                    success: function(response){
                        table.draw();
                        $('#editEmployeeModal').hide();
                        $('.modal-backdrop').remove();
                        if(response){
                            alert(response.success);
                            $('#add-employee')[0].reset(); 
                        }   
                    },

                    error: function(error){
                        if(error){
                            $('.error-name').html(error.responseJSON.errors.name);
                            $('.error-email').html(error.responseJSON.errors.email);
                            $('.error-address').html(error.responseJSON.errors.address);
                            $('.error-phone').html(error.responseJSON.errors.phone);
                        }
                    }
                });
            } );            
        });

        // Delete Employee
        $('body').on('click', '.delete', function(e){
            const id = $(this).data('id');
            $('.delete-employee').click(function(e){
                e.preventDefault();
                $.ajax({
                    url: "{{ route('employee.destroy', '') }}" + '/' + id,
                    type: "DELETE",
                    dataType: 'json',
                    success: function(response){
                        table.draw();
                        $('#deleteEmployeeModal').hide();
                        $('.modal-backdrop').remove();
                        if(response){
                            alert(response.success);                           
                        }
                    }
                });              
            });            
        });
    });

</script>

