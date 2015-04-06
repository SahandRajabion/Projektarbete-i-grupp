var is_loading = false;
var limit = 4;

$(function() {
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
            if (is_loading == false) {
                is_loading = true;
                $('#loader').show();

                $.ajax({
                    url: 'LoadMoreItems.php',
                    type: 'POST',

                    // Hämtar sista id som vi sparade undan från index.html
                    data: {last_id:last_id, limit:limit},
                    success:function(data){
                        $('#loader').hide();
                        $('#items').append(data);

                        is_loading = false;
                    }
                });
            }
       }
    });
});
<<<<<<< HEAD:Feed/js/LoadMoreItems.js
<<<<<<< HEAD:Feed/js/script.js



=======
>>>>>>> origin/master:Feed/js/LoadMoreItems.js
=======
>>>>>>> origin/master:Feed/js/LoadMoreItems.js
