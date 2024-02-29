@extends('theme-views.layouts.app')

@section('title', translate('my_Inbox').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@section('content')
    <main class="main-content d-flex flex-column gap-3 py-3 mb-5">
        <div class="container">
            <div class="row g-3">
                @include('theme-views.partials._profile-aside')
                <div class="col-lg-9">
                    <div class="card h-100 mb-3 border-0">
                        <div class="flexible-grid md-down-1 h-100 width--15-625">
                            <div class="bg-light h-100">
                                <div class="p-3">
                                    <h4 class="mb-3">{{translate('messages')}}</h4>
                                    <form action="#" class="mb-3">
                                        <div class="search-bar style--two">
                                            <button type="submit">
                                                <i class="bi bi-search"></i>
                                            </button>
                                            <input type="search" class="form-control" id="search-value" autocomplete="off"
                                                   placeholder="{{translate('search').'...'}}">
                                        </div>
                                    </form>

                                    <ul class="nav nav--tabs gap-3">
                                        <li class="nav-item" role="presentation">
                                            <a class="{{Request::is('chat/seller')?'active':''}}"
                                               href="{{route('chat', ['type' => 'seller'])}}">{{translate('vendor')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="{{Request::is('chat/delivery-man')?'active':''}}"
                                               href="{{route('chat', ['type' => 'delivery-man'])}}">{{translate('delivery_man')}}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content p-2 pt-0">
                                    <div class="tab-pane fade show active" id="seller-tab-pane" role="tabpanel"
                                         aria-labelledby="seller-tab" tabindex="0">
                                        <div class="chat-list custom-scrollbar ">
                                            @if (isset($unique_shops))
                                                @foreach($unique_shops as $key=>$shop)
                                                    @php($type = $shop->delivery_man_id ? 'delivery-man' : 'seller')
                                                    @php($unique_id = $shop->delivery_man_id ?? $shop->shop_id)
                                                    <div  data-link="{{route('chat', ['type' => $type])}}/?id={{$unique_id}}"
                                                        class="chat-list get-view-by-onclick chat-list-item {{($last_chat->delivery_man_id==$unique_id || $last_chat->shop_id==$unique_id) ? 'active' : ''}} media gap-2 align-items-center"
                                                        id="user_{{$unique_id}}">
                                                        <div class="avatar rounded-circle ">
                                                            @if($shop->delivery_man_id)
                                                                <img class="img-fit rounded-circle dark-support" alt="" loading="lazy"
                                                                src="{{ getValidImage(path: 'storage/app/public/delivery-man/'.$shop->image, type:'avatar') }}">
                                                            @else
                                                                <img class="img-fit rounded-circle dark-support" alt="" loading="lazy"
                                                                     src="{{ getValidImage(path: 'storage/app/public/shop/'.$shop->image, type:'shop') }}">
                                                            @endif
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="chat-people-name gap-2 align-items-center mb-1">
                                                                <div
                                                                    class="text-truncate d-flex align-items-center gap-1 width--100">
                                                                    <h6 class="fs-12 seller"
                                                                        id="{{$unique_id}}">{{$shop->f_name? $shop->f_name. ' ' . $shop->l_name: $shop->name}}</h6>
                                                                    <div class="fs-12 text-muted"></div>
                                                                </div>

                                                                <div
                                                                    class="fs-10">{{date('M d',strtotime($shop->created_at))}}</div>
                                                            </div>
                                                            <p class="fs-10">{{$shop->seller_email ?? $shop->email}}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                @if(isset($last_chat))
                                    <div class="border-bottom px-3 py-2">
                                        <div class="media gap-2 align-items-center">
                                            <div class="avatar rounded-circle">
                                                @if($last_chat->deliveryMan)
                                                    <img alt="" loading="lazy" id="image" class="img-fit rounded-circle dark-support"
                                                        src="{{ getValidImage(path: 'storage/app/public/delivery-man/'.$last_chat->deliveryMan->image, type:'avatar') }}">
                                                @else
                                                    <img alt="" loading="lazy" id="image" class="img-fit rounded-circle dark-support"
                                                         src="{{ getValidImage(path: 'storage/app/public/shop/'.$last_chat->shop->image, type:'shop') }}">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <div class="d-flex flex-column gap-1">
                                                    <h6 class="" id="name">
                                                        {{$last_chat?->deliveryMan?$last_chat->deliveryMan->f_name.' '.$last_chat->deliveryMan->l_name : $last_chat->shop->name  }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="messaging">
                                        <div class="inbox_msg custom-scrollbar p-3 message-history height-480px"
                                             id="show_msg">
                                            @if (isset($chattings))
                                                @foreach($chattings as $key => $chat)
                                                    @if ($chat->sent_by_seller ?? $chat->sent_by_delivery_man)
                                                            <div class="received_msg">
                                                                @if($chat->message)
                                                                <p class="message_text">
                                                                    {{$chat->message}}
                                                                </p>
                                                                @endif
                                                                @if (json_decode($chat['attachment']) !=null)
                                                                    <div class="row g-2 flex-wrap mt-3 justify-content-start">
                                                                        @foreach (json_decode($chat['attachment']) as $index => $photo)
                                                                            @if(file_exists(base_path("storage/app/public/chatting/".$photo)))
                                                                            <div class="col-sm-6 col-md-3">
                                                                                <img src="{{ getValidImage(path: 'storage/app/public/chatting/'.$photo, type:'product') }}" class="height-100 rounded remove-mask-img" alt="">
                                                                            </div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                                <span class="time_date"> {{ date('h:i:A | M d',strtotime($chat->created_at)) }} </span>
                                                            </div>
                                                    @else
                                                        <div class="outgoing_msg" id="outgoing_msg">
                                                            @if($chat->message)
                                                            <p class="message_text">
                                                                {{$chat->message}}
                                                            </p>
                                                            @endif
                                                            @if ($chat['attachment'] !=null)
                                                                <div class="row g-2 flex-wrap mt-3 justify-content-end">
                                                                    @foreach (json_decode($chat['attachment']) as $index => $photo)
                                                                        @if(file_exists(base_path("storage/app/public/chatting/".$photo)))
                                                                            <div class="col-sm-6 col-md-3">
                                                                                <img class="height-100 rounded remove-mask-img" alt=""
                                                                                    src="{{ getValidImage(path: 'storage/app/public/chatting/'.$photo, type:'product') }}">
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                            <span class="time_date d-flex justify-content-end"> {{ date('h:i:A | M d',strtotime($chat->created_at)) }} </span>
                                                        </div>
                                                @endif
                                                @endForeach
                                                <div id="down"></div>
                                            @endif
                                        </div>
                                        <div class="type_msg px-2">
                                            <form action="{{route('messages_store')}}" method="post" class="mt-4" id="submit-message">
                                                @csrf
                                                <div
                                                    class="input_msg_write border rounded py-2 px-2 px-sm-3 d-flex align-items-center justify-content-between gap-2">
                                                    <div
                                                        class="d-flex align-items-center gap-2 py-0 h-auto form-control focus-border rounded-10">
                                                        @if( Request::is('chat/seller') )
                                                            <input type="text" id="shop-id" hidden
                                                                   value="{{$last_chat->shop_id}}" name="">
                                                            @if($last_chat->shop)
                                                                <input type="text" id="seller-id" hidden
                                                                       value="{{$last_chat->shop->seller_id}}" name="">
                                                            @endif
                                                        @elseif( Request::is('chat/delivery-man') )
                                                            <input type="text" id="delivery-man-id" hidden
                                                                   value="{{$last_chat->delivery_man_id}}" name="">
                                                        @endif
                                                        <textarea class="w-100 focus-input" id="write-message"
                                                                  placeholder="{{translate('start_a_new_message')}}"></textarea>
                                                    </div>

                                                    <button class="bg-transparent border-0" type="submit" id="message-send-button">
                                                        <i class="bi bi-send-fill fs-16 text-primary"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-center mt-5">
                                        {{ translate('no_conversation_found') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('script')
    <script src="{{ theme_asset('assets/js/chat.js') }}"></script>
@endpush


