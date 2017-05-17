$(document).ready(function() {

    var socket = io.connect('https://jomari-chat.herokuapp.com:49190');

    socket.on('notification', function (data) {

        var message = JSON.parse(data);

        $( "#notifications" ).prepend( "<p><strong>" + message.name + "</strong>: " + message.message + "</p>" );

    });

});
