function Message( message,alert) {
    $('#test').html('<div id="Message"><div  class="alert ' + alert + ' fade-message" style=" text-align: center;" id="MessageText">' + message + '</div></div>');
    setTimeout(function () {
        $("#Message").hide('blind', {}, 800)
    }, 2000);
}
