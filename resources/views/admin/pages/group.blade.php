@extends('admin.layout.master')
@section('content')

<div class="container">
<h3 class=" text-center py-3 text-dark font-weight-bold"> {{ $groupname->name }}</h3>
<div class="messaging">
      <div class="inbox_msg">
        <div class="mesgs">
          <div class="msg_history">
         
                  @foreach( $groupchats as $chats )
                
                    <div class="incoming_msg py-2">
                        <div class="incoming_msg_img"> <img class="img-fluid" src="/storage/images/{{ $groupname->image }}" alt=""> 
                        </div>
                        <div class="received_msg">
                            <div class="received_withd_msg">
                                <div class="d-flex">
                                    <p>{!! $chats->message !!}</p>
                                    <a onclick="return confirm('Are You sure want to Delete!')" href="/admin/msgdelgroup/{{$chats->id }}">
                                      <img src="https://img.icons8.com/ios-glyphs/30/000000/filled-trash.png"/>
                                    </a>
                                </div>
                                <div class="d-flex justify-content-between">
                                  <span class="time_date">{{ \Carbon\Carbon::parse($chats->created_at)->format('d-m-Y | h:i
                    A')}} | {{ $chats->sender }}</span>
                                  <span class="text-danger">
                                        @if( $chats->status == 1 )
                                            deleted by user
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
              
            @endforeach
            
          </div>
          
        </div>
      </div>
    </div>
    </div>

@endsection