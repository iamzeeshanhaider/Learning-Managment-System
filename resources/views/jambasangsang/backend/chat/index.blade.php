@extends('layouts.backend.master')
@section('content')
    <div class="row">
        <div class="col-md-12 ">
            <div class="">
                <div class="chat-window">
                    <div class="chat-window-content">
                        @include('jambasangsang.backend.chat.messages')
                    </div>
                    <div class="send-message-box">
                        @include('jambasangsang.backend.chat.send_message')
                    </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        /* body {
                    overflow: hidden;
                } */

        .chat-window {
            position: relative;
            height: 90vh;
        }

        .send-message-box {
            position: absolute;
            bottom: 0;
            margin-bottom: 20px;
            width: 100%;
            /* set your desired spacing here */
        }

        .chat-window-content {
            height: calc(100vh - 150px);
            overflow-y: scroll;
            padding: 2em;
        }

        .chat-window-content::-webkit-scrollbar {
            display: none;
        }

        .text-box-send-message {
            height: 80px;
            resize: none;
            /* Optional - disable resizing */
        }
    </style>


    <script>
        $(document).ready(function() {
            var element = $('body');
            var target = $('.chat-window-content, .send-message-box');

            target.hover(function() {
                element.css('overflow', 'hidden');
            }, function() {
                element.css('overflow', 'auto');
            });
        });
    </script>
@endsection
