// edit_product_id// 調整文章高度
function adjustTextareaHeight() {
    textarea.style.height = 'auto';
    const scrollHeight = textarea.scrollHeight;
    textarea.style.height = Math.min(scrollHeight, 600) + 'px';
    console.log("adjust!");
}
// 輸入框按下之後顯示對話
function openModal() {
    // 顯示 modal
    var modal = new bootstrap.Modal(document.getElementById('editbioModal'));
    modal.show();
}
document.addEventListener('DOMContentLoaded', function () {
    // 輸入框高度自適應
    const editContext = document.getElementById('edit_articleContent')
    const addContext = document.getElementById('add_articleContent');
    if (editContext) {
        editContext.addEventListener('input', adjustTextareaHeight);
    }
    else console.log("can't find edit_articleContent");
    if (addContext) {
        addContext.addEventListener('input', adjustTextareaHeight);
    }
    else console.log("can't find add_articleContent");
    // 簡介區塊點擊後顯示對話框 (textarea)
    var bio = document.getElementById('bio');
    if (bio) {
        // 加入() = 觸發一次
        bio.onclick = openModal;
    }
    else console.log("can't find intro");
    // .EditArticleModal 當中, 防止上傳圖片
    document.getElementById('editArticle').addEventListener('submit', function (event) {
        var files = document.getElementById('fileUpload').files;
        for (var i = 0; i < files.length; i++) {
            if (!files[i].type.startsWith('image/')) {
                alert('只能上傳圖片檔!');
                event.preventDefault();
                return;
            }
        }
    });
});
// 日期選擇器
var edit_write_date = document.getElementById('edit_write_date');
document.getElementById('edit_toggleDate').addEventListener('click', function () {
    edit_write_date.showPicker();
});
var add_write_date = document.getElementById('add_write_date');
document.getElementById('add_toggleDate').addEventListener('click', function () {
    add_write_date.showPicker();
});
// 新增驗證方法
// $.validator.addMethod("notEqualTo", function (value, element, param) {
//     return this.optional(element) || value != $(param).val();
// }, "新密碼不能與舊密碼相同");
// 從資料庫讀取很麻煩, 擱置
$(document).ready(function () {
    //自定義驗證方法
    $.validator.addMethod("pattern", function (value, element, param) {
        return this.optional(element) || param.test(value);
    }, "格式不正確");
    var validateProfile = function () {
        $("#EditProfile").validate({
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
                    maxlength: 10
                },
                newpassword: {
                    required: false,
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
                newpassword: {
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
                    url: ".EditProfile.php",
                    data: $(form).serialize(), // 確保選擇器正確
                    type: "POST",
                    dataType: 'text',
                    success: function (msg) {
                        // $('#EditConfirm').html(msg);
                        $('#message').html(msg);
                        // 經過2秒之後恢復原狀
                        setTimeout(function () {
                            $('#message').html("");
                            // reload 頁面
                            location.reload();
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
    $('#EditConfirm').click(function (event) {
        event.preventDefault();
        validateProfile(); // 觸發表單驗證
        if ($("#EditProfile").valid()) { // 如果表單驗證通過，則提交表單
            $("#EditProfile").submit();
        }
    });
});
$(document).ready(function () {
    $('.edit').on('click', function () {
        const productId = $(this).data('product-id');
        fetchProductData(productId);
    });
});

function fetchProductData(productId) {
    $.ajax({
        url: 'fetchProductData.php',
        type: 'POST',
        data: { product_id: productId },
        dataType: 'json',
        success: function (data) {
            // console.log(data.product.id);
            if (data.success) {
                // 將資料填滿 modal 
                $('#edit_product_id').val(productId);
                $('#edit_product_name').val(data.product.product_name);
                $('#edit_price').val(data.product.price);
                $('#edit_write_date').val(data.product.write_date);
                $('#edit_articleContent').val(data.product.intro);
                $('#edit_description').val(data.product.detail);
                // 需要 catogorie_id
                $('#edit_category_id').val(data.product.category_ids);
            } else {
                alert('獲取商品失敗');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('AJAX error: ', textStatus, errorThrown);
            alert('AJAX請求失敗');
        }
    });
}