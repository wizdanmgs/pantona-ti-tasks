@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Manage Users</div>
            <div class="card-body">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                    <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createNewUser"> Create New User
                    </a>
                </div>

                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Image</th>
                            <th width="280px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="formModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="userForm" name="userForm" class="form-horizontal">
                        <input type="hidden" name="user" id="user_id">
                        @csrf

                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

                        <div class="form-group mb-3">
                            <label for="name" class="col-sm-2 control-label">Name:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Name" value="" maxlength="50" required>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="col-sm-2 control-label">Email:</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter Email" value="" maxlength="50" required>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="col-sm-2 control-label">Password:</label>
                            <div class="col-sm-12">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Enter Password" value="" maxlength="50">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="col-sm-2 control-label">Image:</label>
                            <div class="col-sm-12">
                                <input type="file" id="image" name="image" placeholder="Enter Image"
                                    accept="image/*" class="form-control"></textarea>
                            </div>
                        </div>


                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success mt-2" id="saveBtn" value="create">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"> Show User</h4>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span class="show-name"></span></p>
                    <p><strong>Email:</strong> <span class="show-email"></span></p>
                    <p><strong>Image:</strong> <span class="show-image"></span></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="module">
        $(function() {

            const formModal = new bootstrap.Modal($("#formModal"));
            const showModal = new bootstrap.Modal($("#showModal"));

            // Pass Header Token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Render DataTable
            const table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        render: function(data) {
                            return `"<img src="${data}" width='200' height='200'>"`;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Create New User
            $('#createNewUser').click(function() {
                formModal.show();

                $('#saveBtn').val("create-user");
                $('#user_id').val('');
                $('#userForm').trigger("reset");
                $('#modelHeading').html("Create New User");
            });

            // Show User
            $('body').on('click', '.showUser', function() {
                const user_id = $(this).data('id');
                $.get("{{ route('users.index') }}" + '/' + user_id, function(data) {
                    showModal.show();

                    $('.show-name').text(data.name);
                    $('.show-email').text(data.email);
                    $('.show-image').html(
                        "<img src=" + data.image + " width='200' height='200'>");
                })
            });

            // Edit User
            $('body').on('click', '.editUser', function() {
                const user_id = $(this).data('id');
                const route =
                    $.get("{{ route('users.index') }}" + '/' + user_id + '/edit', function(data) {
                        formModal.show();

                        $('#modelHeading').html("Edit User");
                        $('#saveBtn').val("edit-user");
                        $('#user_id').val(data.id);
                        $('#name').val(data.name);
                        $('#email').val(data.email);
                    })
            });

            // Submit Form
            $('#userForm').submit(function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const user = $('#user_id').val();
                let url = "{{ route('users.store') }}";
                if (user) {
                    url = "{{ route('users.index') }}" + '/' + user;
                }

                $('#saveBtn').html('Sending...');

                console.log(url)

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        $('#saveBtn').html('Submit');
                        $('#userForm').trigger("reset");
                        formModal.hide();
                        table.draw();
                    },
                    error: function(response) {
                        $('#saveBtn').html('Submit');
                        $('#userForm').find(".print-error-msg").find("ul").html('');
                        $('#userForm').find(".print-error-msg").css('display', 'block');
                        $.each(response.responseJSON.errors, function(key, value) {
                            $('#userForm').find(".print-error-msg").find("ul")
                                .append('<li>' + value + '</li>');
                        });
                    }
                });

            });


            // Delete User
            $('body').on('click', '.deleteUser', function() {

                const user_id = $(this).data("id");
                if (confirm("Are You sure want to delete?")) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('users.store') }}" + '/' + user_id,
                        success: function(data) {
                            table.draw();
                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                }
            });
        });
    </script>
@endsection
