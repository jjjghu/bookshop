<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>DataTable Example</title>
    <?php include '.Style.php' ?>
</head>

<body>
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
</body>
<?php include '.Script.php' ?>
<script>
    $(document).ready(function () {
        $('#UserTable').DataTable({
            "ajax": ".dataTable3_ajax.php",
            "columns": [
                { "data": "id" },
                { "data": "username" },
                { "data": "penName" },
                { "data": "email" },
                { "data": "phone" },
                { "data": "actions" }
            ]
        });
    });
</script>

</html>