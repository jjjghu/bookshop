// 註冊密碼驗證 
function checkPassword(checkIcon, passwordCheck, passwordBox) {
    if (passwordBox.value === passwordCheck.value && passwordBox.value.length >= 6 && passwordBox.value.length <= 16) {
        checkIcon.className = 'bx bx-check icon-left';
        checkIcon.style.color = 'yellowgreen';
        passwordCheck.style.border = '2px solid yellowgreen';
    } else {
        checkIcon.className = 'bx bx-x icon-left';
        checkIcon.style.color = 'var(--jjjghu-orange)';
        passwordCheck.style.border = '2px solid var(--jjjghu-orange)';
    }
    // 主控台輸出兩者的數值
    // console.log(passwordBox.value, passwordCheck.value, passwordBox.value === passwordCheck.value && passwordBox.value != "");
}
// 密碼顯示與隱藏
document.addEventListener('DOMContentLoaded', () => {
    // 顯示輸入密碼
    var passwordIcon = document.getElementById('passwordIcon');
    if (passwordIcon) {
        passwordIcon.onclick = function () {
            var enter = document.getElementById('password');
            if (enter) {
                if (enter.type === 'password') {
                    enter.type = 'text';
                    passwordIcon.className = 'bx bx-show icon-right';
                } else {
                    enter.type = 'password';
                    passwordIcon.className = 'bx bx-hide icon-right';
                }
            }
        };
    }
    // 停用複製貼上
    var passwordBox = document.getElementById('password');
    var passwordCheck = document.getElementById('passwordCheck');

    if (passwordCheck) passwordCheck.style.border = '2px solid var(--jjjghu-orange)';
    [passwordBox, passwordCheck].forEach(function (element) {
        if (element) {
            element.addEventListener('paste', function (e) {
                e.preventDefault();
            });
            element.addEventListener('copy', function (e) {
                e.preventDefault();
            });
        }
    });
    // 綁定檢查的內容
    var checkIcon = document.getElementById('check-icon');
    var passwordBox = document.getElementById('password');
    var passwordCheck = document.getElementById('passwordCheck');
    if (passwordBox && passwordCheck) {
        passwordBox.addEventListener('input', () => checkPassword(checkIcon, passwordCheck, passwordBox));
        passwordCheck.addEventListener('input', () => checkPassword(checkIcon, passwordCheck, passwordBox));
    }
});
// 表單驗證 + Ajax 更新
$(document).ready(function () {
    // 自定義驗證方法
    $.validator.addMethod("pattern", function (value, element, param) {
        return this.optional(element) || param.test(value);
    }, "格式不正確");
    // 表單驗證
    $("#RegisterForm").validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
            username: {
                required: true,
                minlength: 4,
                maxlength: 16,
                pattern: /^[a-zA-Z0-9]+$/
            },
            password: {
                required: true,
                minlength: 6,
                maxlength: 16
            },
            passwordCheck: {
                required: true,
                minlength: 6,
                maxlength: 16,
                equalTo: "#password"
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10
            }
        },
        messages: {
            username: {
                required: "請輸入使用者名稱",
                minlength: "使用者名稱至少要4個字元",
                maxlength: "使用者名稱最多16個字元",
                pattern: "使用者名稱只能包含英文和數字"
            },
            password: {
                required: "請輸入密碼",
                minlength: "密碼至少要6個字元",
                maxlength: "密碼最多16個字元"
            },
            passwordCheck: {
                required: "請再次輸入密碼",
                minlength: "密碼至少要6個字元",
                maxlength: "密碼最多16個字元",
                equalTo: "兩次密碼輸入不一致"
            },
            email: {
                required: "請輸入電子郵件",
                email: "請輸入正確的電子郵件"
            },
            phone: {
                required: "請輸入手機號碼",
                digits: "手機號碼為數字",
                minlength: "手機號碼為10個數字",
                maxlength: "手機號碼為10個數字"
            }
        },
        submitHandler: function (form) {
            $.ajax({
                url: "register_action.php",
                data: $(form).serialize(),
                type: "POST",
                dataType: 'text',
                success: function (msg) {
                    if (msg == "註冊成功") {
                        window.location.href = 'login.php';
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
        },
        errorPlacement: function (error, element) {
            var errorId = element.attr("id") + "-err";  // 根據元素ID獲取錯誤信息的ID
            $('#' + errorId).html(error.text());  // 顯示錯誤訊息到<p>當中
        },
        success: function (label, element) {
            var successId = $(element).attr("id") + "-err";
            $('#' + successId).html(" ");
        },
    });

    $('#submitButton').click(function (event) {
        event.preventDefault(); // 阻止表單提交
        if ($("#RegisterForm").valid()) {  // 如果表單驗證通過，則提交表單
            $("#RegisterForm").submit();
        }
    });
});