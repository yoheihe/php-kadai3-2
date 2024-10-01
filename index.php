<!DOCTYPE html>
<html>
<head>
    <title>投稿一覧</title>
</head>
<body>
    <?php
    // DB接続ファイルの読み込み
    require 'db.php';

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    ?>

    <h1>掲示板</h1>
    <h2>新規投稿</h2>
    <form method="post" action="submit.php">
        <label for="name">name:</label>
        <input type="text" id="name" name="name" required>
        <br><br>
        <label for="content">投稿内容:</label>
        <textarea id="content" name="content" required></textarea>
        <br><br>
        <input type="submit" value="送信">
    </form>

    <h2>投稿内容一覧</h2>
    <table border="1">
        <tr>
            <th>No</th>
            <th>名前</th>
            <th>投稿内容</th>
            <th></th>
        </tr>
        <?php
        $stmt = $pdo->query('SELECT id, name, content FROM posts ORDER BY id ASC');
        $posts = $stmt->fetchAll();
        foreach ($posts as $index => $post) {
            echo "<tr>";
            echo "<td>" . ($index + 1) . "</td>";
            echo "<td>" . htmlspecialchars($post['name'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . nl2br(htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8')) . "</td>";
            echo '<td><a href="delete.php?id=' . $post['id'] . '" onclick="return confirm(\'本当に削除しますか？\')">削除</a></td>';
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>