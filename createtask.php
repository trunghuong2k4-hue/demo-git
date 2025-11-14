<?php
require "auth.php";
require "db.php";
redirectIfNotLoggedIn();
$db = new DbHelper();

$user_id = $_SESSION["user_id"];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $due_date = !empty($_POST["due_date"]) ? $_POST["due_date"] : null;
    $status = $_POST["status"];

    if (empty($title)) {
        $message = "Tiêu đề công việc không được để trống!";
    } else {
        $db->insert(
            "INSERT INTO tasks(user_id, title, description, due_date, status, created_at) 
             VALUES (?, ?, ?, ?, ?, NOW())",
            [$user_id, $title, $description, $due_date, $status]
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
    <title>Thêm công việc</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body style="font-family: 'Roboto', sans-serif;">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="logo.jpg" alt="Logo" width="40" height="40" class="rounded-circle me-2">
            WorkList
        </a>
        <div class="ms-auto d-flex align-items-center text-white">
            <span class="me-3">Hi, <?= htmlspecialchars($_SESSION["username"]) ?></span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Đăng xuất</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5">
            <div class="card shadow p-4 border-0">
                <h3 class="text-center mb-4">Thêm công việc</h3>

                <?php if($message): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <!-- Tiêu đề với icon -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Nhập tiêu đề..." required>
                        </div>
                    </div>

                    <!-- Mô tả với icon -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-pencil-square"></i></span>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Mô tả chi tiết công việc (tùy chọn)"></textarea>
                        </div>
                    </div>

                    <!-- Ngày hết hạn với icon -->
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Ngày hết hạn</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                            <input type="date" class="form-control" id="due_date" name="due_date">
                        </div>
                    </div>

                    <!-- Trạng thái với icon -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-flag"></i></span>
                            <select class="form-select" id="status" name="status">
                                <option value="pending">Đang chờ</option>
                                <option value="in_progress">Đang tiến hành</option>
                                <option value="completed">Hoàn thành</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Thêm công việc</button>
                    <a href="index.php" class="btn btn-secondary w-100 mt-2">Quay lại</a>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS + Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
