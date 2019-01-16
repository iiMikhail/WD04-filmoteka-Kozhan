$(document).ready(function() {
$('#error').hide();
var film = (function(){
    var init = function(){
        _setUpListeners();
    }
    var _setUpListeners = function() {
        $('.newFilm').on('click', function(event) {
            validate(event);
        });
    }
    var validate = function(event) {
        if( $('film-name').val().trim() == '' ) {
            event.preventDefault();
            $('#error').show();
        }
    }
    return {
        init
    }
}());
film.init();
});