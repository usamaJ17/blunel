@extends('layouts.back-end.app')

@section('title',translate('chatting_Page'))

@section('content')
    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/support-ticket.png')}}" alt="">
                {{translate('chatting_List')}}
            </h2>
        </div>
        <div class="row">
            @if(isset($chattingUser))
                <div class="col-xl-3 col-lg-4 chatSel">
                    <div class="card card-body px-0 h-100">
                        <div class="media align-items-center px-3 gap-3 mb-4">
                            <div class="avatar avatar-sm avatar-circle">
                                <img class="avatar-img" src="{{getValidImage(path: 'storage/app/public/admin/'.auth('admin')->user()->image,type: 'backend-profile')}}" alt="{{translate('image_description')}}">
                                <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                            </div>
                            <div class="media-body">
                                <h5 class="profile-name mb-1">{{ auth('admin')->user()->name }}</h5>
                                <span class="fz-12">{{translate('super_admin')}}</span>
                            </div>
                        </div>

                        <div class="inbox_people">
                            <form class="search-form px-3" id="chat-search-form">
                                <div class="search-input-group">
                                    <i class="tio-search search-icon" aria-hidden="true"></i>
                                    <input
                                        class=""
                                        id="myInput" type="text"
                                        placeholder="{{translate('search_delivery_man')}}..."
                                        aria-label="Search customers...">
                                </div>
                            </form>
                            <div class="inbox_chat d-flex flex-column mt-1">
                                @foreach($chattingUser as $key => $chatting)
                                    <div class="list_search">
                                        <div class="chat_list p-3 d-flex gap-2 messageView user_{{$chatting->delivery_man_id}} seller-list @if ($key == 0) active @endif"
                                             data-user_id="{{ $chatting->delivery_man_id }}" data-name="{{$chatting->f_name}} {{$chatting->l_name}}" data-phone="{{ $chatting->phone }}" data-image="{{ getValidImage(path: 'storage/app/public/delivery-man/'.$chatting->image,type:'backend-profile') }}">
                                            <div class="chat_people media gap-10" id="chat_people">
                                                <div class="chat_img avatar avatar-sm avatar-circle">
                                                    <img src="{{ getValidImage(path: 'storage/app/public/delivery-man/'.$chatting->image , type: 'backend-profile') }}"
                                                         alt="">
                                                    <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                                                </div>
                                                <div class="chat_ib media-body">
                                                    <h5 class="mb-1 seller @if($chatting->seen_by_admin)active-text @endif"
                                                        id="{{$chatting->delivery_man_id}}" data-name="{{$chatting->f_name}} {{$chatting->l_name}}" data-phone="{{ $chatting->phone }}">
                                                        {{$chatting->f_name}} {{$chatting->l_name}}
                                                        <br><span class="mt-2 font-weight-normal text-muted" id="{{$chatting->delivery_man_id}}" data-name="{{$chatting->f_name}} {{$chatting->l_name}}" data-phone="{{ $chatting->phone }}">{{ $chatting->phone }}</span>
                                                    </h5>
                                                </div>
                                            </div>

                                            @if($chatting->seen_by_admin == 0)
                                                <div class="message-status bg-danger" id="notif-alert-{{ $chatting->delivery_man_id }}"></div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <section class="col-xl-9 col-lg-8 mt-4 mt-lg-0">
                    <div class="card card-body card-chat justify-content-between Chat">
                        <div class="inbox_msg_header d-flex flex-wrap gap-3 justify-content-between align-items-center border px-3 py-2 rounded mb-4">
                            <div class="media align-items-center gap-3">
                                <div class="avatar avatar-sm avatar-circle">
                                    <img class="avatar-img" id="profile_image"
                                         src="{{ getValidImage(path: 'storage/app/public/delivery-man/'.$chattingUser[0]->image , type: 'backend-profile') }}" alt="{{('image_description')}}">
                                    <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                                </div>
                                <div class="media-body">
                                    <h5 class="profile-name mb-1" id="profile_name">{{ $chattingUser[0]->f_name.' '.$chattingUser[0]->l_name }}</h5>
                                    <span class="fz-12" id="profile_phone">{{ $chattingUser[0]->phone }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="messaging">
                            <div class="inbox_msg">
                                <div class="mesgs">
                                    <div class="msg_history d-flex flex-column-reverse pr-2 overflow-x-hidden" id="show_msg">
                                        @foreach($chattings as $key => $message)
                                               @if ($message->sent_by_delivery_man)
                                                <div class="incoming_msg">
                                                    <div class="received_msg">
                                                        <div class="received_withdraw_msg">
                                                            @if($message->message)
                                                            <div class="d-flex justify-content-start">
                                                                <p class="bg-chat rounded px-3 py-2 mb-1 w-max-content">
                                                                    {{$message->message}}
                                                                </p>
                                                            </div>
                                                            @endif
                                                            @if (json_decode($message['attachment']) !=null)
                                                                <div class="row g-2 flex-wrap pt-1">
                                                                    @foreach (json_decode($message['attachment']) as $index => $photo)
                                                                        <div class="col-sm-3 col-md-2 position-relative img_row{{$index}}">
                                                                            <a data-lightbox="mygallery" href="{{asset("storage/app/public/chatting/".$photo)}}"
                                                                               class="aspect-1 overflow-hidden d-block border rounded">
                                                                                <img src="{{ getValidImage(path: 'storage/app/public/chatting/'.$photo, type: 'backend-basic') }}"
                                                                                     alt="" class="img-fit">
                                                                            </a>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                            <span class="time_date fz-12 pt-2 d-flex justify-content-start"> {{$message->created_at->format('h:i A')}}    |    {{$message->created_at->format('M d')}} </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="outgoing_msg">
                                                    <div class="sent_msg p-2">
                                                        @if($message->message)
                                                        <div class="d-flex justify-content-end">
                                                            <p class="bg-c1 text-white rounded px-3 py-2 mb-1 w-max-content">
                                                                {{$message->message}}
                                                            </p>
                                                        </div>
                                                        @endif

                                                        @if (json_decode($message['attachment']) !=null)
                                                            <div class="row g-2 flex-wrap pt-1 justify-content-end">
                                                                @foreach (json_decode($message['attachment']) as $index => $photo)
                                                                    <div class="col-sm-3 col-md-2 position-relative img_row{{$index}}">
                                                                        <a data-lightbox="mygallery" href="{{asset("storage/app/public/chatting/".$photo)}}"
                                                                           class="aspect-1 overflow-hidden d-block border rounded">
                                                                            <img src="{{ getValidImage(path: 'storage/app/public/chatting/'.$photo, type: 'backend-basic') }}"
                                                                                 alt="" class="img-fit">
                                                                        </a>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif

                                                        <span class="time_date fz-12 pt-2 d-flex justify-content-end"> {{$message->created_at->format('h:i A')}}    |    {{$message->created_at->format('M d')}} </span>
                                                    </div>
                                                </div>
                                            @endif
                                        @endForeach


                                        @if (count($chattings) == 0)
                                            <div class="d-flex flex-column justify-content-center align-items-center vh-100">
                                                <img src="{{ asset('public/assets/back-end/img/icons/nodata.svg') }}" alt="">
                                                <h4 class="text-muted py-4">{{ translate('Inbox_Empty') }}</h4>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="type_msg">
                                        <div class="input_msg_write">
                                            <form class="mt-4" id="myForm">
                                                @csrf
                                                <input type="text" id="hidden_value" hidden
                                                       value="{{$lastChat->delivery_man_id}}" name="delivery_man_id">
                                                <div class="position-relative d-flex align-items-center">
                                                    @if(theme_root_path() == "default")
                                                    <label class="py-0 px-3 d-flex align-items-center m-0 cursor-pointer position-absolute">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                                            <path d="M18.1029 1.83203H3.89453C2.75786 1.83203 1.83203 2.75786 1.83203 3.89453V18.1029C1.83203 19.2395 2.75786 20.1654 3.89453 20.1654H18.1029C19.2395 20.1654 20.1654 19.2395 20.1654 18.1029V3.89453C20.1654 2.75786 19.2395 1.83203 18.1029 1.83203ZM3.89453 3.20703H18.1029C18.4814 3.20703 18.7904 3.51595 18.7904 3.89453V12.7642L15.2539 9.2277C15.1255 9.09936 14.9514 9.02603 14.768 9.02603H14.7653C14.5819 9.02603 14.405 9.09936 14.2776 9.23136L10.3204 13.25L8.65845 11.5945C8.53011 11.4662 8.35595 11.3929 8.17261 11.3929C7.9957 11.3654 7.81053 11.4662 7.6822 11.6009L3.20703 16.1705V3.89453C3.20703 3.51595 3.51595 3.20703 3.89453 3.20703ZM3.21253 18.1304L8.17903 13.0575L13.9375 18.7904H3.89453C3.52603 18.7904 3.22811 18.4952 3.21253 18.1304ZM18.1029 18.7904H15.8845L11.2948 14.2189L14.7708 10.6898L18.7904 14.7084V18.1029C18.7904 18.4814 18.4814 18.7904 18.1029 18.7904Z" fill="#1455AC"/>
                                                            <path d="M8.12834 9.03012C8.909 9.03012 9.54184 8.39728 9.54184 7.61662C9.54184 6.83597 8.909 6.20312 8.12834 6.20312C7.34769 6.20312 6.71484 6.83597 6.71484 7.61662C6.71484 8.39728 7.34769 9.03012 8.12834 9.03012Z" fill="#1455AC"/>
                                                        </svg>
                                                        <input type="file" id="msgfilesValue" class="h-100 position-absolute w-100 " hidden multiple accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                    </label>
                                                    @endif

                                                    <textarea class="form-control {{ theme_root_path() == "default" ? 'pl-8':'' }}" id="msgInputValue" name="message"
                                                              type="text" placeholder="{{translate('send_a_message')}}"
                                                              aria-label="Search"></textarea>
                                                </div>


                                                <div class="mt-3 d-flex justify-content-between">
                                                    <div class="">
                                                        <div class="d-flex gap-3 flex-wrap filearray"></div>
                                                        <div id="selected-files-container"></div>
                                                    </div>

                                                    <div>
                                                        <button class="aSend btn btn--primary" type="submit" id="msgSendBtn">{{translate('send_Reply')}}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </section>

            @else
                <div class="offset-md-1 col-md-10 d-flex justify-content-center align-items-center">
                    <p>{{translate('no_conversation_found')}}</p>
                </div>
            @endif

        </div>
    </div>

    <span id="chatting-post-url" data-url="{{ route('admin.delivery-man.ajax-admin-message-store') }}"></span>
    <span id="deliveryman-get-url" data-url="{{ route('admin.delivery-man.ajax-message-by-delivery-man') }}"></span>
    <span id="image-url" data-url="{{ asset('storage/app/public/chatting') }}"></span>
    <span id="onerror-image-url" data-url="{{ asset('public/assets/back-end/img/image-place-holder.png') }}"></span>
@endsection

@push('script')
    <script src="{{asset('public/assets/back-end/js/admin/chatting.js')}}"></script>
@endpush

