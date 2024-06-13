<?php include 'admin_CRUD.php' ?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <title>管理者頁面</title>
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
        <div class="bold-hr"></div>
        <h2 class="my-3">所有商品</h2>
        <table id="ProductTable" class="table table-stroped table-bordered">
            <thead>
                <tr>
                    <th>id</th>
                    <th>名稱</th>
                    <th>價格</th>
                    <th>作者</th>
                    <th>撰寫日期</th>
                    <th>操作</th>
                </tr>
            </thead>
        </table>
        <!-- 新增/編輯使用者 Modal -->
        <div class="modal fade" id="AddUserModal" tabindex="-1" aria-labelledby="AddUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AddUserModalLabel">新增使用者</h5>
                    </div>
                    <div class="modal-body">
                        <form id="AddUserForm" action="admin_CRUD.php" method="post">
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
        <div class="mb-3"></div>
    </main>
</body>
<?php include '.Footer.php'; ?>
<?php include '.Script.php'; ?>
<script src="js/.Admin.js"></script>
<script>

</script>

</html>