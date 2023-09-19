@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<div class="page-content">


    <div class="row profile-body">
      
        <div class="col-md-8 col-xl-8 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Edit Type</h6>

                        <form class="forms-sample" method="post" action="{{ route('update.type') }}" >
                            @csrf
                            <input type="hidden" name="id" value="{{ $types->id }}">
                            <div class="mb-3">
                                <label for="exampleInputUsername1" class="form-label">Type Name</label>
                                <input type="text" class="form-control @error('type_name') is-invalid @enderror " 
                                    id="type_name" name="type_name" value="{{ $types->type_name }}">
                                @error('type_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputUsername1" class="form-label">Type Icon</label>
                                <input type="text" class="form-control @error('type_icon') is-invalid @enderror " 
                                     name="type_icon" value="{{ $types->type_icon }}">
                                @error('type_icon')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary me-2">Save Changes</button>
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
    $(document).ready(function()
    {
        $('#image').change(function(e)
        {
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });

</script>


@endsection