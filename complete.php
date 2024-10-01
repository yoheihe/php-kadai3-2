<!DOCTYPE html>
<html>
<head>
    <title>完了画面</title>
</head>
<body>
    <?php
    if (isset($_GET['complete']) && $_GET['complete'] == 1) {
        echo "<h1>投稿が完了しました</h1>";
    } elseif (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
        echo "<h1>削除が完了しました</h1>";
    }
    ?>
    <a href="index.php">投稿一覧に戻る</a>
</body>
</html>