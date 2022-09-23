@extends('admin.layout.master')
@section('content')

<div class="container">
<h3 class=" text-center py-3 text-dark font-weight-bold">{{ $res }} <i class="fas fa-arrow-right"></i> {{$send}}</h3>
<div class="messaging">
      <div class="inbox_msg">
        <div class="mesgs">
          <div class="msg_history">
              @foreach( $message as $item )
                    @if( $send == $item->sender )
                  <div class="outgoing_msg py-2">
                  <div class="sent_msg">
                      <div class="d-flex"><a onclick="return confirm('Are You sure want to Delete!')"  href="/admin/msgdel/{{$item->id }}">
                          <img src="https://img.icons8.com/ios-glyphs/30/000000/filled-trash.png"/>
                          </a>
                          <p>{!! $item->message !!}</p></div>
                          <div class="d-flex justify-content-between">
                    <span class="time_date">{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y | h:i
                    A')}} </span><span class="text-danger">
                        @if( $item->status == 1 )
                            deleted by user
                        @endif
                    </span>
                    </div>
                    </div>
                    </div>
                    @else
                    <div class="incoming_msg py-2">
              <div class="incoming_msg_img"> <img class="img-fluid" src="/storage/images/{{ $resimage->image }}" alt=""> 
              </div>
              <div class="received_msg">
                <div class="received_withd_msg">
                    <div class="d-flex">
                      <p>{!! $item->message !!}</p>
                        <a onclick="return confirm('Are You sure want to Delete!')" href="/admin/msgdel/{{$item->id }}">
                          <img src="https://img.icons8.com/ios-glyphs/30/000000/filled-trash.png"/>
                         </a>
                    </div>
                     <div class="d-flex justify-content-between">
                  <span class="time_date"> {{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y | h:i
                    A')}}</span>
                   <span class="text-danger">
                        @if( $item->status == 1 )
                            deleted by user
                        @endif
                    </span>
                    </div>
                </div>
              </div>
            </div>
                    @endif
                    
              @endforeach
              
            
            
          </div>
          
        </div>
      </div>
    </div>
    </div>

@endsection