@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<div class="page-content">


    <div class="row profile-body">
        <!-- left wrapper start -->
        <div class="d-none d-md-block col-md-4 col-xl-4 left-wrapper">
            <div class="card rounded">
                <div class="card-body">
                    <div>
                        <img class="wd-100 rounded-circle" src="{{ (!empty($ProfileData->photo)) ?
                        url('upload/admin_images/'.$ProfileData->photo) : url('upload/no_image.jpg')}}" alt="profile">
                        <span class="h4 ms-3 text-white">{{ $ProfileData->username }}</span>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Name:</label>
                        <p class="text-muted">{{ $ProfileData->name }}</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Email:</label>
                        <p class="text-muted">{{ $ProfileData->email }}</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Phone:</label>
                        <p class="text-muted">{{ $ProfileData->phone }}</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Address:</label>
                        <p class="text-muted">{{ $ProfileData->address }}</p>
                    </div>
                    <div class="mt-3 d-flex social-links">
                        <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                            <i data-feather="github"></i>
                        </a>
                        <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                            <i data-feather="twitter"></i>
                        </a>
                        <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                            <i data-feather="instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- left wrapper end -->
        <!-- middle wrapper start -->
        <div class="col-md-8 col-xl-8 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Change Password</h6>

                        <form class="forms-sample" method="post" action="{{ route('admin.update.password') }}" >
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputUsername1" class="form-label">Old Password</label>
                                <input type="password" class="form-control @error('Old_password') is-invalid @enderror " id="Old_password" autocomplete="off"
                                     name="Old_password">
                                @error('Old_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="exampleInputUsername1" class="form-label">New Password</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror " id="new_password" autocomplete="off"
                                     name="new_password">
                                @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="exampleInputUsername1" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="new_password_confirmation" autocomplete="off"
                                     name="new_password_confirmation">
                                @error('new_password_confirmation')
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