@php 
use App\Models\message;
@endphp
@extends('admin.layout.master')

@section('content')
    <!-- Begin Page Content -->
 <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="" class="d-none d-sm-inline-block btn btn-primary shadow-sm"  data-toggle="modal" data-target="#registerModal"><i
                class="fa fa-plus fa-sm text-white-50"></i>&nbsp; Create Users</a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">
                               Total Users</div>
                            <div class="h2 mb-0 font-weight-bold text-gray-800">{{ $userCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm font-weight-bold text-success text-uppercase mb-1">
                               online Users</div>
                            <div class="h2 mb-0 font-weight-bold text-gray-800 online"></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-signal fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm font-weight-bold text-danger text-uppercase mb-1">
                               offline Users</div>
                            <div class="h2 mb-0 font-weight-bold text-gray-800 offline"></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-signal fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary">Users Table</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Email</th>
                                <th>Designation</th>
                                <th>Last Login</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index=>$item)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td class="h5 font-weight-bold">

                                    <span class="mr-2">
                                        <i id="{{$item->id}}" class="fas fa-circle @if($item->status == 1) text-success @else text-danger @endif"></i>
                                    </span>
                                    {{ $item->name }}
                                </td>
                                <td><img src="/storage/images/{{ $item->image }}" class="mx-auto d-flex" style="object-fit: cover;" width="100" height="100" alt=""></td>
                                <td><a href="mailto:{{ $item->email}}">{{ $item->email}}</a></td>
                                <td class="font-weight-bold text-danger">{{ $item->designation}}</td>
                                <td class="font-weight-bold text-dark">{{ $item->lastlogin }}</td>
                                <td> 
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#UserShowModal{{ $item->id }}" ><img src="https://img.icons8.com/ios/25/000000/visible--v1.png" class="d-flex mx-auto"/></a>
                                </td>
                            </tr>
                            <div class="modal fade" id="UserShowModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Recent Chats of <span class="font-weight-bold text-primary">{{ $item->name }}</span></h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                 @php
                                                 $recentChat = message::distinct()->where('sender','=', $item->name )->orwhere('recevier','=', $item->name)->get('sender');
                                                 @endphp
                                                 @foreach ($recentChat as $recent)
                                                     @if(ucwords($recent->sender) != ucwords($item->name))
                                                        <li class="font-weight-bold h5"><a href="{{ route('admin.chat') }}/{{$recent->sender}}/{{$item->name}}">{{$recent->sender}}</a></li>
                                                     @endif
                                                 @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

                
</div>
<!-- /.container-fluid -->
@endsection