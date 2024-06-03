$(document).ready(function () {
    $("form").on("submit", function (event) {
        event.preventDefault();
        $.ajax({
            url: "login_action.php",
            data: $(this).serialize(),
            type: "POST",
            dataType: 'text',
            success: function (msg) {
                if (msg == "登入成功") {
                    window.location.href = 'index.php';
                    exit;
                }
                else
                    $("#message").html(msg); // 顯示訊息
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
        return false;
    });
});