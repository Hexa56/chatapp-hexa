<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="/assets/img/chat.ico">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ChatApp | Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="/admin/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="/admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://js.pusher.com/7.1/pusher.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
  integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .fs-7
    {
        font-size: 12px;
    }
    .items-center .col-lg-2
    {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
</style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        @include('sweetalert::alert')
        @include('admin/includes/sidebar')
        @include('admin/includes/topbar')
        @yield('content')
        @include('admin/includes/footer')


        

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal-->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                        <div class="card o-hidden border-0 shadow-lg">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                                    <div class="col-lg-7">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                                @if (session('status'))
                                                     <h6 class="alert alert-success font-weight-bold">{{ session('status') }}</h6>
                                                @endif
                                            </div>
                                            <form class="user" action="{{ route('register.post') }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <input name="name" type="name" class="form-control form-control-user" id="name"
                                                        placeholder="Enter your Username">
                                                    @if ($errors->has('name'))
                                                        <div class="text-center py-2">
                                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <input  name="email" type="email" class="form-control form-control-user" id="email"
                                                    placeholder="Enter your Email">
                                                    @if ($errors->has('email'))
                                                    <div class="text-center py-2">
                                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <input  name="password" type="password" class="form-control form-control-user" id="password"
                                                    placeholder="Enter your Password">
                                                    @if ($errors->has('password'))
                                                    <div class="text-center py-2">
                                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <button type="submit"  class="btn btn-primary btn-user btn-block">
                                                    Register Account
                                                </button>
                                            </form>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="/admin/vendor/jquery/jquery.min.js"></script>
    <script src="/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="/admin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="/admin/js/sb-admin-2.min.js"></script>
    <!-- Page level plugins -->
    <script src="/admin/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="/admin/js/demo/datatables-demo.js"></script>
    <script src="/admin/js/status.js"></script>
</body>

</html>