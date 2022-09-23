@php
use App\Models\message;
use App\Models\grouppeople;
use App\Models\groupchat;
@endphp

<div class="rightbar d-none d-md-block">
    <div class="nav flex-column nav-pills border-start py-xl-4 py-3 h-100">
        <a class="nav-link mb-2 text-center rightbar-link text-white" data-toggle="pill" href="#tab-calendar"><i
                class="ti-calendar"></i></a>
        <a class="nav-link mb-2 text-center rightbar-link text-white" data-toggle="pill" href="#tab-note"><i
                class="ti-book"></i></a>
                @if($pinnedchats)
        <a class="nav-link mb-2 text-center rightbar-link text-white" data-toggle="pill" href="#tab-pins"><i
                class="ti-pin-alt"></i></a> @endif
    </div>
    <div class="tab-content py-xl-4 py-3 px-xl-4 px-3">
        <div class="tab-pane fade" id="tab-calendar" role="tabpanel">
            <div class="header border-bottom pb-4 d-flex justify-content-between">
                <div>
                    <h6 class="mb-0 font-weight-bold">Calendar</h6>
                </div>
                <div>
                    <button class="btn close-sidebar" style="font-size:30px;" type="button"><i
                            class="ti-close"></i></button>
                </div>
            </div>

            <div class="body mt-4">
                <div id="mini-calendar"></div>
            </div>
        </div>
        <div class="tab-pane fade" id="tab-pins" role="tabpanel">
            <div class="header border-bottom pb-4 d-flex justify-content-between">
                <div>
                    <h6 class="mb-0 font-weight-bold">Chat Pins</h6>
                </div>
                <div>
                    <button class="btn close-sidebar" style="font-size:30px;" type="button"><i
                            class="ti-close"></i></button>
                </div>
            </div>
                        <ul class="list-unstyled mt-4 border-bottom">
                                
                             @forelse( $pinnedchats as $pc )
                            <li class="card border-0 mb-2">
                                <span><a href="#g{{ encrypt($pc->id) }}" onclick="return hidediv()">@if($pc->forwarded == 1)
                                @php
                                $forwardmessage = message::find($pc->message);
                                $pc->message = $forwardmessage->message;
                                @endphp
                                @endif
                                @if($pc->forwarded == 2)
                                @php
                                $forwardmessage = groupchat::find($pc->message);
                                $pc->message = $forwardmessage->message;
                                @endphp
                                @endif
                                {{ $pc->message }}</a></span>
                                
                                <div class="d-flex justify-content-between">
                                    <span style="font-size: 12px;">message by {{ $pc->sender }}</span><span style="font-size: 12px;">{{ \Carbon\Carbon::parse($pc->created_at)->format('d-M-Y')}}</span><span>
                                         <a href="/unpinchat/@if(isset($pc->group_id))g{{ ($pc->id) }} @else{{($pc->id) }} @endif" type="button" class="btn btn-danger">Unpin<i
                                            class="ti-pin-alt"></i></button></a>
                                </div
                            </li>
                            @empty
                            <li class="card border-0 mb-2">
                                No Pinned Chats
                            </li>
                            @endforelse
                        </ul>
            
        </div>
        <div class="tab-pane fade" id="tab-note" role="tabpanel">
            <div class="header border-bottom pb-4 d-flex justify-content-between">
                <div>
                    @if(!isset($user))
                    <h6 class="mb-0 font-weight-bold">My Notes</h6>
                    @else
                    <h6 class="mb-0 font-weight-bold">Chat Notes</h6>
                    @endif
                </div>
                <div>
                    <button class="btn close-sidebar" style="font-size:30px;" type="button"><i
                            class="ti-close"></i></button>
                </div>
            </div>

            <div class="body mt-4">
                <div class="add-note">
                    <form action="/add-note" method="POST">
                        @csrf
                        @isset($profile)
                        <input type="hidden" name="user_id" value="{{encrypt($profile->id)}}">
                        @endisset
                        @isset($user)
                        <input type="hidden" name="receiver_id" value="{{encrypt($user->id)}}">
                        @endisset
                        <div class="input-group mb-2">
                            <textarea rows="3" name="note" class="form-control"
                                placeholder="Enter a note here.."></textarea>
                        </div>
                        <div class="input-group mb-2">
                            <input id="type" type="checkbox" @if(!isset($user)) checked disabled @endif name="type"
                                class=""><label for="type" class="px-2">Personal Note?</label>
                        </div>
                        <button type="submit" class="btn btn-primary addnote">Add</button>
                    </form>

                    <div style="overflow-y: auto; height: 50vh;">
                        <ul class="list-unstyled mt-4 border-bottom">
                            @isset($notes)
                            @foreach ($notes as $note)
                            <li class="card border-0 mb-2">
                                <span>{{$note->notes}}</span>
                                @if ($profile->id == $note->user_id)
                                <div class="d-flex justify-content-between">
                                    <span style="font-size: 12px;">added by {{$profile->name}}</span><span style="font-size: 12px;">{{ \Carbon\Carbon::parse($note->created_at)->format('d-M-Y')}}</span>
                                </div>
                                <form id="noteForm{{$note->id}}" action="/note-delete" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{encrypt($note->id)}}">
                                    <button onclick="confirmNoteDel({{$note->id}})" type="button" class="btn btn-sm btn-link"><i
                                            class="zmdi zmdi-delete text-danger"></i></button>
                                </form>
                                @endif
                                @if ($user && $user->id == $note->user_id)
                                <div class="d-flex justify-content-between">
                                    <span style="font-size: 12px;">added by {{$user->name}}</span><span style="font-size: 12px;">{{ \Carbon\Carbon::parse($note->created_at)->format('d-M-Y')}}</span>
                                </div>
                                @endif
                            </li>
                            @endforeach
                            @endisset
                        </ul>
                        @isset($pnotes)
                        @if($pnotes !='[]')
                        <h6 class="mb-0 font-weight-bold">Personal Notes</h6>
                        @endif
                        <ul class="list-unstyled mt-4">
                            
                            @foreach ($pnotes as $note)
                            <li class="card border-0 mb-2">
                                <span>{{$note->notes}}</span>
                                <div class="d-flex justify-content-between">
                                    <span style="font-size: 12px;">added by {{$profile->name}}</span><span style="font-size: 12px;">{{ \Carbon\Carbon::parse($note->created_at)->format('d-M-Y')}}</span>
                                </div>
                                <form id="noteForm{{$note->id}}" action="/note-delete" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{encrypt($note->id)}}">
                                    <button onclick="confirmNoteDel({{$note->id}})" type="button" class="btn btn-sm btn-link"><i
                                            class="zmdi zmdi-delete text-danger"></i></button>
                                </form>
                            </li>
                            @endforeach
                        </ul>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function hidediv(){
        $('.rightbar').removeClass('open')
        return true;
    }
</script>