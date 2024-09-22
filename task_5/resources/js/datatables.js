$(function () {
    /*------------------------------------------
             --------------------------------------------
             Pass Header Token
             --------------------------------------------
             --------------------------------------------*/
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    /*------------------------------------------
            --------------------------------------------
            Render DataTable
            --------------------------------------------
            --------------------------------------------*/
    var table = $(".data-table").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users.index') }}",
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
            },
            {
                data: "name",
                name: "name",
            },
            {
                data: "email",
                name: "email",
            },
            {
                data: "image",
                name: "image",
            },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false,
            },
        ],
    });

    /*------------------------------------------
            --------------------------------------------
            Click to Button
            --------------------------------------------
            --------------------------------------------*/
    $("#createNewUser").click(function () {
        $("#saveBtn").val("create-user");
        $("#user_id").val("");
        $("#userForm").trigger("reset");
        $("#modelHeading").html("<i class='fa fa-plus'></i> Create New User");
        $("#ajaxModel").modal("show");
    });

    /*------------------------------------------
            --------------------------------------------
            Click to Edit Button
            --------------------------------------------
            --------------------------------------------*/
    $("body").on("click", ".showUser", function () {
        var user_id = $(this).data("id");
        $.get("{{ route('users.index') }}" + "/" + user_id, function (data) {
            $("#showModel").modal("show");
            $(".show-name").text(data.name);
            $(".show-email").text(data.email);
        });
    });

    /*------------------------------------------
            --------------------------------------------
            Click to Edit Button
            --------------------------------------------
            --------------------------------------------*/
    $("body").on("click", ".editUser", function () {
        var user_id = $(this).data("id");
        $.get(
            "{{ route('users.index') }}" + "/" + user_id + "/edit",
            function (data) {
                $("#modelHeading").html(
                    "<i class='fa-regular fa-pen-to-square'></i> Edit User"
                );
                $("#saveBtn").val("edit-user");
                $("#ajaxModel").modal("show");
                $("#user_id").val(data.id);
                $("#name").val(data.name);
                $("#email").val(data.email);
            }
        );
    });

    /*------------------------------------------
            --------------------------------------------
            Create User Code
            --------------------------------------------
            --------------------------------------------*/
    $("#userForm").submit(function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        $("#saveBtn").html("Sending...");

        $.ajax({
            type: "POST",
            url: "{{ route('users.store') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                $("#saveBtn").html("Submit");
                $("#userForm").trigger("reset");
                $("#ajaxModel").modal("hide");
                table.draw();
            },
            error: function (response) {
                $("#saveBtn").html("Submit");
                $("#userForm").find(".print-error-msg").find("ul").html("");
                $("#userForm").find(".print-error-msg").css("display", "block");
                $.each(response.responseJSON.errors, function (key, value) {
                    $("#userForm")
                        .find(".print-error-msg")
                        .find("ul")
                        .append("<li>" + value + "</li>");
                });
            },
        });
    });

    /*------------------------------------------
            --------------------------------------------
            Delete User Code
            --------------------------------------------
            --------------------------------------------*/
    $("body").on("click", ".deleteUser", function () {
        var user_id = $(this).data("id");
        confirm("Are You sure want to delete?");

        $.ajax({
            type: "DELETE",
            url: "{{ route('users.store') }}" + "/" + user_id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log("Error:", data);
            },
        });
    });
});
