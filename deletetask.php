<?php
require "auth.php";
require "db.php";
redirectIfNotLoggedIn();

$db = new DbHelper();
$user_id = $_SESSION["user_id"];
$id = $_GET["id"];

$db->execute(
    "DELETE FROM tasks WHERE id = ? AND user_id = ?",
    [$id, $user_id]
);

header("Location: index.php");
exit;
?>
