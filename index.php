<?php
require "auth.php";
require "db.php";
redirectIfNotLoggedIn();
$db = new DbHelper();

$user_id = $_SESSION["user_id"];
$tasks = $db->select("SELECT * FROM tasks WHERE user_id = ?", [$user_id]);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard – Công việc của <?= htmlspecialchars($_SESSION["username"]) ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body style="font-family: 'Roboto', sans-serif; background-color: #f8f9fa;">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="logo.jpg" alt="Logo" width="40" height="40" class="rounded-circle me-2">
            <span class="fw-bold">Work</span>
        </a>
        <div class="ms-auto d-flex align-items-center text-white">
            <span class="me-3">Xin chào, <?= htmlspecialchars($_SESSION["username"]) ?></span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">
                <i class="bi bi-box-arrow-right"></i> Đăng xuất
            </a>
        </div>
    </div>
</nav>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Danh sách công việc</h3>
        <a href="createtask.php" class="btn btn-success d-flex align-items-center gap-1">
            <i class="bi bi-plus-lg"></i> Thêm công việc
        </a>
    </div>

    <?php if(empty($tasks)): ?>
        <div class="alert alert-info">Bạn chưa có công việc nào.</div>
    <?php else: ?>
        <div class="table-responsive bg-white shadow-sm rounded">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Ngày hết hạn</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td><?= htmlspecialchars($task->title) ?></td>
                            <td><?= $task->due_date ? htmlspecialchars($task->due_date) : "-" ?></td>
                            <td>
                                <?php
                                    switch($task->status) {
                                        case "pending":
                                            echo '<span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i> Đang chờ</span>';
                                            break;
                                        case "in_progress":
                                            echo '<span class="badge bg-info text-dark"><i class="bi bi-arrow-repeat me-1"></i> Đang tiến hành</span>';
                                            break;
                                        case "completed":
                                            echo '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Hoàn thành</span>';
                                            break;
                                        default:
                                            echo '<span class="badge bg-secondary"><i class="bi bi-question-circle me-1"></i> Không xác định</span>';
                                            break;
                                    }
                                ?>
                            </td>
                            <td class="text-end">
                                <a href="edittask.php?id=<?= $task->id ?>" class="btn btn-primary btn-sm me-2" title="Sửa">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <a href="deletetask.php?id=<?= $task->id ?>" class="btn btn-danger btn-sm" title="Xóa"
                                   onclick="return confirm('Bạn có chắc muốn xóa công việc này?');">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Bootstrap JS + Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
