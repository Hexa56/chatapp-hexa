<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="chat demo">
    <link rel="stylesheet" href="/assets/fonts/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="/assets/css/style.min.css">
    <link rel="icon" type="image/x-icon" href="/assets/img/chat.png">
    <title>Reset Password</title>
</head>

<body>
    <div id="layout" class="theme-cyan">
        <div class="authentication">
            <div class="container d-flex flex-column">
                <div class="row align-items-center justify-content-center no-gutters min-vh-100">
                    <div class="col-12 col-md-7 col-lg-5 col-xl-4 py-md-11">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h3 class="text-center">Password Reset</h3>
                                <form class="mb-4 mt-5" action="/resetpassword" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$id}}" id="">
                                    <div class="input-group mb-2">
                                        <input type="password" class="form-control form-control-lg" name="password"
                                            placeholder="Enter your password">
                                    </div>
                                    <div class="input-group mb-2">
                                        <input type="password" class="form-control form-control-lg" name="cpassword"
                                            placeholder="Re-Enter your password">
                                    </div>
                                    <div class="text-center mt-5">
                                        <button class="btn btn-lg btn-primary" title="">reset Password</button>
                                    </div>
                                </form>
                                <p class="text-center mb-0">Already have an account? <a class="link" href="/">Sign
                                        in</a>.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="signin-img d-none d-lg-block text-center">
                        <img src="assets/img/auth-img.svg" alt="Sign In Image" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/assets/vendor/jquery/jquery-3.5.1.min.js"></script>
    <script src="/assets/vendor/bootstrap.bundle.min.js" type="4e0bc989cbeb948c413aa73d-text/javascript"></script>
</body>

</html>