@php
use App\Models\message;
use App\Models\grouppeople;
use App\Models\groupchat;
use App\Models\user;
$msg = message::where('status','!=',1)->get();
$grp =
grouppeople::join('groupss','groupss.id','=','grouppeoples.group_id')->where('grouppeoples.user_id','=',request()->session()->get('user_id'))->get();

@endphp

<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<title>ChatApp</title>
<link rel="icon" type="image/x-icon" href="/assets/img/chat.ico">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="/assets/fonts/material-design-iconic-font.min.css">
<link rel="stylesheet" href="/assets/vendor/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="/assets/css/style.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
  integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

@if(Session::has("token"))
<script>
  localStorage.setItem('token','{{Session::get("token")}}')
</script>
@endif
<style>

a.d-grid
{
    color: currentColor!important;
}

.cursor-pointer
{
    cursor: pointer;
}
div#replyhint i.fa-solid.fa-eye {
    display: none;
}
  #previewemoji {
    height: 200px;
    width: 100%;
    overflow: auto;
    -ms-overflow-style: none;
    scrollbar-width: none;
  }
  div#emojiselect {
    border-radius: 3em 3em 0 0;
    margin: auto;
    width: 100%;
    overflow: hidden;
}
div#replyhint img {
    height: 100px;
    width: 100px;
}

  #previewemoji::-webkit-scrollbar {
    display: none;
  }

  .custom-file-upload {
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
  }

  img.img-fluid.img-thumbnail {
    width: 350px;
    max-width: 100%;
    margin: auto;
    height: 350px;
    max-height: 100%;
  }

  .message-content {
    padding: 0.5em !important;
    font-size: 15px !important;
  }

  .result img {
    width: 100px !important;
    height: 80px !important;
  }

  .result {
    background: #e9ecef;
  }

  .result a {
    color: #212529 !important;
  }

  .border-start {
    border-width: thick !important;
    border-color: #41464b1c;
  }

  .avatar.sm {
    height: 60px !important;
    width: 60px !important;
    object-fit: cover;
  }

  .right .bg-gray {
    background: var(--primary-color) !important;
    color: white !important;
  }

  .w-image a {
    color: #ffffffba;
  }

  .w-image {
    width: 360px;
    max-width: 100%;
  }

  .text-gray {
    color: #ffffff94;
  }

  .sidebar {
    background: #36D1DC;
    /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #5B86E5, #36D1DC);
    /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #5B86E5, #36D1DC);
    /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
  }

  .rightbar .nav {
    background: #37CEDC;
  }

  .chat-list .card {
    background-color: rgba(255, 255, 255, 0.08) !important;
    border-radius: 0.5em !important;
    border: none;
    border-bottom: 0.1px solid #8080800f !important;
    cursor: pointer;
  }

  .chat-list .card:hover {
    transform: scale(1.03);
  }

  .message-content img {
    width: 100%;
    height: 200px;
    object-fit: cover;
  }

  .doc {
    display: none;
  }

  .text-truncate img,
  .text-truncate video,
  .text-truncate audio {
    width: 20px;
    height: 20px;
  }

  input.largerCheckbox {
    width: 20px;
    height: 20px;
  }

  .chat-footer {
    border-radius: 3em;
    background: #f3f2ef !important;
    width: 80%;
    margin: auto;
  }

  .h-41 {
    border-radius: 50%;
  }

  .tools {
    display: flex;
    margin-right: 33px;
    align-items: center;
  }

  .input-group .input-group-prepend .input-group-text,
  .input-group .input-group-append .input-group-text {
    padding: 4px 1px;
  }

  .send {
    height: 43px;
    width: 45px;
  }

  .fs-small {
    font-size: revert;
  }

  .message-content .reply {
    color: #ffffffa1;
    padding: 4px;
    background: #0636501c;
    border-bottom: 0px solid;
    border-left: 3px solid white;
    overflow-wrap: anywhere;
  }

  div#replyhint {
    background: darkseagreen;
    border-radius: 2em;
  }

  .message-content {
    cursor: pointer;
  }

  .dropdown {
    opacity: 0;
    transition: opacity 0.5s ease;
  }

  .dropdown:hover {
    opacity: 1;
  }

  a {
    cursor: pointer;
  }

  .big-checkbox {
    width: 20px;
    height: 20px;
  }
  #imageView span{
    color: #c5c5c5;
    font-size: 42px;
    position: absolute;
    padding: 26px 73px;
    right: 0;
  }
</style>
<div id="toast{{Session::get('user')}}" style="z-index: 20" class="position-fixed end-0"></div>

<body>
    
<!-- Button trigger modal -->
<button id='view' class="d-none" data-bs-toggle="modal" data-bs-target="#imageView">
</button>

<!-- Modal -->
<div class="modal fade" id="imageView" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <span data-bs-dismiss="modal"><i class="ti-close"></i></span>
  <div class="modal-dialog modal-xl h-100 w-100 d-flex justify-content-center align-items-center">
      <div class='modal-content'>
          <div class="modal-body">
            <img class="w-100" alt='no image'>
          </div>
      </div>
  </div>
</div>
<button id='viewDocs' class="d-none" data-bs-toggle="modal" data-bs-target="#viewDoc">
</button>
<div class="modal fade" id="viewDoc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    
    <div class="modal-dialog p-5 modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <iframe src="" width="100%" height="100%">
        </iframe>
      </div>
    </div>
  </div>
</div>
  <!-- Modal: modalCart -->
  <div id="forward" class="modal fade" id="modalCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <!--Header-->
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Forward Message to</h4>
          <a class="close" data-dismiss="modal" aria-label="Close">
            <i class="ti-close"></i>
          </a>
        </div>
        <form action="/forward" method="post">
          @csrf
          <!--Body-->
          <input id="msg_id" type="hidden" name="msg_id">
          <div class="modal-body overflow-auto" style="height: 70vh">
            <div class="row">
              <div class="border w-100 my-3 p-2">Employees</div>
              @foreach($users as $da)
              <div class="d-flex justify-content-between">
                <img class="avatar rounded-circle my-2" src="/storage/images/{{ $da->image }}">
                <h5 class="text-capitalize mt-3">{{$da->fname}}</h5>
                <input type="checkbox" class="mt-3 big-checkbox" name="{{$da->name}}">
              </div>
              @endforeach
              <div class="border w-100 my-3 p-2">Groups</div>
              @foreach ($grp as $gda)
              <div class="d-flex justify-content-between">
                <img class="avatar rounded-circle my-2" src="/storage/images/{{ $gda->image }}">
                <h5 class="text-capitalize mt-3">{{$gda->name}}</h5>
                <input type="checkbox" class="mt-3 big-checkbox" name="{{$gda->name}}">
              </div>
              @endforeach
            </div>
          </div>
          <!--Footer-->
          <div class="modal-footer">
            <button class="btn btn-info text-white"><i class="fa-regular fa-paper-plane"></i> Forward</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Modal: modalCart -->

  @include('sweetalert::alert')
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
  <div id="layout" class="theme-cyan">
    <div class="navigation navbar justify-content-center py-xl-4 py-md-3 py-0 px-3">
      <a href="/settings" class="brand">
        <img src="/storage/images/{{ $profile->image }}" title="Profile" class="avatar sm rounded-circle"
          style="border: var(--primary-color) 2px solid;" alt="user avatar" />
      </a>
      <div class="nav flex-md-column nav-pills flex-grow-1" role="tablist" aria-orientation="vertical">
        <a class="mt-xl-3 mt-md-2 nav-link z active" data-toggle="pill" href="#nav-tab-chat" role="tab" title="Chats">
          <i class="ti-comments"></i>
        </a>
        @if(count($usergroups) > 0)
            <a class="mt-xl-3 mt-md-2 nav-link z" data-toggle="pill" href="#nav-tab-usergroups" role="tab" title="Groups">
              <i class="fa-solid fa-users"></i>
            </a>
        @endif
        <a class="mt-xl-3 mt-md-2 nav-link z" data-toggle="pill" href="#nav-tab-contact" role="tab" title="Phonebook">
          <i class="ti-agenda"></i>
        </a>

        <div class='border-top border-4'>
            <a class="mt-xl-3 mt-md-2 nav-link z" data-bs-toggle="modal" data-bs-target="#info" title='Quick Guide'>
            <i class="fa-solid fa-info"></i>
            </a>
            <a class="mt-xl-3 mt-md-2 nav-link z" data-bs-toggle="modal" data-bs-target="#bug" title='Report a bug'>
                <i class="fa-solid fa-bug"></i>
            </a>
        </div>


        <!--<a class="mt-xl-3 mt-md-2 nav-link" href="/settings"><i class="fas fa-cog"></i></a>-->
        <!--<a class="mt-xl-3 mt-md-2 nav-link" href="{{ route('logout') }}"-->
        <!--  onclick="return confirm('Are you sure to logout?');"><i class="fas fa-sign-out-alt"></i></a>-->
        <!--<a class="mt-xl-3 mt-md-2 nav-link light-dark-toggle" href="javascript:void(0);">-->
        <!--  <i class="zmdi zmdi-brightness-2"></i>-->
        <!--  <input class="light-dark-btn" type="checkbox">-->
        <!--</a>-->

      </div>
      <button type="submit" class="btn sidebar-toggle-btn shadow-sm"><i class="zmdi zmdi-menu"
          style="font-size:1.5rem"></i></button>
    </div>
        
<div
      class="modal fade"
      id="info"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Quick Guide</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <ul>
              <li>
                <span class="h5"> Reply</span>
                <ul class='my-3'>
                  <li>Double click on message to reply</li>
                </ul>
              </li>
              <li>
                <span class="h5">Forward, delete and Pin a message</span>
                <ul class='my-3'>
                  <li>Hover left side of message if the message is sent by you or, Hover right side of message, Options will Visible.</li>
                  <li>To view the pinned messages click on the pin <i class="ti-pin-alt"></i> symbol on the right side menu.</li>
                </ul>
              </li>
              
              <li>
                <span class="h5">To Note</span>
                <ul class='my-3'>
                  <li>In right side there will be note <i class="ti-book"></i> symbol click on it.</li>
                  <li>
                    There is a check box named "Personal Note?" if you want to
                    note for yourself click on checkbox otherwise leave as it is.
                  </li>
                  <li>
                    If you have not checked the check box, the note will be visible to other side person too.
                  </li>
                </ul>
              </li>
            </ul>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
<div class="modal fade" id="bug" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Report Bugs</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form action='/report' method='post'>
            @csrf
          <div class="modal-body">
                <input type='hidden' name='user' value='{{$profile->fname}}'>
              <div class="mb-3">
                <label for="message-text" class="col-form-label">Report:</label>
                <textarea required name='bug' rows='5' placeholder='Describe. . . .' class="form-control border border-2" id="message-text"></textarea>
              </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Report</button>
          </div>
        </form>
    </div>
  </div>
</div>
    <div class="sidebar border-end py-xl-4 py-3 px-xl-4 px-3">
      <div class="tab-content">
        <div class="tab-pane fade" id="nav-tab-user" role="tabpanel">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 text-primary text-uppercase">Profile</h4>
            <div>
              <!--<a href="pages/login.html" title="" class="btn btn-dark">Sign Out</a>-->
            </div>
          </div>


          <div class="card border-0">
            <ul class="list-group custom list-group-flush">
              <!--<li class="list-group-item d-flex justify-content-between align-items-center">-->
              <!--  <span class="fw-bold">Color scheme</span>-->
              <!--  <ul class="choose-skin list-unstyled mb-0">-->
              <!--    <li data-theme="indigo" data-toggle="tooltip" title="Theme-Indigo">-->
              <!--      <div class="indigo"></div>-->
              <!--    </li>-->
              <!--    <li class="active" data-theme="cyan" data-toggle="tooltip" title="Theme-Darkred">-->
              <!--      <div class="cyan"></div>-->
              <!--    </li>-->
              <!--    <li data-theme="green" data-toggle="tooltip" title="Theme-Green">-->
              <!--      <div class="green"></div>-->
              <!--    </li>-->
              <!--    <li data-theme="blush" data-toggle="tooltip" title="Theme-Blush">-->
              <!--      <div class="blush"></div>-->
              <!--    </li>-->
              <!--    <li data-theme="dark" data-toggle="tooltip" title="Theme-Dark">-->
              <!--      <div class="dark"></div>-->
              <!--    </li>-->
              <!--  </ul>-->
              <!--</li>-->
              <!-- <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>Facebook notifications</span>
                <label class="c_checkbox">
                    <input type="checkbox" checked="">
                    <span class="checkmark"></span>
                </label>
            </li> -->
          </div>
        </div>

        <div class="tab-pane fade show active" id="nav-tab-chat" role="tabpanel">

          <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 text-light text-uppercase">Chat</h4>
            <div>
              <a class="btn btn-dark" data-toggle="pill" href="#nav-tab-group" role="tab">New Group</a>
            </div>
          </div>


          <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
              <!-- <button class="btn btn-dark" type="button" data-toggle="modal" data-target="#InviteFriends">Invite Friends</button> -->
            </div>
          </div>
          <div class="form-group input-group-lg search mb-3">
            <!--<i class="ti-search position-absolute"></i>-->

            <input style="font-size:14px" id="myInput" onkeyup="myFunction()" type="text"
              class="form-control rounded ps-2" placeholder="Search...">
          </div>

          <ul class="chat-list" id="myUL">
            <li class="header d-flex justify-content-between ps-3 pe-3 mb-1">
              <!--<span class="text-white">RECENT CHATS</span>-->
              <div class="dropdown d-none">
                <a class="btn btn-link px-1 py-0 border-0 text-muted dropdown-toggle" role="button"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                    class="zmdi zmdi-filter-list"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item">Action</a>
                  <a class="dropdown-item">Another action</a>
                  <a class="dropdown-item">Something else here</a>
                </div>
              </div>
            </li>
            @php
            $i = 0; $j=0;
            @endphp
            @foreach ($data as $da)
            @php
            $recent =
            message::where('sender','=',Session::get('user'))->where('recevier','=',$da->name)->where('status','=',0)->orwhere('sender','=',$da->name)->where('recevier','=',Session::get('user'))->where('status','=',0)->latest('id')->get()->first();
            $unseen =
            message::where('sender','=',$da->name)->where('recevier','=',Session::get('user'))->where('status','=',0)->where('seen','=','0')->count();
            @endphp
            @if($recent && $recent->forwarded == 2)
            @php
            $gmsg = groupchat::find($recent->message);
            $recent->message = "<div class='d-flex flex-column'><span
                style='font-size: 11px; text-transform: capitalize;'>forwarded</span>".$gmsg->message."</div>";
            @endphp
            @endif
            @if($recent && $recent->forwarded == 1)
            @php
            $umsg = message::find($recent->message);
            if(!$umsg)
            {
            $umsg = groupchat::find($recent->message);
            }
            $recent->message = "<div class='d-flex flex-column'><span
                style='font-size: 11px; text-transform: capitalize;'>forwarded</span>".$umsg->message."</div>";
            @endphp
            @endif
            @if($da->id != Session::get('user_id') && $recent)
            <li id={{$da->id}} @if($da->status == 1) class="online card li-status" @else class="away card" @endif>

              <div class="hover_action d-none">
                <button type="button" class="btn btn-link text-warning"><i class="fas fa-star"></i></button>
                <button type="button" class="btn btn-link text-danger"><i class="fas fa-trash"></i></button>
              </div>

              <div onclick="select('{{$da->name}}','{{encrypt($da->id)}}')" class="card border-0">

                <div class="card-body">

                  <span id="unseen{{str_replace(' ','',$da->name)}}" data-count='{{$unseen}}'
                    class="@if($unseen == 0) d-none @endif position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">

                    {{$unseen}}

                    <span class="visually-hidden">unread messages</span>
                  </span>

                  <div class="media">
                    <div class="avatar me-3">
                      <span class="status rounded-circle"></span>
                      @if ($da->image)
                      <img class="newavatar rounded-circle" src="/storage/images/{{ $da->image }}" alt="avatar">
                      @else
                      @php
                      $d = explode(" ", $da->fname);
                      @endphp
                      <div class="avatar me-3">
                        <span class="status rounded-circle"></span>
                        <div class="avatar rounded-circle no-image cyan">
                          <span class="text-uppercase">
                            @foreach ($d as $icon)
                            {{$icon[0]." "}}
                            @endforeach
                          </span>
                        </div>
                      </div>
                      @endif
                    </div>
                    <div class="media-body overflow-hidden">
                      <div class="d-flex align-items-center mb-1">
                        <h6 class="@if($unseen != 0) fw-bold @endif text-truncate mb-0 me-auto text-white">
                          {{$da->fname}}
                        </h6>
                        @if($recent)
                        <p class="small text-nowrap ms-4 mb-0 text-white">{{
                          \Carbon\Carbon::parse($recent->created_at)->diffForHumans()}}</p>
                        @endif
                      </div>
                        @php
                            $match = false;
                        @endphp
                        @if(preg_match("/<img /i", $recent->message))
                            <div id="recent{{$da->name}}" class="text-truncate recent{{$recent->id}}"><img
                            src="/icons/img.png" alt="image" srcset=""></div>
                            @php
                            $match = true;
                            @endphp
                        @endif
                        @if(preg_match("/<video /i", $recent->message))
                        <div id="recent{{$da->name}}" class="text-truncate recent{{$recent->id}}"><img
                            src="/icons/video.png" alt="video" srcset=""></div>
                            @php
                            $match = true;
                            @endphp
                        @endif
                        @if(preg_match("/<audio /i", $recent->message))
                          <div id="recent{{$da->name}}" class="text-truncate recent{{$recent->id}}"><img
                              src="/icons/audio.png" alt="audio" srcset=""></div>
                            @php
                            $match = true;
                            @endphp
                        @endif
                          @if(!$match)
                            <div id="recent{{$da->name}}" class="text-truncate text-gray recent{{$recent->id}}">
                            {!! $recent->message !!}</div>
                        @endif

                    </div>
                  </div>
                </div>
              </div>
            </li>
            @endif
            @endforeach



            @foreach ($grp as $g)
            @php
            $grecent = groupchat::where('group_id','=',$g->id)->latest('id')->where('status','=',0)->get()->first();
            @endphp
            @if($grecent && $grecent->forwarded == 2)
            @php
            $gmsg = groupchat::find($grecent->message);
            $grecent->message = "<div class='d-flex flex-column'><span
                style='font-size: 11px; text-transform: capitalize;'>forwarded</span>".$gmsg->message."</div>";
            @endphp
            @endif
            @if($grecent && $grecent->forwarded == 1)
            @php
            $umsg = message::find($grecent->message);
            if(!$umsg)
            {
            $umsg = groupchat::find($grecent->message);
            }
            $grecent->message = "<div class='d-flex flex-column'><span
                style='font-size: 11px; text-transform: capitalize;'>forwarded</span>".$umsg->message."</div>";
            @endphp
            @endif
            @if($g->id != Session::get('user_id') && $grecent)
            <li id={{$g->id}} class="li-status">

              <div class="hover_action d-none">
                <button type="button" class="btn btn-link text-warning"><i class="fas fa-star"></i></button>
                <button type="button" class="btn btn-link text-danger"><i class="fas fa-trash"></i></button>
              </div>

              <div onclick="gselect('{{$g->name}}','{{encrypt($g->id)}}')" class="card border-0">
                <div class="card-body">
                  <div class="media">
                    <div class="avatar me-3">

                      @if ($g->image)
                      <img class="newavatar rounded-circle" src="/storage/images/{{ $g->image }}" alt="avatar">
                      @else
                      @php
                      $d = explode(" ", $g->name);
                      @endphp
                      <div class="avatar me-3">

                        <div class="avatar rounded-circle no-image cyan">
                          <span class="text-uppercase">
                            @foreach ($d as $icon)
                            {{$icon[0]." "}}
                            @endforeach
                          </span>
                        </div>
                      </div>
                      @endif
                    </div>
                    <div class="media-body overflow-hidden">
                      <div class="d-flex align-items-center mb-1">
                        <h6 class="text-truncate mb-0 me-auto  text-white">{{$g->name}}</h6>
                        @if($grecent)
                        <p class="small text-white text-nowrap ms-4 mb-0">{{
                          \Carbon\Carbon::parse($grecent->created_at)->diffForHumans()}}</p>
                        @endif
                      </div>
                        @php
                            $gmatch = false;
                        @endphp
                      @if(preg_match("/<img /i", $grecent->message))
                      <div id="recentg{{ str_replace(' ','',$g->name) }}" class="text-truncate grecent{{$grecent->id}}">
                        <img src="/icons/img.png" alt="image" srcset="">
                      </div>
                        @php
                            $gmatch = true;
                        @endphp
                      @endif
                      @if(preg_match("/<video /i", $grecent->message))
                        <div id="recentg{{ str_replace(' ','',$g->name) }}"
                          class="text-truncate grecent{{$grecent->id}}"><img src="/icons/video.png" alt="video"
                            srcset=""></div>
                        @php
                            $gmatch = true;
                        @endphp
                        @endif
                        @if(preg_match("/<audio /i", $grecent->message))
                          <div id="recentg{{ str_replace(' ','',$g->name) }}"
                            class="text-truncate grecent{{$grecent->id}}"><img src="/icons/audio.png" alt="audio"
                              srcset="">
                          </div>
                        @php
                            $gmatch = true;
                        @endphp
                          @endif
                          @if(!$gmatch)
                        <div id="recentg{{ str_replace(' ','',$g->name) }}"
                          class="text-truncate text-gray grecent{{$grecent->id}}">{!!
                          $grecent->message
                          !!}</div>
                        @endif

                    </div>
                  </div>
                </div>
              </div>
            </li>
            @endif
            @endforeach

          </ul>
        </div>
        <div class="tab-pane fade" id="nav-tab-group" role="tabpanel">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 text-white text-uppercase">Create Group</h4>
            <div>
              <!-- <button class="btn btn-dark" type="button" data-toggle="modal" data-target="#InviteFriends">Invite Friends</button> -->
            </div>
          </div>

          <div class="form-group input-group-lg search mb-3">
            <i class="zmdi zmdi-search"></i>
            <input type="text" id="myInput1" onkeyup="myFunction1()" class="form-control" placeholder="Search...">
          </div>
          <form action="/groupinsert" method="post">
            @csrf
            <div class="container">
              <div class="row">
                <div class="col-4 mt-3 mb-3 p-0">
                  <p class="fw-bold m-0"><span class="text-white" style="vertical-align: -8px;">Group Name:</span></p>
                </div>
                <div class="col-8 mt-3 mb-3">
                  <input type="text" required name="gname" class="form-control" placeholder="Enter Group Name">
                </div>

              </div>
            </div>
            <ul class="chat-list" id="myUL1">
              @foreach ($users as $da)

              <li>
                <div class="hover_action bg-transparent" style="visibility:visible; top:25px;">
                  <input type="checkbox" class="largerCheckbox" name="{{$da->id}}">
                </div>
                <a class="card">
                  <div class="card-body">
                    <div class="media">
                      <div class="avatar me-3">
                        <img class="newavatar rounded-circle" src="/storage/images/{{ $da->image }}" alt="avatar">
                      </div>
                      <div class="d-flex align-items-center">
                        <h6 class="text-truncate mb-0 me-auto fw-bold text-white">{{ $da->fname }}</h6>
                      </div>
                    </div>
                  </div>
                </a>
              </li>

              @endforeach
              <div class="container">
                <div class="row">
                  <div class="col text-center">
                    <button class="btn btn-light mt-3 fw-bold">Add to Group</button>
                  </div>
                </div>
              </div>
          </form>
          </ul>
        </div>
        <div class="tab-pane fade" id="nav-tab-usergroups" role="tabpanel">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 text-white text-uppercase">Groups</h4>
            <div>
              <!-- <button class="btn btn-dark" type="button" data-toggle="modal" data-target="#InviteFriends">Invite Friends</button> -->
            </div>
          </div>

          <div class="form-group input-group-lg search mb-3">
            <!--<i class="zmdi zmdi-search"></i>-->
            <input style="font-size: 14px" type="text" class="form-control ps-2" placeholder="Search..." id="myInput6"
              onkeyup="myFunction6()">

          </div>
          <ul class="chat-list" id="myUL6">
            @foreach ($usergroups as $ug)
            @php
            $groupmembers =
            grouppeople::join('users','grouppeoples.user_id','=','users.id')->where('group_id','=',$ug->group_id)->get();
            @endphp
            <li>
              <div class="card">
                <div class="card-body">
                  <div class="media">
                    <div class="avatar me-3">
                      <img class="newavatar rounded-circle" src="/storage/images/{{ $ug->image }}" alt="avatar">
                    </div>
                    <a href="/group/{{encrypt($ug->group_id)}}" class="w-100">
                      <div class="media-body overflow-hidden">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                          <h6 class="text-truncate mb-0 me-auto fw-bold text-white">{{ $ug->name }}</h6>
                        </div>
                        <div class="text-truncate text-white pe-5">
                          @if($ug->lastlogin != '')

                          {{\Carbon\Carbon::parse(str_replace('|','',$ug->updated_at))->diffForHumans()}}
                          @else
                          Members : @foreach($groupmembers as $gm ) {{ $gm->name }}, @endforeach
                          @endif

                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </li>
            @endforeach
          </ul>
        </div>
        <div class="tab-pane fade" id="nav-tab-contact" role="tabpanel">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 text-white text-uppercase">PhoneBook</h4>
            <div>
              <!-- <button class="btn btn-dark" type="button" data-toggle="modal" data-target="#InviteFriends">Invite Friends</button> -->
            </div>
          </div>

          <div class="form-group input-group-lg search mb-3">
            <!--<i class="zmdi zmdi-search"></i>-->
            <input style="font-size: 14px" type="text" class="form-control ps-2" placeholder="Search..." id="myInput2"
              onkeyup="myFunction2()">

          </div>

          <ul class="chat-list" id="myUL2">
            @foreach ($users as $da)
            @if($da->role != "admin" && $da->name != $profile->name)
            <li>
              <div class="hover_action d-none">
                <button type="button" class="btn btn-link text-info" data-bs-toggle="modal"
                  data-bs-target="#{{ str_replace(' ','-',$da->name ) }}{{ $da->id }}"><i
                    class="fas fa-eye"></i></button>
                <button type="button" class="btn btn-link text-warning"><i class="fas fa-star"></i></button>
                <button type="button" class="btn btn-link text-danger"><i class="fas fa-trash"></i></button>
              </div>
              <div class="card">
                <div class="card-body">
                  <div class="media">
                    <div class="avatar me-3" data-bs-toggle="modal"
                      data-bs-target="#{{ str_replace(' ','-',$da->name ) }}{{ $da->id }}">
                      <img class="newavatar rounded-circle" src="/storage/images/{{ $da->image }}" alt="avatar">
                    </div>
                    <a href="/select/{{encrypt($da->id)}}" class="w-100">
                      <div class="media-body overflow-hidden">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                          <h6 class="text-truncate mb-0 me-auto fw-bold text-white">{{ $da->fname }}</h6>
                        </div>
                        <div class="text-truncate text-white d-flex justify-content-between">
                          @if($da->lastlogin != '')
                          {{\Carbon\Carbon::parse(str_replace('|','',$da->lastlogin))->diffForHumans()}}
                          @else
                          <span>online</span>
                          @endif
                          <span style="font-size:12px" class="text-white">{{$da->designation}}</span>

                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </li>
            <div class="modal fade" id="{{ str_replace(' ','-',$da->name ) }}{{ $da->id }}" tabindex="-1"
              aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Contact Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="container">
                      <div class="row">
                        <img src="/storage/images/{{ $da->image }}" class="img-fluid img-thumbnail">
                        <h4 class="text-center mt-5">{{ $da->fname }}</h4>
                        <h5 class="text-center">{{ $da->designation }}</h5>
                        <h6 class="text-center"><a href="mailto:{{ $da->email }}">{{ $da->email }}</a></h6>
                        <div class="mt-3 text-center">
                          <p>{{ $da->bio }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                  </div> --}}
                </div>
              </div>
            </div>
            @endif
            @endforeach
          </ul>
        </div>
      </div>
    </div>

    @include("sidebar")
    <div class="main">
      @if(!isset($user))
      <div class="chat-body h-100">
        <div class="text-center d-flex flex-column justify-content-center align-items-center h-100 fs-4">
          <img src="https://i.pinimg.com/originals/d6/1b/e5/d61be570d6ad6c9d5a6cb6c6190fd0c5.gif" data-aos="zoom-in-up"
            data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">
          <h1 data-aos="fade-up" data-aos-delay="50" data-aos-duration="1000" data-aos-easing="ease-in-out">Select a
            chat to start messaging.</h1>
        </div>
      </div>
      @endif
      @isset($user)
      <div class="chat-body">
        <div class="chat-header border-bottom py-xl-4 py-md-3 py-2">
          <div class="container-xxl">
            <div class="row align-items-center">
              <div class="col-6 col-xl-4">
                <div class="media">
                  <div class="me-3 show-user-detail">
                    <span class="status rounded-circle"></span>
                    @if($user->image)
                    <img class="avatar rounded-circle" src="/storage/images/{{ $user->image }}" alt="avatar">
                    @else
                    <div class="avatar me-3">
                      <span class="status rounded-circle"></span>
                      <div class="avatar rounded-circle no-image cyan">
                        @php
                        $dd = explode(" ",$user->fname);
                        @endphp
                        <span class="text-uppercase">
                          @foreach ($dd as $gicon)
                          {{$gicon[0]." "}}
                          @endforeach
                        </span>
                      </div>
                    </div>
                    @endif
                  </div>
                  <div class="media-body overflow-hidden">
                    <div class="d-flex align-items-center mb-1">
                      <h6 class="text-truncate mb-0 me-auto fw-bold fs-5">@if($user->fname) {{$user->fname}} @else
                        {{$user->name}} @endif</h6>
                    </div>
                    @if(isset($user->status))
                    <div id="ch{{$user->id}}" class="text-truncate user-status">@if($user->status == 1) online @else
                      offline @endif
                    </div>
                    @else
                    <div id="ch{{$user->id}}" class="text-truncate">
                        @foreach($members as $key=>$member)
                        @if($key>0), @endif{{$member->fname}}
                        @endforeach
                    </div>
                    @endif
                  </div>
                </div>
              </div>

              <div class="col-6 col-xl-8 text-end">
                <ul class="nav justify-content-end">
                  <li class="nav-item list-inline-item d-md-block me-3">
                    <a class="nav-link text-muted px-3" data-toggle="collapse" data-target="#chat-search-div"
                      aria-expanded="true" title="Search this chat">
                      <i class="fas fa-search fa-lg"></i>
                    </a>
                  </li>
                  {{-- <li class="nav-item list-inline-item d-none d-sm-block me-3">
                    <a class="nav-link text-muted px-3" title="Video Call">
                      <i class="fas fa-video fa-lg"></i>
                    </a>
                  </li>
                  <li class="nav-item list-inline-item d-none d-sm-block me-3">
                    <a class="nav-link text-muted px-3" title="Voice Call">
                      <i class="fas fa-phone-alt fa-lg"></i>
                    </a>
                  </li> --}}
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="collapse" id="chat-search-div">
          <div class="container-xxl py-2">
            <div class="input-group">
              <input type="text" class="form-control" id="myInput5" onkeyup="filter()"
                placeholder="Find messages in current conversation">
              <div class="input-group-append">
                <!--<button type="button" class="btn btn-secondary">Search</button>-->
              </div>
            </div>
          </div>
        </div>
        <!--Search results-->
        <div id="search-result" class="w-100 overflow-auto">
          <ol class="list-unstyled p-2">

          </ol>
        </div>

        {{-- Message section --}}
        <div id="chat" class="chat-content">
          <div class="container-xxl">
            <ul id="msg_dis" class="{{$user->id}}{{Session::GET('user_id')}} list-unstyled py-4">
              @isset($gchats)
              @foreach ($gchats as $d)
              @php
              $id = '';
              if($d->reply > 0)
              {
              $rmsg = groupchat::find($d->reply);
              if($rmsg && $rmsg->forwarded == 1)
              $rmsg = message::find($rmsg->message);
              else if($rmsg && $rmsg->forwarded == 2)
              $rmsg = groupchat::find($rmsg->message);
              }
              @endphp
              @if($d->forwarded == 2)
              @php
              $gmsg = groupchat::find($d->message);
              $d->message = "<div class='d-flex flex-column'><span
                  style='font-size: 11px; text-transform: capitalize;'>forwarded</span>".$gmsg->message."</div>";
              $id = "g".$gmsg->id;
              @endphp
              @endif
              @if($d->forwarded == 1)
              @php
              $umsg = message::find($d->message);
              $id = "u".$umsg->id;
              if(!$umsg)
              {
              $umsg = groupchat::find($d->message);
              $id = "g".$umsg->id;
              }
              $d->message = "<div class='d-flex flex-column'><span
                  style='font-size: 11px; text-transform: capitalize;'>forwarded</span>".$umsg->message."</div>";

              @endphp
              @endif
              @if($d->sender == Session::get('user'))
              <li id="g{{$d->id}}" class="d-flex message right animate__animated animate__fadeInRight">
                <div class="message-body">
                  <div class="message-row d-flex align-items-stretch justify-content-end">
                    <div class="dropdown d-flex align-items-center justify-content-center">
                      <div>
                        <a class="text-primary me-1 p-2" href="/addpin/g{{$d->id}}"><i class="ti-pin-alt" title='Pin'></i></a>
                        <a class="text-dark me-1 p-2"
                        onclick="shareMsg('@if(isset($id) && $id){{$id}}@else g{{$d->id}} @endif')">
                        <i class="fa-solid fa-share" title='Forword'></i>
                        </a>
                        <a class="text-danger me-1 p-2" onclick="gdelmsg({{$d->id}})"><i class="fas fa-trash"></i></a>
                      </div>
                    </div>
                    <div ondblclick="dbreply(this)" class="message-content border p-3 fs-5 bg-primary text-white"
                      data-help="g{{$d->id}}">
                      @if($d->reply == 0)
                      {!! $d->message !!}
                      @else
                      <div>
                        <div class="reply my-2">
                          <a href="#g{{$d->reply}}" onclick="resultClear('#g{{$d->reply}}')">
                            <div class="text-gray">
                              <span class="">@if(Session::get('user') == $rmsg->sender) You: @else
                                {{$rmsg->sender}}: @endif</span>
                              {!! $rmsg->message !!}
                            </div>
                          </a>
                        </div>
                        <div>
                          {!! $d->message !!}
                        </div>
                      </div>
                      @endif
                    </div>
                  </div>
                  <span class="date-time text-muted">{{ \Carbon\Carbon::parse($d->created_at)->format('d-m-Y | h:i
                    A')}} <i class="fas fa-check text-primary px-1"></i></span>
                </div>
              </li>
              @endif
              @if($d->sender != Session::get('user'))
              <li id="g{{$d->id}}" class="d-flex message animate__animated animate__fadeInLeft">
                <div class="message-body">
                  <span class="date-time text-muted">{{$d->sender}} | {{
                    \Carbon\Carbon::parse($d->created_at)->format('d-m-Y | h:i
                    A')}}</span>
                  <div class="message-row d-flex align-items-stretch">
                    <div ondblclick="dbreply(this)" class="message-content p-2 fs-small" data-help="g{{$d->id}}">
                      @if($d->reply == 0)
                      {!! $d->message !!}
                      @else
                      <div>
                        <div class="reply border-primary my-2">
                          <a href="#g{{$d->reply}}" onclick="resultClear('#g{{$d->reply}}')">
                            <div class="text-secondary">
                              <span class="">@if(Session::get('user') == $rmsg->sender) You: @else
                                {{$rmsg->sender}}: @endif</span>
                              {!! $rmsg->message !!}
                            </div>
                          </a>
                        </div>
                        <div>
                          {!! $d->message !!}
                        </div>
                      </div>
                      @endif
                    </div>
                    <div class="dropdown d-flex align-items-center justify-content-center">
                     <div>
                          <a class="text-dark me-1 p-2"
                        onclick="shareMsg('@if(isset($id) && $id){{$id}}@else g{{$d->id}} @endif')">
                        <i class="fa-solid fa-share" title='Forword'></i>
                      </a>
                      <a class="text-primary me-1 p-2" href="/addpin/u{{$d->id}}"><i class="ti-pin-alt" title='Pin'></i></a>
                     </div>
                    </div>

                  </div>
                </div>
              </li>
              @endif
              @endforeach
              @endisset


              {{-- one-to-one chat from database --}}
              @php
                $flag = false;
              @endphp
              @foreach ($msg as $d)
                  @php
                  if($d->status == 2)
                        $d->message = "Message Deleted By Admin";
                  $id = '';
                  if($d->reply > 0)
                  {
                    $rmsg = message::find($d->reply);
                    if($rmsg && $rmsg->forwarded == 1)
                        $rmsg = message::find($rmsg->message);
                    else if($rmsg && $rmsg->forwarded == 2)
                        $rmsg = groupchat::find($rmsg->message);
                  }
                  @endphp
                  @if($d->forwarded == 2)
                      @php
                          $gmsg = groupchat::find($d->message);
                          $d->message = "<div class='d-flex flex-column'><span
                              style='font-size: 11px; text-transform: capitalize;'>forwarded</span>".$gmsg->message."</div>";
                          $id = "g".$gmsg->id;
                      @endphp
                  @endif
                  @if($d->forwarded == 1)
                      @php
                          $umsg = message::find($d->message);
                          $id = "u".$umsg->id;
                          if(!$umsg)
                          {
                              $umsg = groupchat::find($d->message);
                              $id = "g".$umsg->id;
                          }
                          $d->message = "<div class='d-flex flex-column'><span
                              style='font-size: 11px; text-transform: capitalize;'>forwarded</span>".$umsg->message."</div>";
                      @endphp
                  @endif
                  @if($d->sender == Session::get('user') && $d->recevier == $user->name)
                        @if(\Carbon\Carbon::parse($d->created_at)->format('d-m-Y') == date('d-m-Y') && !$flag)
                        <li class="d-flex justify-content-center text-center border-bottom pb-2">
                        <h6 class="mb-0">Today</h6>
                        </li>
                            @php
                                $flag = true;
                            @endphp
                        @endif
                    <li id="msg{{$d->id}}" class="d-flex mt-2 message right animate__animated animate__fadeInRight">
                <div class="message-body">
                  <div class="message-row d-flex align-items-stretch justify-content-end">
                    <div class="dropdown d-flex align-items-center justify-content-center">
                      <div>
                        <a class="text-primary me-1 p-2" href="/addpin/u{{$d->id}}"><i class="ti-pin-alt" title='Pin'></i></a>
                        <a class="text-dark me-1 p-2"
                        onclick="shareMsg(@if(isset($id) && $id) '{{$id}}' @else 'u{{$d->id}}' @endif)">
                        <i class="fa-solid fa-share" title='Forword'></i>
                        </a>
                        <a class="text-danger me-1 p-2" onclick="delmsg({{$d->id}})"><i class="fas fa-trash"></i></a>
                      </div>
                    </div>
                    <div class="d-none reply reply{{$d->id}}">
                      <button class="btn btn-light">Reply</button>
                    </div>
                    <div ondblclick="dbreply(this)" class="message-content border p-2 fs-small  {{ $d->status == 2 ? 'bg-danger' : 'bg-gray'}} text-white"
                      data-reply="reply{{$d->id}}" data-help="msg{{$d->id}}">
                      @if($d->reply == 0)
                      {!! $d->message !!}
                      @else
                      <div>
                        <div class="reply my-2">
                          <a href="#msg{{$d->reply}}" onclick="resultClear('#msg{{$d->reply}}')">
                            <div class="text-gray">
                              <span class="">@if(Session::get('user') == $rmsg->sender) You: @else
                                {{$rmsg->sender}}: @endif</span>
                              {!! $rmsg->message !!}
                            </div>
                          </a>
                        </div>
                        <div>
                          {!! $d->message !!}
                        </div>
                      </div>
                      @endif
                    </div>

                  </div>
                  <span class="date-time text-muted">{{ \Carbon\Carbon::parse($d->created_at)->format('d-m-Y | h:i
                    A')}} <i
                      class="fas @if($d->seen == 1) fa-check-double @else fa-check @endif  text-primary px-1"></i></span>
                </div>
              </li>
                  @endif
              @if($d->sender == $user->name && $d->recevier == Session::get('user'))
                    @if(\Carbon\Carbon::parse($d->created_at)->format('d-m-Y') == date('d-m-Y') && !$flag)
                      <li class="d-flex justify-content-center text-center border-bottom pb-2">
                        <h6 class="mb-0">Today</h6>
                      </li>
                      @php
                        $flag = true;
                      @endphp
                    @endif
                <li id="msg{{$d->id}}" class="d-flex message animate__animated animate__fadeInLeft">
                <div class="message-body">
                  <span class="date-time text-muted">{{$d->sender}} | {{
                    \Carbon\Carbon::parse($d->created_at)->format('d-m-Y | h:i
                    A')}}</span>
                  <div class="d-none reply reply{{$d->id}}">
                    <button class="btn btn-light">Reply</button>
                  </div>
                  <div class="message-row d-flex align-items-stretch">
                    <div ondblclick="dbreply(this)" class="message-content p-2 fs-small {{ $d->status == 2 ? 'bg-danger text-white' : ''}}" data-reply="reply{{$d->id}}"
                      data-help="msg{{$d->id}}">
                      @if($d->reply == 0)
                      {!! $d->message !!}
                      @else
                      <div>
                        <div class="reply my-2 text-secondary border-primary">
                          <a href="#msg{{$d->reply}}" onclick="resultClear('#msg{{$d->reply}}')">
                            <div class="text-secondary">
                              <span class="">@if(Session::get('user') == $rmsg->sender) You: @else
                                {{$rmsg->sender}}: @endif</span>
                              {!! $rmsg->message !!}
                            </div>
                          </a>
                        </div>
                        <div>
                          {!! $d->message !!}
                        </div>
                      </div>
                      @endif
                    </div>
                    <div class="dropdown d-flex align-items-center justify-content-center">
                      <a class="text-dark me-1 p-2"
                        onclick="shareMsg(@if(isset($id) && $id) 'u{{$id}}' @else 'u{{$d->id}}' @endif)">
                        <i class="fa-solid fa-share" title='Forword'></i>
                      </a>
                      <a class="text-primary me-1 p-2" href="/addpin/{{$d->id}}"><i class="ti-pin-alt" title='Pin'></i></a>
                    </div>

                  </div>
                </div>
              </li>
              @endif
            @endforeach
            </ul>
          </div>
        </div>
        <div class="overflow-auto">
          <div id="prereply" class="text-start m-auto text-dark prereply" style="width: 80%"></div>
          <div class="chat-footer border-top py-xl-0 py-lg-0 pb-2 mb-4">
            <div class="container-xxl">
              <div class="row">
                <div class="col-12 px-0">
                  <div class="input-group align-items-center">
                    <div id="preview" class="text-end"></div>
                    @if(!isset($group))
                    <div id='emojiselect' class='row bg-dark d-none'>
                         @foreach ($emojigroup as $group)
                            <div onclick='changeEmoji(this, "{{str_replace(array('&', ' '),array('', ''),$group->groups)}}")' class='col @if($group->groups == "Smileys & Emotion") bg-secondary @endif groups fs-1' style='cursor:pointer'>{{($group->emoji)}}</div>
                         @endforeach
                    </div>
                    <div id="previewemoji" class='d-none'>
                        <div class="fs-1 position-relative">
                          @foreach ($emojis as $emoji)
                                <button title="{{$emoji->description}}" data-groups="{{str_replace(array('&', ' '),array('', ''),$emoji->groups)}}"  class="@if($emoji->groups != 'Smileys & Emotion') d-none @endif selectedemoji bg-transparent border-0 emojis"
                                value="{{($emoji->emoji)}}">{{($emoji->emoji)}}</button>
                          @endforeach
                        </div>
                    </div>
                    <form class="d-flex w-100" id="form" method="POST" enctype="multipart/form-data">
                      <input type="hidden" id="id" name="id" value="{{Session::get('user_id')}}">
                      <input type="hidden" id="rev" name="rev" value="{{$user->id}}">
                      <input type="hidden" id="name" name="name" value="{{Session::get('user')}}">
                      <input type="hidden" id="reciver" name="reciver" value="{{$user->name}}">
                      <input type="hidden" id="dd" class="{{Session::get('user_id')}}{{$user->name}}" name="dd"
                        value="{{$double}}">
                      <input id="formreply" type="hidden" name="reply">
                      <input autocomplete="off" rows="1" onblur="online({{Session::get('user_id')}})"
                        oninput="typing({{Session::get('user_id')}})" id="msg" name="msg"
                        class="form-control border-0 pl-0 text-secondary fw-bold" placeholder="Type your message...">
                      <div class="tools">
                        <div class="input-group-append">
                          <span class="input-group-text border-0">
                            <button id="emoji" class="h-41 btn btn-sm  text-muted" data-toggle="tooltip" title="Emoji"
                              type="button"><i class="ti-face-smile font-22"></i></button>
                          </span>
                        </div>
                        <div data-toggle="tooltip" title="Attach File">
                          <div class="input-group-append">
                            <span class="input-group-text border-0">
                              <label class="custom-file-upload btn btn-sm  text-muted">
                                <input type="file" name="file[]" multiple class="doc" id="doc" oninput="loadFile(event)" />
                                <i class="h-41 ti-link font-22"></i>
                              </label>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text border-0 pr-0">
                          <button type="submit" class="h-41 send btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                          </button>
                        </span>
                      </div>
                    </form>
                    @else
                    <div id="previewemoji" class="d-none fs-1">
                      @foreach ($emojis as $emoji)
                      <button class="selectedemoji bg-transparent border-0"
                        value="{{($emoji->emoji)}}">{{($emoji->emoji)}}</button>
                      @endforeach
                    </div>
                    <form class="d-flex w-100" id="gform" method="POST">
                      @csrf
                      <input type="hidden" id="sname" name="sname" value="{{Session::get('user')}}">
                      <input type="hidden" id="gname" name="gname" value="{{$user->name}}">
                      <input type="hidden" id="gid" name="gid" value="{{$user->id}}">
                      <input id="formreply" type="hidden" name="reply">
                      <input type="text" id="msg" name="gmsg" class="form-control border-0 pl-0 text-secondary fw-bold"
                        placeholder="Type your message...">
                      <div class="tools">
                        <div class="input-group-append">
                          <span class="input-group-text border-0">
                            <button id="emoji" class="btn btn-sm  text-muted" data-toggle="tooltip" title="Emoji"
                              type="button"><i class="ti-face-smile font-22"></i></button>
                          </span>
                        </div>
                        <div data-toggle="tooltip" title="Attach File">
                          <div class="input-group-append">
                            <span class="input-group-text border-0">
                              <label class="custom-file-upload btn btn-sm  text-muted">
                                <input type="file" name="file[]" multiple class="doc" id="doc" oninput="loadFile(event)" />
                                <i class="ti-link font-22"></i>
                              </label>


                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text border-0 pr-0">
                          <button type="submit" class="h-41 send btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                          </button>
                        </span>
                      </div>

                    </form>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endisset

      @isset($user)
      <div class="user-detail-sidebar py-xl-4 py-3 px-xl-4 px-3 border-start">
        <div class="d-flex flex-column">
          <div class="header border-bottom pb-4 d-flex justify-content-between">
            <div>
              <h6 class="mb-0 font-weight-bold">User Details</h6>
            </div>
            <div>
              <button class="btn  text-muted close-chat-sidebar" type="button"><i class="ti-close"></i></button>
            </div>
          </div>
          <div class="body mt-4">
            <div class="d-flex justify-content-center">
              <div class="avatar xxl">
                <img class="avatar xxl rounded-circle" src="/storage/images/{{ $user->image }}" alt="avatar">
              </div>
            </div>
            <div class="text-start mt-5 pt-5 mb-5">
              @if(isset($users) && !isset($gchats))
              <h4>{{ $user->fname }}</h4>
              <h6>{{ $user->designation }}</h6>
              <span class="text-muted"><a>{{ $user->email }}</a></span>
            </div>

            <div class="text-center mt-5 pt-5 mb-5">
              <span class="text-muted"><a>{{ $user->bio }}</a></span>
            </div>
            @else
            <h4>{{ $user->fname }}</h4>
            <h6>Members</h6>
            @foreach($members as $peoples)
            <a href="/select/{{encrypt($peoples->id)}}">
                <div class="text-start my-3 border-bottom pb-2">
                  <div class="row">
                    <div class="col-lg-3">
                      <img src="/storage/images/{{$peoples->image}}" style="object-fit: cover" class="rounded-circle" width="60" height="60">
                    </div>
                    <div class="col-lg-4 d-flex align-items-center">
                      <h6>{{$peoples->fname}}</h6>
                    </div>
                    <div class="col-lg-5 d-flex align-items-center">
                      <span class="small text-dark">{{$peoples->designation}}</span>
                    </div>
                  </div>
                </div>
            </a>
            @endforeach
            @endif
          </div>
        </div>
      </div>
      @endisset



      <div class="modal fade" id="InviteFriends" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Invite New Friends</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form>
                <div class="form-group">
                  <label>Email address</label>
                  <input type="email" class="form-control">
                  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                    else.</small>
                </div>
              </form>
              <div class="mt-5">
                <button type="button" class="btn btn-primary">Send Invite</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="/./js/app.js"></script>

    <script src="/assets/vendor/jquery/jquery-3.5.1.min.js"></script>
    <script src="/assets/vendor/bootstrap.bundle.min.js"></script>
    <script src="/assets/vendor/bootstrap-datepicker.min.js"></script>

    <script src="/assets/js/template.js"></script>
    <script src="/js/main.js"></script>
    <script src="//jquerycsvtotable.googlecode.com/files/jquery.csvToTable.js"></script>

    <script>
      localStorage.setItem('user','{{$profile->name}}')
    </script>
    @isset($user)
    <script>
      localStorage.setItem('selected','{{$user->name}}')
    </script>
    @endisset
<script>
  
  const zmessage = document.getElementsByClassName("message-content");
  for(var i=0; i<zmessage.length; i++){
      if(zmessage[i].innerHTML.match("deleted by admin"))
      {
          zmessage[i].classList.remove('bg-primary');
          zmessage[i].classList.add('bg-danger');
          zmessage[i].classList.add('text-white');

      }
  }
  function typing(id) {
    const msg = document.getElementById('msg');
    if(msg.value.length > 0 && msg.value.length < 5)
    {
        $.ajax({
        type: "GET",
        url: '/typing/' + id,
        });
    }
    else if(msg.value.length == 0)
    {
        $.ajax({
          type: 'get',
          url: '/spectator',
        })
    }

}
  function viewImage(url)
  {
      $("#imageView img").attr('src',url);
      $("#view").click();
  }
  function viewDocs(url)
  {
    if(url.match(".docx|.xls|.doc|.ppt"))
    url = "https://view.officeapps.live.com/op/embed.aspx?src=http://chat.thesiliconreview.org"+url;
    $("#viewDoc iframe").attr('src',url);
    $("#viewDocs").click();
}
</script>
</body>

</html>