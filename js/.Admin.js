// 或許可以跟register, 修改個人資料合併
$(document).ready(function () {
    // 自定義驗證方法
    $.validator.addMethod("pattern", function (value, element, param) {
        return this.optional(element) || param.test(value);
    }, "格式不正確");
    var validateNewUser = function () {
        $("#AddUserForm").validate({
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
                penName:
                {
                    required: true,
                    maxlength: 16
                },
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 16
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
                penName:
                {
                    required: "請輸入筆名",
                    maxlength: "筆名最多16個字元"
                },
                password: {
                    required: "請輸入密碼",
                    minlength: "密碼至少要6個字元",
                    maxlength: "密碼最多16個字元"
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
                    url: "admin.php",
                    data: $(form).serialize(),
                    type: "POST",
                    dataType: 'text',
                    success: function (msg) {
                        $("#message").html(msg); // 顯示訊息
                        // 等待兩秒 reset message
                        setTimeout(function () {
                            $("#message").html("");
                            if (msg.includes("成功")) {
                                console.log(msg);
                                location.reload();
                            }
                        }, 2000);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });
                return false;
            },
            errorPlacement: function (error, element) {
                var errorId = element.attr("id") + "-err";
                $('#' + errorId).html(error.text()); // 顯示錯誤訊息到<p>當中
            },
            success: function (label, element) {
                var successId = $(element).attr("id") + "-err";
                $('#' + successId).html("");// 正確就清掉 (如果原先是錯的)
            }
        });
    };
    $('#AddUserConfirm').click(function (event) {
        event.preventDefault();
        validateNewUser(); // 觸發表單驗證
        if ($("#AddUserForm").valid()) { // 如果表單驗證通過，則提交表單
            $("#AddUserForm").submit();
        }
    });
    // dataTable, 使用者列表
    $('#UserTable').DataTable({
        "ajax": ".UserDataTable_ajax.php",
        "columns": [
            { "data": "id" },
            { "data": "username" },
            { "data": "penName" },
            { "data": "email" },
            { "data": "phone" },
            { "data": "actions" }
        ],
        "language": {
            "lengthMenu": "顯示 _MENU_ 筆資料", // 客製化顯示文字
            "zeroRecords": "沒有找到符合的資料",
            "info": "顯示第 _PAGE_ 頁，共 _PAGES_ 頁",
            "infoEmpty": "沒有可用的資料",
            "infoFiltered": "(從 _MAX_ 條資料中篩選)",
            "search": "搜尋:",
            "paginate": {
                "first": "第一頁",
                "last": "最後一頁",
                "next": "下一頁",
                "previous": "上一頁"
            }
        },
        "drawCallback": function (settings) {
            // 按鈕只有一個, 翻頁時需要移除現有的
            $(".dataTables_paginate .btn-add-user").remove();
            $(".dataTables_paginate").append(`
                <button type="button" class="btn btn-primary my-3 btn-add-user" data-bs-toggle="modal" data-bs-target="#AddUserModal">
                    新增使用者
                </button>
        `);
        }
    });
    // dataTable, 商品列表
    $('#ProductTable').DataTable({
        "ajax": ".ProductDataTable_ajax.php",
        "columns": [
            { "data": "id" },
            { "data": "product_name" },
            { "data": "price" },
            { "data": "author" },
            { "data": "write_date" },
            { "data": "actions" }
        ],
        "language": {
            "lengthMenu": "顯示 _MENU_ 筆資料", // 客製化顯示文字
            "zeroRecords": "沒有找到符合的資料",
            "info": "顯示第 _PAGE_ 頁，共 _PAGES_ 頁",
            "infoEmpty": "沒有可用的資料",
            "infoFiltered": "(從 _MAX_ 條資料中篩選)",
            "search": "搜尋:",
            "paginate": {
                "first": "第一頁",
                "last": "最後一頁",
                "next": "下一頁",
                "previous": "上一頁"
            }
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const addUserModal = document.getElementById('AddUserModal');
    addUserModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const userId = button.getAttribute('data-id');
        const username = button.getAttribute('data-username');
        const penName = button.getAttribute('data-penName');
        const email = button.getAttribute('data-email');
        const phone = button.getAttribute('data-phone');
        const isAdmin = button.getAttribute('data-is_admin');

        const modalTitle = addUserModal.querySelector('.modal-title');
        const submitButton = addUserModal.querySelector('#AddUserConfirm');
        const userIdInput = addUserModal.querySelector('#user_id');
        const usernameInput = addUserModal.querySelector('#username');
        const penNameInput = addUserModal.querySelector('#penName');
        const emailInput = addUserModal.querySelector('#email');
        const phoneInput = addUserModal.querySelector('#phone');
        const isAdminInput = addUserModal.querySelector('#is_admin');

        if (userId) {
            modalTitle.textContent = '編輯使用者(密碼不會被更改)';
            submitButton.textContent = '保存變更';
            userIdInput.value = userId;
            usernameInput.value = username;
            penNameInput.value = penName;
            emailInput.value = email;
            phoneInput.value = phone;
            isAdminInput.checked = isAdmin == 1;
        } else {
            modalTitle.textContent = '新增使用者';
            submitButton.textContent = '新增使用者';
            userIdInput.value = '';
            usernameInput.value = '';
            penNameInput.value = '';
            emailInput.value = '';
            phoneInput.value = '';
            isAdminInput.checked = false;
        }
    });
});
var deleteButtons = document.getElementsByClassName('deleteButton');
for (var i = 0; i < deleteButtons.length; i++) {
    deleteButtons[i].addEventListener('click', function (e) {
        if (!confirm('確定要刪除這個使用者嗎？')) {
            e.preventDefault();
        }
    });
}