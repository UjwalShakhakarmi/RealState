@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<div class="page-content">


    <div class="row profile-body">

        <div class="col-md-8 col-xl-8 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Edit Admin</h6>

                        <form id="myForm" class="forms-sample" method="post" action="{{ route('update.admin',$user->id) }}">
                            @csrf
                            <div class="mb-3 form-group">
                                <label for="exampleInputUsername1" class="form-label">Admin UserName</label>
                                <input type="text" class="form-control" name="username" value="{{ $user->username }}">
                            </div>
                            <div class="mb-3 form-group">
                                <label for="exampleInputUsername1" class="form-label">Admin name</label>
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                            </div>
                            <div class="mb-3 form-group">
                                <label for="exampleInputUsername1" class="form-label">Admin Email</label>
                                <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                            </div>
                            <div class="mb-3 form-group">
                                <label for="exampleInputUsername1" class="form-label">Admin Phone</label>
                                <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                            </div>
                            <div class="mb-3 form-group">
                                <label for="exampleInputUsername1" class="form-label">Admin Address</label>
                                <input type="text" class="form-control" name="address" value="{{ $user->address }}">
                            </div>
                            <div class="mb-3 form-group">
                                <label for="exampleInputUsername1" class="form-label">Admin Password</label>
                                <input type="password" class="form-control" name="password" value="{{ $user->password }}">
                            </div>
                            <div class="mb-3 form-group">
                                <label for="exampleInputUsername1" class="form-label">Admin Roles</label>
                                <select type="text" class="form-control" name="roles">
                                    <option selected="" disabled="">Select Role</option>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{$user->hasRole($role->name) ? 'selected': ''}} >{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary me-2">Save </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
        <!-- middle wrapper end -->

        <!-- right wrapper end -->
    </div>

</div>


@endsection