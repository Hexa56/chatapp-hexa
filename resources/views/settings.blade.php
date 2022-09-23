<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="ChatApp">
<title>ChatApp | Settings</title>
<link rel="icon" type="image/x-icon" href="/assets/img/chat.ico">
<link rel="stylesheet" href="/assets/fonts/material-design-iconic-font.min.css">
<link rel="stylesheet" href="/assets/vendor/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="/assets/css/style.min.css">
<link rel="stylesheet" href="/tingle/tingle/tingle.css" media="all">
<link rel="stylesheet" href="/tingle/demo.css" media="all">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
<style>
     .avatar.sm {
    height: 60px !important;
    width: 60px !important;
    object-fit:cover;
  }
</style>
<body class="admin">
@include('sweetalert::alert')

    <div id="layout" class="theme-cyan">
        <div class="navigation navbar justify-content-center py-xl-4 py-md-3 py-0 px-3">
      <a href="/settings" class="brand">
          <img src="/storage/images/{{ $user->image }}" title="Profile" class="avatar sm rounded-circle" style="border: var(--primary-color) 2px solid;" alt="user avatar" />
      </a>
      <div class="nav flex-md-column nav-pills flex-grow-1" role="tablist" aria-orientation="vertical">
        <a class="mt-xl-3 mt-md-2 nav-link"  title="Chats" href="/home">
            <i class="ti-comments"></i>
        </a>
        <a class="mt-xl-3 mt-md-2 nav-link" title="Phonebook"  href="/home" role="tab">
            <i class="ti-agenda"></i>
        </a>
        <!--<a class="mt-xl-3 mt-md-2 nav-link" data-toggle="pill" href="#nav-tab-contact" role="tab"><i class="fas fa-address-book"></i></a>-->
        <!--<a class="mt-xl-3 mt-md-2 nav-link" href="/settings"><i class="fas fa-cog"></i></a>-->
        <!--<a class="mt-xl-3 mt-md-2 nav-link" href="http://chat.thesiliconreview.org/logout"-->
        <!--  onclick="return confirm('Are you sure to logout?');"><i class="fas fa-sign-out-alt"></i></a>-->
        <!--<a class="mt-xl-3 mt-md-2 nav-link light-dark-toggle" href="javascript:void(0);">-->
        <!--  <i class="zmdi zmdi-brightness-2"></i>-->
        <!--  <input class="light-dark-btn" type="checkbox">-->
        <!--</a>-->

      </div>
      <button type="submit" class="btn sidebar-toggle-btn shadow-sm"><i class="zmdi zmdi-menu" style="font-size:1.5rem"></i></button>
    </div>

        <div class="sidebar border-end py-xl-4 py-3 px-xl-4 px-3 bg-primary">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="nav-tab-user" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0 text-white text-uppercase">Profile</h4>
                    <div>
                <a href="{{ route('logout') }}" onclick="logoutConfirm()" class="btn btn-dark">Sign Out</a>
            </div>
        </div>
        <div class="card border-0 text-center pt-3 mb-4">
            <div class="card-body">
                <div class="card-user-avatar image-upload">
                    <img src="/storage/images/{{ $user->image }}" alt="avatar" style="width:160px; height:160px;  border-radius:5rem; right:1rem; object-fit:cover;" />
                    <button class="btn btn-primary btn-sm btn-demo js-tingle-modal-1"><i class="ti-pencil-alt"></i></button>
                </div>            
                <div class="card-user-detail mt-4 mb-4">
                <h5>{{ $user->fname }}</h5>
                <h6 class="fs-6">{{ $user->designation }}</h6>
                <span class="text-muted"><a href="" class="__cf_email__">{{ $user->email }}</a></span>
                <!-- <div class="social">
                    <a class="icon p-2" href="#" data-toggle="tooltip" title="Facebook"><i class="fab fa-facebook"></i></a>
                    <a class="icon p-2" href="#" data-toggle="tooltip" title="Youtube"><i class="fab fa-youtube"></i></a>
                    <a class="icon p-2" href="#" data-toggle="tooltip" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a class="icon p-2" href="#" data-toggle="tooltip" title="Instagram"><i class="fab fa-instagram"></i></a>
                </div> -->
            </div>
            <div id="modal" class="tingle-demo tingle-demo-tiny">
                <center><form action="{{route('upload')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" type="file" multiple class="choose mt-5" name="image" id="demo-file"  onchange="previewImage(this,[256],4);">
                    <button type="submit" value="upload" class="btn btn-success">
                    <i class="fa fa-upload" aria-hidden="true"></i> Upload</button>
                    <div class="imagePreview mt-5"></div>
                </form></center>
            </div>
            
        </div>
    </div>
    
    <div class="card border-0">
        <ul class="list-group custom list-group-flush">
            <!--<li class="list-group-item d-flex justify-content-between align-items-center">-->
            <!--    <span class="fw-bold">Color Scheme</span>-->
            <!--        <ul class="choose-skin list-unstyled mb-0">-->
            <!--            <li data-theme="indigo" data-bs-toggle="tooltip" title="Theme-Indigo"><div class="indigo"></div></li>-->
            <!--            <li class="active" data-theme="cyan" data-bs-toggle="tooltip" title="Theme-Darkred"><div class="cyan"></div></li>-->
            <!--            <li data-theme="green" data-bs-toggle="tooltip" title="Theme-Green"><div class="green"></div></li>-->
            <!--            <li data-theme="blush" data-bs-toggle="tooltip" title="Theme-Blush"><div class="blush"></div></li>-->
            <!--            <li data-theme="dark" data-bs-toggle="tooltip" title="Theme-Dark"><div class="dark"></div></li>-->
            <!--        </ul>-->
            <!--        </li>-->
            <!-- <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>Facebook notifications</span>
                <label class="c_checkbox">
                    <input type="checkbox" checked="">
                    <span class="checkmark"></span>
                </label>
            </li> -->
        </div>
    </div>
</div>
<div style="position:absolute; bottom:0;">
    <p class="text-white">© 2022 ChatApp | <a class="text-white" href="https://thesiliconreview.com/">The Silicon Review</a></p>
</div>
</div>


<div class="main px-xl-5 px-lg-4 px-3">
    <div class="main-body">
        <div class="body-header border-bottom py-xl-3 py-2">
            <div class="container px-0">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="media">
                            <div class="avatar sm">
                                <a href="/home" title="" class="link"><i class="ti-arrow-left"></i></a>
                            </div>
                            <div class="media-body overflow-hidden">
                                <div class="d-flex align-items-center mb-1">
                                    <h6 class="fw-bold text-truncate mb-0 me-auto">Settings</h6>
                                </div>
                                <div class="text-truncate">Last Updated :<span class=""> {{ \Carbon\Carbon::parse($user->updated_at)->format('d-m-Y | h:i:s A')}}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="body-page d-flex py-xl-3 py-2">
            <div class="container px-0">
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs nav-overflow page-header-tabs mb-4 mt-md-5 mt-3" id="myTab">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#settinggeneral" role="tab">General</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#settingsecurity" role="tab">Security</a></li>
                        </ul>
                    </div>
                </div>
            @if($errors->any())
    <div class="alert alert-danger">
        <p><strong>Opps Something went wrong</strong></p>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">{{session('success')}}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{session('error')}}</div>
@endif
            <div class="tab-content">
                <div class="tab-pane fade show active" id="settinggeneral" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">Account Settings</h6>
                                    <span class="text-muted small">Update your account details</span>
                                </div>
                                <div class="card-body">
                                    <form class="row g-3" method="post" action="{{ route('update') }}">
                                        @csrf
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group mb-3">
                                                <label>User Name:</label>
                                                <input type="text" title="Username" name="name" class="form-control form-control-lg" value="{{ $user->fname }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group mb-3">
                                                <label>Designation:</label>
                                                <input type="text" name="designation" title="Designation" placeholder="Enter Designation" class="form-control form-control-lg" value="{{ $user->designation }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group mb-3">
                                                <label>Profile Bio:</label>
                                                <textarea type="text" rows="5" name="bio" title="Bio"  class="form-control form-control-lg h-auto" placeholder="Hey,' I'm Using ChatApp"> {{ $user->bio }} </textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-group mb-3">
                                                 <label>Email:</label>
                                                    <input type="email" title="Email" name="email" class="form-control form-control-lg" value="{{ $user->email }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                            <button type="button" class="btn btn-warning">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="settingsecurity" role="tabpanel">
                    <div class="row justify-content-between mb-4">
                        <div class="col-12">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Change Password</h6>
                                <span class="text-muted small">Change your account Password</span>
                            </div>
                        </div>
                    <!--<div class="col-auto">-->
                    <!--    <button class="btn btn-warning">Forgot your password?</button>-->
                    <!--</div>-->
                </div> 
                <div class="row g-3">
                    <div class="col-12">
                        <div class="card mb-4">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>

<script src="/popup/html5.image.preview.min.js"></script>
<script src="/tingle/tingle/tingle.js"></script>
<script type="text/javascript">

    var modalTinyNoFooter = new tingle.modal({
        onClose: function () {
            console.log('close');
        },
        onOpen: function () {
            console.log('open');
        },
        beforeOpen: function () {
            console.log('before open');
        },
        beforeClose: function () {
            console.log('before close');
            return true;
        },
        cssClass: ['class1', 'class2']
    });
    var btn = document.querySelector('.js-tingle-modal-1');
    btn.addEventListener('click', function () {
        modalTinyNoFooter.open();
    });
    modalTinyNoFooter.setContent(document.querySelector('.tingle-demo-tiny').innerHTML);

</script>
<script src="/assets/vendor/jquery/jquery-3.5.1.min.js"></script>
<script src="/assets/vendor/bootstrap.bundle.min.js"></script>
<script src="/assets/vendor/bootstrap-datepicker.min.js"></script>
<script src="/assets/js/template.js"></script>
<script>
$(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#myTab a[href="' + activeTab + '"]').tab('show');
    }
});
function logoutConfirm(){
    if(confirm('Are you sure to logout?'))
    {
        localStorage.removeItem("token");
        return true;
    }
    else
    return false;
}
</script>
</body>

</html>
