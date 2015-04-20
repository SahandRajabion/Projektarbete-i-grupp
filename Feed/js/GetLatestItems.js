$(document).ready(function () {

    function getLatestComments() {
        $.ajax({
            type: "POST",
            url: "GetLatestComments.php",
            data: {first_comment_id:first_comment_id},              
            success: function (response) {
                if (response != "") {
                    var obj = JSON.parse(response);
                    $(obj.html).hide().insertBefore('#addCommentContainer' + obj.postId).slideDown();
                }
        
                setTimeout(getLatestComments, 500);
            }
        });
    }

    function getLatestPosts() {

        $.ajax({
            type: "POST",
            url: "GetLatestItems.php",
            data: {first_id:first_id},              
            success: function (response) {
                $("#items").prepend(response);

                setTimeout(getLatestPosts, 500);
            }
        });
    }

    getLatestComments();
    getLatestPosts();
});