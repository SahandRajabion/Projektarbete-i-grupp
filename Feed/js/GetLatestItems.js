$(document).ready(function () {

    function checkForRemovedPosts() 
    {
        var arrayOfPostIds = $.map($(".post"), function(n, i){
            return n.id.split("post").join("");
        });

        $.ajax({
            type: "POST",
            url: "CheckForRemovedPosts.php",
            data: {arrayOfPostIds: arrayOfPostIds, course_id:course_id},              
            success: function (response) 
            {
                if (response != "") 
                {
                    var obj = response.split(",");
                    $.each(obj, function( key, value ) {
                        $('#post' + value).fadeOut("slow");
                    });
                    
                }
                setTimeout(checkForRemovedPosts, 100);
            }
        });
    }

    function getLatestComments() {
        var arrayOfCommentIds = $.map($(".comment"), function(n, i){
            return n.id.split("comment").join("");
        });

        if (arrayOfCommentIds != "") 
        { 
            var max = Math.max.apply(Math, arrayOfCommentIds);
        }
        else 
        {
            var max = 0;
        }

        $.ajax({
            type: "POST",
            url: "GetLatestComments.php",
            data: {first_comment_id:max, course_id:course_id},              
            success: function (response) {   
            
                if (response != "") {
                    var obj = JSON.parse(response);

                    var result = $.inArray(obj.commentId, arrayOfCommentIds);

                    if (result === -1) 
                    {
                        $(obj.html).hide().insertBefore('#addCommentContainer' + obj.postId).slideDown();   
                    }
                }

                setTimeout(getLatestComments, 1000);
            }
        });
    }

    function getLatestPosts() {
        var arrayOfPostIds = $.map($(".post"), function(n, i){
            return n.id.split("post").join("");
        });

        if (arrayOfPostIds != "") {
            var max = Math.max.apply(Math, arrayOfPostIds);
        }

        else 
        {
            var max = 0;
        }


        $.ajax({
            type: "POST",
            url: "GetLatestItems.php",
            data: {first_id:max, course_id:course_id},              
            success: function (response) {
                $("#items").prepend(response);

                setTimeout(getLatestPosts, 100);
            }
        });
    }

    checkForRemovedPosts();
    getLatestComments();
    getLatestPosts();
});