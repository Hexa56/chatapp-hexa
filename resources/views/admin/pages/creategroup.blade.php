@php
use App\Models\message;
use App\Models\grouppeople;
use App\Models\groups;
use App\Models\groupchat;
@endphp

@extends('admin.layout.master')
@section('content')


<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0">Create Group</h1>
    </div>
    
    <div class="card-body">
                        <div class="row">
                                    <div class="col-lg-3 col-md-12">
                                    <form method="POST" action="{{ route('admin.groupchat') }}" enctype="multipart/form-data">
                                            @csrf
                                        <div class="form-group mb-3">
                                            <label>Group Name</label>
                                            <input type="text" name="groupname" class="form-control" placeholder="Enter Group Name">
                                            <label>Group Profie</label>
                                            <input type="file" name="groupimage" class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Create Group</button>
                                    </form>
                                    </div>
                                    
                                    <div class="col-lg-9 col-md-12">
                                        <div class="card bg-light border">
                                            <div class="card-body">
                                                <p class="mb-2 text-lg text-primary font-weight-bold">Created Groups</p>

                                                    <div  class="d-flex flex-column  flex-wrap items-center">
                                                    @foreach( $groupusers as $item )
                                                    <div class="row my-2">
                                                        <div class="col-lg-2">
                                                            <img width="50" height="50" src="/storage/images/{{ $item->image }}" >
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <span class="font-weight-bold text-dark"><a href="/admin/groupchat/{{ $item->id }}">{{ $item->name }}</a></span>
                                                        </div>
                                                        <div class="col-lg-2 p-1">
                                                            <a href="javascript:void(0);" class="btn btn-secondary btn-icon-split" data-toggle="modal" data-target="#showGroupMembers{{$item->id}}">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-eye"></i>
                                                                </span>
                                                                <span class="text fs-7">Show Members</span>
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-2 p-1">
                                                            <a href="javascript:void(0);" class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#addGroupMembers{{$item->id}}">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-plus"></i>
                                                                </span>
                                                                <span class="text fs-7">Add Members</span>
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-2 p-1">
                                                            <a href="javascript:void(0);" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#deleteGroupMembers{{$item->id}}">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-users"></i>
                                                                </span>
                                                                <span class="text fs-7">Delete members</span>
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-2 p-1 ">
                                                            <a href="javascript:void(0);" class="btn btn-danger btn-icon-split" data-toggle="modal" data-target="#deleteGroup{{$item->id}}">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-trash"></i>
                                                                </span>
                                                                <span class="text fs-7">Delete Group</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <!-- Show Members-->
                                                    <div class="modal fade" id="showGroupMembers{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title text-dark" id="exampleModalLabel">Members of <span class="text-primary font-weight-bold h5">{{ $item->name }} ?</span></h5>
                                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <form method="post" action="{{ route('admin.groupmembersdelete') }}">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                      @php 
                                                                       $grouppeople = grouppeople::select('grouppeoples.*','users.*','grouppeoples.role as grole')->join('users', 'grouppeoples.user_id','=','users.id')->where('group_id','=', $item->id)->get();
                                                                      @endphp
                                                                      
                                                                        <div class="container">
                                                                            <div class="row">
                                                                                @foreach( $grouppeople as $gp )
                                                                                    <div class="col-md-4 py-2 text-primary font-weight-bold h4">{{ $gp->name }}</div>
                                                                                    <div class="col-md-4 py-2">{{ $gp->designation }}</div>
                                                                                    
                                                                                    <div class="col-md-4 py-2 d-flex justify-content-center align-items-center">
                                                                                          <form action='/group/make-admin' method='post'>
                                                                                              @csrf
                                                                                              <input type='hidden' name='gid' value='{{$gp->group_id}}'>
                                                                                              <input type='hidden' name='uid' value='{{$gp->user_id}}'>
                                                                                              <button onclick='return confirm("Are you sure ?")'class='border border-0 bg-transparent'><i title='@if($gp->grole == 'admin') Make Member @else Make Admin @endif' class="@if($gp->grole == 'admin') fa-user-gear @else fa-user @endif text-secondary fa-solid"></i></button>
                                                                                          </form>
                                                                                    </div>
                                                                                @endforeach    
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Delete Members-->
                                                    <div class="modal fade" id="deleteGroupMembers{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title text-dark" id="exampleModalLabel">Delete Members From <span class="text-primary font-weight-bold h5">{{ $item->name }} ?</span></h5>
                                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <form method="post" action="{{ route('admin.groupmembersdelete') }}">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                      @php 
                                                                       $grouppeople = grouppeople::join('users', 'grouppeoples.user_id','=','users.id')->where('group_id','=', $item->id)->get();
                                                                      @endphp
                                                                      
                                                                        <div class="container">
                                                                            <div class="row">
                                                                                @foreach( $grouppeople as $gp )
                                                                                    <div class="col-md-6 py-2 text-primary font-weight-bold h4">{{ $gp->name }}</div>
                                                                                    <div class="col-md-6 py-2"><a href="javascript:void(0);" onclick="gpdel('{{$gp->name }}')" class="btn btn-danger">Delete</a></div>
                                                                                    <form id="{{ str_replace(' ','',$gp->name) }}" method="post" action="/admin/groupmembersdelete">
                                                                                        @csrf
                                                                                        <input type="hidden" name="group_id" value="{{ $gp->group_id }}">
                                                                                        <input type="hidden" name="user_id" value="{{ $gp->user_id }}">
                                                                                    </form>
                                                                                @endforeach    
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Delete Modal-->
                                                    <div class="modal fade" id="deleteGroup{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title text-dark" id="exampleModalLabel">Delete Group <span class="text-primary font-weight-bold h5">{{ $item->name }} ?</span></h5>
                                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-footer">
                                                                <form method="post" action="{{ route('admin.deletegroup') }}">
                                                                    @csrf
                                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                                                </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="addGroupMembers{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Add Members to <span class="text-primary font-weight-bold">{{ $item->name }}</span></h5>
                                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <form method="post" action="{{ route('admin.groupinsert') }}">
                                                                    @csrf
                                                                <div class="modal-body">
                                                                        @foreach($users as $user)
                                                                            @if( $user->role != 'admin' )
                                                                                <div class="d-flex">
                                                                                    <input type="checkbox" class="mr-3" name="{{ $user->id }}">
                                                                                    <div class="h5">{{ $user->name }}</div>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                        <input type="hidden" name="group_id" value="{{ $item->id }}" >
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                                    <button type="submit"  class="btn btn-primary">Add</button>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                               
                            </div>
                        </div>

<script>
   function gpdel(g_name){
       if(confirm('Are you sure want to remove '+g_name+' from {{ $item->name }}'))
       {
           $('#'+g_name.replace(' ','')).submit()
          
       }
       else{
           false
       }
   }
</script>
@endsection