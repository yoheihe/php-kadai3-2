<?php
// DB接続ファイルの読み込み
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) && isset($_POST['content'])) {
        $name = trim($_POST['name']);
        $content = trim($_POST['content']);

        if ($name !== '' && $content !== '') {
            $stmt = $pdo->prepare('INSERT INTO posts (name, content) VALUES (?, ?)');
            $stmt->execute([$name, $content]);
            header('Location: complete.php?complete=1');
            exit;
        } else {
            echo "エラー: 名前と投稿内容を入力してください。";
        }
    }
}