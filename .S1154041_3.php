<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>DataTable Example</title>
    <?php include '.Style.php' ?>
</head>
<?php include '.Theme.php'; ?>

<body class="<?php echo $theme; ?>">
    <?php include '.Header.php'; ?>
    <main class="container mt-10vh">
        <h2 class="mb-3">所有使用者</h2>
        <table id="UserTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>id</th>
                    <th>使用者名稱</th>
                    <th>筆名</th>
                    <th>電子郵件</th>
                    <th>電話</th>
                    <th>操作</th>
                </tr>
            </thead>
        </table>
        <!-- 按鈕觸發 Modal -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#AddUserModal">
            新增使用者
        </button>
        <!-- 顯示所有商品按鈕 -->
        <!-- 新增/編輯使用者 Modal -->
        <div class="modal fade" id="AddUserModal" tabindex="-1" aria-labelledby="AddUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AddUserModalLabel">新增使用者</h5>
                    </div>
                    <div class="modal-body">
                        <form id="AddUserForm" action="admin.php" method="post">
                            <input type="hidden" id="user_id" name="user_id">
                            <div class="mb-3">
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="使用者名稱">
                                <p class="text-danger" id="username-err"></p>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="penName" name="penName" placeholder="筆名">
                                <p class=" text-danger" id="penName-err"></p>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="密碼">
                                <p class=" text-danger" id="password-err"></p>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="電子信箱">
                                <p class="text-danger" id="email-err"></p>
                            </div>
                            <div class="mb-3">
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="手機號碼">
                                <p class="text-danger" id="phone-err"></p>
                            </div>
                            <div class="mb-3 form-check form-switch d-flex justify-content-between">
                                <div>
                                    <input class="form-check-input" type="checkbox" id="is_admin" name="is_admin">
                                    <label class="form-check-label" for="is_admin">設定為管理員</label>
                                </div>
                                <div id="message" class="text-danger"></div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <div id="message"></div>
                                <div>
                                    <button type="button" class="btn btn-secondary me-2"
                                        data-bs-dismiss="modal">取消</button>
                                    <button type="submit" id="AddUserConfirm" class="btn btn-primary">保存變更</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
<?php include '.Footer.php'; ?>
<?php include '.Script.php'; ?>
<script src="js/.Admin.js"></script>
<script>
    $(document).ready(function () {
        $('#UserTable').DataTable({
            "ajax": ".dataTable_ajax.php",
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
            }
        });
    });
</script>

</html>