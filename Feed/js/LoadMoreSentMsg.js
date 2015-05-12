var is_loading = false;
var limit = 4;

$(function() {
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
            if (is_loading == false) {
                is_loading = true;
                $('#loader').show();

                var arrayOfMessageIds = $.map($(".msg"), function(n, i){
                    return n.id.split("msg").join("");
                });
                
                var min = Math.min.apply(Math, arrayOfMessageIds);
               
                $.ajax({
                    url: 'LoadMoreSentMsg.php',
                    type: 'POST',
 
                    // Hämtar sista id som vi sparade undan från index.html
                    data: {last_id:min, limit:limit, user_id:user_id},

                    success:function(data){
                        $('#loader').hide();
                        $('#msg').append(data);

                        is_loading = false;
                    }
                });
            }
       }
    });
});
