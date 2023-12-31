<!DOCTYPE html>
<html>

<head>
    <title>Laravel</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="render">
    <div class="container">

        <div class="row mt-5 mb-5">
            <div class="col-10 offset-1 mt-5">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="text-white">Add User</h3>
                    </div>
                    <div class="card-body">

                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        <form id="formData" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include('form')

                            <div class="form-group text-center mt-2">
                                <button class="btn btn-success btn-submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <strong> Search :
        <input type="text" data-url="{{ route('user.search') }}" class="search_data form-control"><br>
    </strong>
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Hobby</th>
            <th>Email</th>
            <th>Picture</th>
            <th width="280px">Action</th>
        </tr>
        <tbody id="reload_data" class="reload_data">
            @include('tableData')
        </tbody>

    </table>
    </div>

</body>

</html>
<style>
    .hide {
        display: none !important;
    }
</style>
<script src="{{ asset('resources/js/jquery.js') }}"></script>
<script src="{{ asset('resources/js/swal.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#formData').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var name = $('.name').val();
            var email = $('.email').val();
            var phone = $('.phone').val();
            var check = 1;

            if (!/^[A-Za-z\s]+$/.test(name)) {
                check = 0; // Validation failed
                $('#name_error').removeClass("hide");
            } else {
                $('#name_error').addClass('hide');
            }

            // Validate the email field
            if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
                check = 0;
                $('#email-error').text('Enter a valid email address');
            } else {
                $('#email-error').text('');
            }

            if (!/^\d{10}$/.test(phone)) {
                check = 0;
                $('#phone_error').text('Phone number must contain 10 digits');
            } else {
                $('#phone_error').text('');
            }

            if (check === 1) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('save.data') }}",
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.success == true) {
                            swal('User Added Successfully !');
                            $('#formData')[0].reset();
                            $("#reload_data").load("{{ route('user.reload') }}");
                        } else {
                            alert('Error');
                            $("#reload_data").load("{{ route('user.reload') }}");
                        }
                    },
                });
            } else {
                alert('Validation error');
            }
        });
    });


    // For edit form submit
    // $(document).ready(function() {
    //     $('#editForm').submit(function(e) {
    //         e.preventDefault();
    //         var editedForm = new FormData(this);
    //         var name = $('.edit_name').val();
    //         var phone = $('.edit_phone').val();

    //         var check = 1;

    //         if (!/^[A-Za-z\s]+$/.test(name)) {
    //             check = 0; // Validation failed
    //             $('#edit_name_error').removeClass("hide");
    //         } else {
    //             $('#edit_name_error').addClass('hide');
    //         }

    //         if (!/^\d{10}$/.test(phone)) {
    //             check = 0;
    //             $('#edit_phone_error').text('Phone number must contain 10 digits');
    //         } else {
    //             $('#edit_phone_error').text('');
    //         }

    //         if (check === 1) {
    //             $.ajax({
    //                 type: 'POST', //here somehow Put method was not supported
    //                 url: "{{ route('update.data') }}",
    //                 data: editedForm,
    //                 dataType: 'json',
    //                 contentType: false,
    //                 processData: false,
    //                 success: function(data) {
    //                     if (data.success == true) {
    //                         $("#myModal").modal('hide');
    //                         swal('User Updated Successfully !');
    //                         $("#reload_data").load("{{ route('user.reload') }}");
    //                     } else {
    //                         alert('Error');
    //                         $("#reload_data").load("{{ route('user.reload') }}");
    //                     }
    //                 },
    //             });
    //         } else {
    //             alert('Validation error');
    //         }
    //     });
    // });

    // $(document).ready(function() {
        $(document).on('submit', '#editForm', function(e) {
            e.preventDefault();
            var editedForm = new FormData(this);
            var name = $('.edit_name').val();
            var phone = $('.edit_phone').val();
            var check = 1;

            if (!/^[A-Za-z\s]+$/.test(name)) {
                check = 0; // Validation failed
                $('#edit_name_error').removeClass("hide");
            } else {
                $('#edit_name_error').addClass('hide');
            }

            if (!/^\d{10}$/.test(phone)) {
                check = 0;
                $('#edit_phone_error').text('Phone number must contain 10 digits');
            } else {
                $('#edit_phone_error').text('');
            }

            if (check === 1) {
                $.ajax({
                    type: 'POST', // Use the appropriate HTTP method (POST or PUT) here
                    url: "{{ route('update.data') }}",
                    data: editedForm,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.success == true) {
                            $("#myModal").modal('hide');
                            swal('User Updated Successfully !');
                            // $("#reload_data").load("{{ route('user.reload') }}");

                            $(".render").load("{{ route('edit_user.reload') }}");
                            $('#editForm')[0].reset();
                            // location.reload();

                        } else {
                            alert('Error');
                            $("#reload_data").load("{{ route('user.reload') }}");
                            $('#editForm')[0].reset();

                        }
                    },
                });
            } else {
                alert('Validation error');
            }
        });

        // You can repeat the above code for other forms if needed.
    // });


    // end

    // Add & Remove experience clone dynamic div in insert user
    $(document).on('click', '.add_exp', function() {
        // $('.dynamic_div').load("{{ route('exp.load') }}");

        $.ajax({
            url: "{{ route('exp.load') }}",
            type: 'GET',
            success: function(data) {
                $('.dynamic_div').append(data);
            },
            error: function(xhr) {
                alert('something went wrong');
            }
        });
    })

    $(document).on('click', '.remove_exp', function() {
        $(this).closest('.clone').remove();
    });

    // end

    // Add & Remove experience clone dynamic div in edit user

    $(document).on('click', '.edit_exp', function() {
        // $('.dynamic_div').load("{{ route('exp.load') }}");

        $.ajax({
            url: "{{ route('edit_exp.load') }}",
            type: 'GET',
            success: function(data) {
                $('.edit_dynamic_div').append(data);
            },
            error: function(xhr) {
                alert('something went wrong');
            }
        });
    })

    $(document).on('click', '.edit_remove_exp', function() {
        $(this).closest('.clone').remove();
    });
    // end

    // delete user JS
    $(document).on('click', '.delete_record', function() {
        var data_url = $(this).attr("data-url");
        event.preventDefault();
        swal({
                title: `Are you sure you want to delete this record?`,
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {

                    $.ajax({
                        url: data_url,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.success) {
                                swal("Record has been Deleted Successfully !");
                                $("#reload_data").load("{{ route('user.reload') }}");
                            } else {
                                swal("Error,Please Try Again");
                            }
                        }
                    });
                }
            });
    });
    // end

    $('#myModal').on('shown.bs.modal', function() {
        $('#myInput').trigger('focus')
    })
</script>
{{-- edit User JS --}}
<script>
    $(document).on('click', '.edit_user', function() {
        var id = $(this).attr("data-id");
        $('.edit_id').val(id);
        var name = $(this).attr("data-name");
        $('.edit_name').val(name);
        var phone = $(this).attr("data-phone");
        $('.edit_phone').val(phone);
        var picture = $(this).attr("data-picture");
        $('.edit_dynamic_image').attr("src", "{{ asset('storage/images/') }}" + picture);

        var hobby_datas = $(this).data("hobby");
        if (typeof hobby_datas === 'string' && hobby_datas.includes(',')) {
            var hobby_id = hobby_datas.split(',');
        } else {
            var hobby_id = hobby_datas + ',';
        }
        $('.form-check-input').each(function() {
            var checkboxValue = $(this).val();
            if (hobby_id.includes(checkboxValue)) {
                $(this).prop('checked', true);
            } else {
                $(this).prop('checked', false);
            }
        });

        var experience = $(this).attr("data-experience");
        var experienceArray = experience.split(',');

        for (var i = 0; i < experienceArray.length; i++) {
            let temp_name = experienceArray[i];
            $.ajax({
                url: "{{ route('edit_exp.load') }}",
                type: 'GET',
                success: function(data) {
                    var newElement = `<div class="clone mt-2">
                <input type="text" name="experience[]" class="form-control experience" value="${temp_name}" placeholder="Add Experience">
                <a class="btn btn-danger rounded-circle ml-2 mt-1 remove_exp">-</a>
            </div>`;
                    $('.edit_dynamic_div').append(newElement);
                },
                error: function(xhr) {
                    alert('something went wrong');
                }
            });

        }
        var message = $(this).attr("data-message");
        $('.edit_message').val(message);
        var gender = $(this).attr("data-gender");
        if (gender === "male") {
            $("input[value='male']").prop("checked", true);
        } else if (gender === "female") {
            $("input[value='female']").prop("checked", true);
        }

        var edu = $(this).attr("data-edu");
        $(".edit_education").val(edu);

        var company_data = $(this).attr("data-company");
        $(".edit_company").val(company_data);
    });
</script>
{{-- search system JS --}}
<script>
    $(document).on('input', '.search_data', function() {

        var data = $(this).val();
        var url = $(this).attr("data-url");
        $.ajax({
            url: url,
            type: "GET",
            data: {
                _token: "{{ csrf_token() }}", // Corrected csrf_token() function
                data: data,
            },
            success: function(response) {
                if (response.success) {
                    $("#reload_data").html(response.data);
                } else {}
            }
        })
    })
</script>
