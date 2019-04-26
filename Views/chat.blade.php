@extends('base')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-md-3 mt-3">

                <p>
                    <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        创建房间（如果没房间请先创建)
                    </a>
                </p>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                        <form action="/rooms?user_name={{ $user_name }}" method="POST">
                            <div class="form-group">
                                <label for="exampleInputEmail1">房间名称:</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" name="room_name">
                            </div>
                            <button type="submit" class="btn btn-primary">创建房间</button>
                        </form>
                    </div>
                </div>

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

            <div class="col-md-8 mt-3">

                @if ($current_room_id != '')
                    <div class="container overflow-auto bg-light" style="height: 550px">
                        <div class="raw align-items-start">
                            <div id="content" class="mt-1">
                                <p>开始骚聊吧！！！</p>
                            </div>
                        </div>
                    </div>
                    <div class="raw align-items-end">
                        <div>
                            <input type="text" class="form-control" id="input-msg" placeholder="回车发送">
                        </div>
                    </div>
                @endif


            </div>
        </div>
    </div>

@endsection

@section('footer')
    <script>
        $(function () {
            var user_name = '{{ $user_name }}';

            var room_id = '{{ $current_room_id }}';

            var wsServer = 'ws://127.0.0.1:9501?user_name=' + user_name + '&room_id=' + room_id;

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

                    $("#content").scrollTop($("#content")[0].scrollHeight);

                };
                websocket.onerror = function (evt, e) {
                    // addLine('Error occured: ' + evt.data);
                };
            };

            $("#input-msg").bind('keypress', function (event) {
                if (event.keyCode == "13") {

                    message = $(this).val()

                    if (message == '') {
                        return ;
                    }
                    if (room_id == '') {
                        console.log(11111);
                        return ;
                    }
                    if (room_id == 'room:') {
                        console.log(22222);
                        return ;
                    }

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
