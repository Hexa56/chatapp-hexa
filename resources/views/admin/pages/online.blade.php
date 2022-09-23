@extends('admin.layout.master')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid h-100">
        <div class="row h-75">
            <div class="col-lg-6">
                <div class="card shadow mb-4 border-left-success h-100 py-2 overflow-auto">
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h4 class="m-0 font-weight-bold text-primary">Online Users</h4>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            @foreach ($onlineUsers as $online)
                            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                <h5 class="mb-0 text-gray-800 font-weight-bold">
                                    <span class="mr-2">
                                        <i class="fas fa-circle text-success"></i>
                                    </span>
                                    {{ $online->name }}
                                </h5>
                                <h6 class="d-none d-sm-inline-block"> {{ $online->designation }}</h6>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="card shadow mb-4 border-left-danger h-100 py-2 overflow-auto">
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h4 class="m-0 font-weight-bold text-primary">Offline Users</h4>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            @foreach ($offlineUsers as $offline)
                            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                <h5 class="mb-0 text-gray-800 font-weight-bold">
                                    <span class="mr-2">
                                        <i class="fas fa-circle text-danger"></i>
                                    </span>
                                    {{ $offline->name }}
                                </h5>
                                <h6 class="d-none d-sm-inline-block"> {{ $offline->designation }}</h6>
                            </div>
                            @endforeach  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    <script>
        var pusher = new Pusher('86f5883d857f571e3cf0', {
          cluster: 'ap2'
        });
        var channel = pusher.subscribe('status');
        channel.bind('check', function(data) {
            location.reload();
        });
    </script>
@endsection