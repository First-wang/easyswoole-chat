$(function () {

    // var wsServer = 'ws://127.0.0.1:9501';
    var websocket = new WebSocket(wsServer);
    window.onload = function () {
        websocket.onopen = function (evt) {
            addLine("Connected to WebSocket server.");
        };
        websocket.onclose = function (evt) {
            // addLine("Disconnected");
        };
        websocket.onmessage = function (evt) {
            // addLine('Retrieved data from server: ' + evt.data);

            msg = evt.data

            str = '<div class="bg-light"><p>' + msg + '</p></div>'

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
                    name: uuid,
                    message: message
                }
            })

            websocket.send(param)

            $(this).val('')
        }
    })



})
