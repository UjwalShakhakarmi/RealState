@extends('admin.admin_dashboard')
@section('admin')


<div class="page-content">


    <div class="row profile-body">

        <div class="col-md-8 col-xl-8 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Edit Permission</h6>

                        <form id="myForm" class="forms-sample" method="post" action="{{ route('Update.Permission') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $permission->id }}">
                            <div class="mb-3 form-group">
                                <label for="exampleInputUsername1" class="form-label">Permission </label>
                                <input type="text" class="form-control"  name="name" value="{{ $permission->name }}" />
                            </div>
                            <div class="mb-3 form-group">
                                <label for="exampleInputUsername1" class="form-label">Group Name: </label>
                                <select type="text" class="form-control"  name="group_name" >
                                    <option selected="" disabled= "">Select Group</option>
                                    <option value="type" {{ $permission->group_name == 'type' ? 'selected' : ''}}>Property Type</option>
                                    <option value="state" {{ $permission->group_name == 'state' ? 'selected' : ''}}>State</option>
                                    <option value="amenities" {{ $permission->group_name == 'amenities' ? 'selected' : ''}}>Amenities</option>
                                    <option value="history" {{ $permission->group_name == 'history' ? 'selected' : ''}}>Package History</option>
                                    <option value="agent" {{ $permission->group_name == 'agent' ? 'selected' : ''}}>Manage Agent</option>
                                    <option value="role" {{ $permission->group_name == 'role' ? 'selected' : ''}}>Role & Permission</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary me-2">Save Changes </button>
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