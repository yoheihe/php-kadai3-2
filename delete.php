<?php
// DB接続ファイルの読み込み
require 'db.php';

if (isset($_GET['id'])) {
    $deleteId = (int)$_GET['id'];
    $stmt = $pdo->prepare('DELETE FROM posts WHERE id = ?');
    $stmt->execute([$deleteId]);
    header('Location: complete.php?deleted=1');
    exit;
}