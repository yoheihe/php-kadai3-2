<!DOCTYPE html>
<html>
<head>
    <title>投稿一覧</title>
</head>
<body>
    <?php
    // データベース接続設定
    $host = 'localhost';
    $db = 'fizzbuzz';
    $user = 'root';
    $pass = 'root';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=3306";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        die('接続に失敗しました: ' . $e->getMessage());
    }

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    // フォームが送信された場合
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['name']) && isset($_POST['content'])) {
            $name = trim($_POST['name']);
            $content = trim($_POST['content']);

            if ($name !== '' && $content !== '') {
                $stmt = $pdo->prepare('INSERT INTO posts (name, content) VALUES (?, ?)');
                $stmt->execute([$name, $content]);
                header('Location: ' . $_SERVER['PHP_SELF'] . '?complete=1');
                exit;
            } else {
                echo "<p>エラー: 名前と投稿内容を入力してください。</p>";
            }
        }
    }

    // 投稿削除処理
    if (isset($_GET['delete'])) {
        $deleteId = (int)$_GET['delete'];
        $stmt = $pdo->prepare('DELETE FROM posts WHERE id = ?');
        $stmt->execute([$deleteId]);
        header('Location: ' . $_SERVER['PHP_SELF'] . '?deleted=1');
        exit;
    }

    // 投稿完了画面
    if (isset($_GET['complete']) && $_GET['complete'] == 1) {
        echo "<h1>投稿が完了しました</h1>";
        echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="get">';
        echo '<input type="submit" value="投稿一覧へ戻る">';
        echo '</form>';
    } elseif (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
        echo "<h1>削除が完了しました</h1>";
        echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="get">';
        echo '<input type="submit" value="投稿一覧へ戻る">';
        echo '</form>';
    } else {
        // 投稿フォームと投稿一覧の表示
        ?>
        <h1>掲示板</h1>
        <h1>新規投稿</h1>
        <form method="post" action="">
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
                echo '<td><a href="?delete=' . $post['id'] . '" onclick="return confirm(\'本当に削除しますか？\')">削除</a></td>';
                echo "</tr>";
            }
            ?>
        </table>
        <?php
    }
    ?>
</body>
</html>
