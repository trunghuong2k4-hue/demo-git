<?php
require "auth.php";
require "db.php";
redirectIfNotLoggedIn();
$db = new DbHelper();

$user_id = $_SESSION["user_id"];

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET["id"];
$task = $db->select("SELECT * FROM tasks WHERE id = ? AND user_id = ?", [$id, $user_id], false);
if (!$task) {
    die("Task không tồn tại!");
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title       = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $due_date    = !empty($_POST["due_date"]) ? $_POST["due_date"] : null;
    $status      = $_POST["status"];

    if (empty($title)) {
        $message = "Tiêu đề không được để trống!";
    } else {
        $db->update(
            "UPDATE tasks SET title=?, description=?, due_date=?, status=? 
             WHERE id=? AND user_id=?",
            [$title, $description, $due_date, $status, $id, $user_id]
        );
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa công việc</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="font-family: 'Roboto', sans-serif;">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="logo.jpg" alt="Logo" width="40" height="40" class="rounded-circle me-2">
            To‑Do List
        </a>
        <div class="ms-auto d-flex align-items-center text-white">
            <span class="me-3"><?= $_SESSION["username"] ?></span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Đăng xuất</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5">
            <div class="card shadow p-4 border-0">
                <h3 class="text-center mb-4">Sửa công việc</h3>

                <?php if ($message): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" required
                               value="<?= htmlspecialchars($task->title) ?>">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($task->description) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="due_date" class="form-label">Ngày hết hạn</label>
                        <input type="date" class="form-control" id="due_date" name="due_date"
                               value="<?= htmlspecialchars($task->due_date) ?>">
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select class="form-select" id="status" name="status">
                            <option value="pending"     <?= $task->status=="pending"     ? "selected" : "" ?>>Chờ xử lý</option>
                            <option value="in_progress" <?= $task->status=="in_progress" ? "selected" : "" ?>>Đang làm</option>
                            <option value="completed"   <?= $task->status=="completed"   ? "selected" : "" ?>>Hoàn thành</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Cập nhật</button>
                    <a href="index.php" class="btn btn-secondary w-100 mt-2">Quay lại</a>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
