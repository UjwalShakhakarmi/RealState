@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<div class="page-content">


    <div class="row profile-body">

        <div class="col-md-8 col-xl-8 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Update Amenities</h6>

                        <form id="myForm" class="forms-sample" method="post" action="{{ route('update.amenities') }}">
                            @csrf
                            <input type="hidden" value="{{ $amenities->id }}" name="id" >
                            <div class="mb-3 form-group">
                                <label for="exampleInputUsername1" class="form-label">Amenitie Name</label>
                                <input type="text" class="form-control"  name="amenities_name" value="{{  $amenities->amenities_name }}">

                            </div>

                            <button type="submit" class="btn btn-primary me-2">Update </button>
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
                amenities_name: {
                    required: true,
                },
            },
            messages: {
                amenities_name: {
                    required : 'Please Enter Amenitie Name',
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