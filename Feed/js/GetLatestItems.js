$(document).ready(function () {

    function getLatest() {

        $.ajax({
            type: "POST",
            url: "GetLatestItems.php",
            data: {first_id:first_id},              
            success: function (response) {
                $("#items").prepend(response);

                setTimeout(getLatest, 500);
            }
        });
    }

    getLatest();
});