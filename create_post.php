<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>新規投稿</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php require 'menu.php'; ?>
    <main>
    <h2>さあ投稿をはじめましょう！</h2>
    <form action="upload_post.php" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title"><br>

        <label for="content">Content:</label><br>
        <textarea id="content" name="content" required></textarea><br>

        <label for="image">Image:</label><br>
        <input type="file" id="image" name="image"><br>

        <input type="submit" value="Submit">
    </form>
    </main>
</body>
</html>
