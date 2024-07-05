<div>
    {{-- Care about people's approval and you will be their prisoner. --}}

    <div class="chatlist_header">

        <div class="title">
            Chat
        </div>

        <div class="img_container">
            <img src="https://ui-avatars.com/api/?background=0D8ABC&color=fff&name={{auth()->user()->name}}" alt="">
        </div>
    </div>

    <div class="chatlist_body">
 
        @if (count($conversations) > 0)
            @foreach ($conversations as $conversation)
                <div class="chatlist_item " wire:key='{{$conversation->id}}' wire:click="$emit('chatUserSelected', {{$conversation}},{{$this->getChatUserInstance($conversation, $name = 'id') }})">
                    <div class="chatlist_img_container">

                        <img src="https://ui-avatars.com/api/?name={{$this->getChatUserInstance($conversation, $name = 'name')}}"
                            alt="">
                    </div>

                    <div class="chatlist_info">
                        <div class="top_row">
                            <div class="list_username">{{ $this->getChatUserInstance($conversation, $name = 'name') }}
                            </div>
                            <span class="date">
                                {{ $conversation->messages->last()?->created_at->shortAbsoluteDiffForHumans() }}</span>
                        </div>

                        <div class="bottom_row">

                            <div class="message_body text-truncate">
                                {{-- {{ $conversation->messages->last()->body }} --}}
                            </div>

                            @php
                                if(count($conversation->messages->where('read',0)->where('receiver_id',Auth()->user()->id))){

                             echo ' <div class="unread_count badge rounded-pill text-light bg-danger">  '
                                 . count($conversation->messages->where('read',0)->where('receiver_id',Auth()->user()->id)) .'</div> ';

                                }

                            @endphp

                        </div>
                    </div>
                </div>
            @endforeach
        @else
            you have no conversations
        @endif

    </div>
</div>



<style>
    /* variables */
:root {
  --header-height: 60px;
  --footer-height: 60px;
  --base-color: #0484f3;
}

.msg_body_me {
  background-color: rgb(238, 238, 238);
  margin-left: auto;
  color: black;
  border-bottom-right-radius: 0 !important;
}
.msg_body_me .read {
  color: rgb(27, 27, 27);
}

.msg_body_receiver {
  background-color: #075ece;
  color: rgb(255, 255, 255);
  border-bottom-left-radius: 0 !important;
}
.msg_body_receiver .read {
  color: rgb(204, 204, 204);
}

/* chat container */
/* --------------------------- */
img {
  object-fit: cover;
}


.chat_container {
  position: fixed;
  width: 80%;
  left: 25;
  top: 0;
  height: 100%;
  border: 1px solid rgb(243, 242, 242);
  border-radius: 0;
  margin-top: 0;
  display: flex;
  flex-wrap: wrap;
  padding: 5px 6px;
  z-index: 10;
  background-color: #fff;
}

@media (min-width: 768px) {
  .chat_container {
    top: unset;
    height: 90%;
  }
}

@media (min-width: 1024px) {
  .chat_container {
    position: fixed;
    width: 78%;
    left: 21%;
    height: 80%;
    border: 1px solid rgb(202, 202, 202);
    border-radius: 9px;
    margin-top: 15px;
  }
}

/* chat list */
/* --------------------------- */
.chat_list_container {
  border-right: 0;
  width: 100%;
  height: 100%;
  border-radius: inherit;
}

@media (min-width: 768px) {
  .chat_list_container {
    width: 310px;
    border-right: 1px solid rgb(226, 226, 226);
  }
}

/* chat list header */
.chatlist_header {
  border-bottom: 1px solid rgb(196, 194, 194);
  height: var(--header-height);
  display: flex;
  flex-wrap: nowrap;
}

.chatlist_header .title {
  font-size: 22px;
  display: flex;
  padding: 5px 6px;
  align-items: center;
  justify-content: center;
  text-align: center;
}

.chatlist_header .img_container {
  height: 39px;
  width: 39px;
  margin: auto;
  margin-left: auto;
  margin-right: 5px;
}

.chatlist_header .img_container img {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  border: 1px solid rgba(55, 101, 202, 0.726);
}

.chatlist_body .chatlist_item {
  padding: 2px 8px;
  display: flex;
  flex-wrap: nowrap;
  width: 96%;
  margin: 9px 4px;
  border-radius: 14px;
  background-color: rgb(241, 241, 241);
  cursor: pointer;
}
.chatlist_body .chatlist_item:hover {
  background-color: darken(rgb(231, 231, 231), 4%);
}
.chatlist_body .chatlist_item .chatlist_img_container {
  height: 47px;
  width: 47px;
  margin: auto;
  margin-left: auto;
}
.chatlist_body .chatlist_item .chatlist_img_container img {
  width: 100%;
  height: 100%;
  border-radius: 50%;
}
.chatlist_body .chatlist_item .chatlist_info {
  padding: 2px 5px;
  width: 80%;
  display: block;
}
.chatlist_body .chatlist_item .chatlist_info .top_row {
  margin: 3px 0px;
  width: 100%;
  display: flex;
}
.chatlist_body .chatlist_item .chatlist_info .top_row .list_username {
  font-size: 16px;
  width: 80%;
}
.chatlist_body .chatlist_item .chatlist_info .top_row .date {
  font-size: 13px;
  margin-left: auto;
  margin-right: 3px;
}
.chatlist_body .chatlist_item .chatlist_info .bottom_row {
  display: flex;
  flex-wrap: nowrap;
  width: 100%;
}
.chatlist_body .chatlist_item .chatlist_info .bottom_row .message_body {
  width: 80%;
  font-weight: lighter;
  font-family: "Roboto";
}
.chatlist_body .chatlist_item .chatlist_info .bottom_row .unread_count {
  margin-left: auto;
  font-size: 13px;
  padding: 2px 7px;
  margin-top: 6px;
  border-radius: 50%;
  color: rgb(255, 0, 0);
  font-weight: lighter;
}
.chat_box_container {
  position: relative;
  display: block;
  width: 100%;
  height: 100%;
}

@media screen and (min-width: 768px) {
  .chat_box_container {
    width: calc(100% - 310px);
  }
}

.chat_box_container .chatbox_header {
  width: 100%;
  position: absolute;
  top: 0;
  border-bottom: 1px solid rgba(219, 219, 219, 0.952);
  height: 60px;
  display: flex;
  flex-wrap: nowrap;
}

.chat_box_container .chatbox_header .img_container {
  height: 41px;
  width: 41px;
  margin: auto 0;
  margin-left: 4px;
}

.chat_box_container .chatbox_header .img_container img {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  border: 1px solid lighten($color: $base_color, $amount: 48%);
}

.chat_box_container .chatbox_header .return {
  margin: auto 0;
  font-size: 21px;
  padding: 7px 11px;
  cursor: pointer;
  color: rgb(128, 128, 128);
}

.chat_box_container .chatbox_header .name {
  margin: auto 5px;
  cursor: pointer;
  color: rgb(61, 61, 61);
  font-weight: lighter;
}

.chat_box_container .chatbox_header .info {
  display: flex;
  flex-wrap: nowrap;
  margin: auto 0 auto auto;
  color: #0182f4;
  font-size: 19px;
}

.chat_box_container .chatbox_header .info .info_item {
  margin: 1px 11px;
  padding: 3px 5px;
  padding: 4px 7px;
  cursor: pointer;
}

.chat_box_container .chatbox_header .info .info_item:hover {
  color: lighten($color: $base_color, $amount: 18%);
}

.chat_box_container .chatbox_body {
  overflow: hidden;
  overflow-y: scroll;
  width: 100%;
  position: absolute;
  top: 60px;
  height: 77%;
  bottom: $footer_height + 3px;
  padding: 17px 26px;
}

.chat_box_container .chatbox_body .msg_body {
  border-radius: 15px;
  display: block;
  max-width: 80%;
  margin-top: 11px;
  font-size: 16.6px;
  padding: 4px 12px;
  font-weight: normal;
}

.chat_box_container .chatbox_body .msg_body .msg_body_footer {
  width: 100%;
  display: flex;
  justify-content: flex-end;
  align-items: right;
  font-weight: normal;
  font-family: "Roboto";
}

.chat_box_container .chatbox_body .msg_body .msg_body_footer .date {
  font-size: 13px;
  padding-right: 7px;
}

.chat_box_container .chatbox_body .msg_body .msg_body_footer .read i {
  font-size: 21px;
  margin: 2px;
}
.chat_box_container .chatbox_footer {
  height: 90px;
  width: 100%;
  border-top: 1px solid rgb(233, 233, 233);
  position: absolute;
  bottom: 0;
  display: flex;
  flex-wrap: nowrap;
  background-color: white;
}

.chat_box_container .chatbox_footer .custom_form_group {
  margin: auto 0;
  display: flex;
  flex-wrap: nowrap;
  width: 100%;
  padding: 2px 6px;
}

.chat_box_container .chatbox_footer .custom_form_group .control {
  margin: auto 0;
  width: 100%;
  border: 0;
  min-height:85px;
  outline: none;
  box-shadow: 0;
  background-color: rgba(226, 226, 226, 0.87);
  border-radius: 11px;
  padding: 5px
}

.chat_box_container .chatbox_footer .custom_form_group .control:focus {
  box-shadow: none;
  outline: none;
  border-style: 0;
}


</style>
