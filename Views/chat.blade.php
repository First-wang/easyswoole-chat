@extends('base')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-md-2 mt-3">
                {{--<div><button id="add-room" class="bg-light">创建房间</button></div>--}}

                @if (isset($rooms))
                    <ul id="room-list">

                        @foreach ($rooms as $key => $room_name)
                            <li id="room-1">
                                <a href="/start?user_name={{ $user_name }}&room_id={{ $key }}">{{ json_decode($room_name, true)['name'] }}</a>
                                @if ($key == $current_room_id)
                                    <span>***</span>
                                @endif
                            </li>
                        @endforeach

                    </ul>
                @endif
            </div>

            <div class="col-md-8 bg-info overflow-auto mt-3" style="height: 550px">
                <div>
                    <input type="text" class="form-control" id="input-msg">
                </div>

                <div id="content" class="bg-secondary mt-1"></div>
            </div>

        </div>
    </div>

@endsection

@section('footer')
    <script>
        $(function () {
            var user_name = '{{ $user_name }}';

            var room_id = '{{ $current_room_id }}';

            var wsServer = 'ws://192.168.103.115:9501?user_name=' + user_name + '&room_id=' + room_id;

            var websocket = new WebSocket(wsServer);
            window.onload = function () {
                websocket.onopen = function (evt) {
                    // addLine("Connected to WebSocket server.");
                };
                websocket.onclose = function (evt) {
                    // addLine("Disconnected");
                };
                websocket.onmessage = function (evt) {
                    // addLine('Retrieved data from server: ' + evt.data);

                    msg = JSON.parse(evt.data);
                    str = '<div><p><span>' + msg.user_name + ':</span>' + msg.message + '</p></div>'
                    $("#content").append(str)

                };
                websocket.onerror = function (evt, e) {
                    // addLine('Error occured: ' + evt.data);
                };
            };

            $("#input-msg").bind('keypress', function (event) {
                if (event.keyCode == "13") {
                    message = $(this).val()
                    param = JSON.stringify({
                        class: 'Chat',
                        action: 'sendMsg',
                        content: {
                            room_id: room_id,
                            message: message
                        }
                    })
                    websocket.send(param)
                    $(this).val('')
                }
            })
        })

    </script>
@stop
