var is_loading = false;
var limit = 4;

$(function() {
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
            if (is_loading == false) {
                is_loading = true;
                $('#loader').show();

                var arrayOfPostIds = $.map($(".post"), function(n, i){
                    return n.id.split("post").join("");
                });
                
                var min = Math.min.apply(Math, arrayOfPostIds);

                $.ajax({
                    url: 'LoadMoreItems.php',
                    type: 'POST',

                    // Hämtar sista id som vi sparade undan från index.html
                    data: {last_id:min, limit:limit, course_id:course_id},
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
