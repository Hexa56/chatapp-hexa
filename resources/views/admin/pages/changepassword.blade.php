@extends('admin.layout.master')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0">Change Password</h1>
    </div>
    
    <div class="card-body">
                                <form class="row" method="POST" action="{{ route('change.password') }}">
                                    @csrf
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Current password</label>
                                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" autocomplete="current_password">
                                                @error('current_password')
                                                    <span class="invalid-feedback" role="alert" style="color:red;">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>New password</label>
                                            <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password" autocomplete="password">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert" style="color:red;">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Confirm password</label>
                                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"  name="password_confirmation" autocomplete="password_confirmation">
                                                @error('password_confirmation')
                                                    <span class="invalid-feedback" role="alert" style="color:red;">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update Password</button>
                                        <button type="button" class="btn btn-warning">Cancel</button>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="card bg-light border">
                                            <div class="card-body">
                                                <p class="mb-2">Password requirements</p>
                                                <p class="small text-muted mb-2">To create a new password, you have to meet all of the following requirements:</p>
                                                <ul class="small text-muted ps-4 mb-0">
                                                    <li>Minimum 8 character</li>
                                                    <li>At least one special character</li>
                                                    <li>At least one number</li>
                                                    <li>Can’t be the same as a previous password</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


@endsection