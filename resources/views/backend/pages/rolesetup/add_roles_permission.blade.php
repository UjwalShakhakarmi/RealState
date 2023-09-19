@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<style type="text/css">
    .form-check-label{
        text-transform: capitalize;
    }
</style>
<div class="page-content">


    <div class="row profile-body">

        <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Add Roles in Permission</h6>

                        <form id="myForm" class="forms-sample" method="post" action="{{ route('role.permission.store') }}">
                            @csrf
                            <div class="mb-3 form-group">
                                <label for="exampleInputUsername1" class="form-label">Roles Name</label>
                                <select type="text" class="form-control" name="role_id">
                                    <option selected="" disabled="">Select Role</option>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" id="checkDefaultMain">
                                <label for="checkDefault" class="form-check-label">
                                    Permission All
                                </label>
                            </div>
                            <hr>
                            @foreach($permission_groups as $group)
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="checkDefault">
                                        <label for="checkDefault" class="form-check-label">
                                            {{ $group->group_name }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-9">
                                    @php
                                    $permissions = App\Models\User::getPermissionByGroupName($group->group_name)
                                    @endphp
                                    @foreach($permissions as $permission)
                                    <div class="form-check mb-2">
                                        <!-- we have to send multiple option so used permission[] -->
                                        <input type="checkbox" class="form-check-input" name="permission[]" id="checkDefault{{ $permission->id }}"
                                        value="{{ $permission->id }}">
                                        <label for="checkDefault {{ $permission->id }}" class="form-check-label">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                    <br>
                                </div>
                            </div>
                            <!-- //End Row -->
                            @endforeach


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
    $('#checkDefaultMain').click(function(){
        if($(this).is(':checked'))
        {
            $('input[type = checkbox]').prop('checked',true);
        }else{
            $('input[type = checkbox]').prop('checked',false);
        }
    })
</script>

@endsection