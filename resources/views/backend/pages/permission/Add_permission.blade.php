@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<div class="page-content">


    <div class="row profile-body">

        <div class="col-md-8 col-xl-8 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Add Permission</h6>

                        <form id="myForm" class="forms-sample" method="post" action="{{ route('store.Permission') }}">
                            @csrf
                            <div class="mb-3 form-group">
                                <label for="exampleInputUsername1" class="form-label">Permission </label>
                                <input type="text" class="form-control"  name="name">

                            </div>
                            <div class="mb-3 form-group">
                                <label for="exampleInputUsername1" class="form-label">Group Name: </label>
                                <select type="text" class="form-control"  name="group_name">
                                    <option selected="" disabled= "">Select Group</option>
                                    <option value="type">Property Type</option>
                                    <option value="state">State</option>
                                    <option value="amenities">Amenities</option>
                                    <option value="history">Package History</option>
                                    <option value="agent">Manage Agent</option>
                                    <option value="role">Role & Permission</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary me-2">Add </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
        <!-- middle wrapper end -->

        <!-- right wrapper end -->
    </div>

</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#myForm').validate
    ({
            rules: {
                name: {
                    required: true,
                },
                group_name: {
                    required:true,
                }
            },
            messages: {
                name: {
                    required : 'Please Enter Permision Name',
                },
                group_name: {
                    required : 'Please Select the Group',
                },
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
    });
});
</script>


@endsection