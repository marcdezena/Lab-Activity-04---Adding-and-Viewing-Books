<?php

require_once __DIR__ . '/product.php';
$productObj = new Product();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Documents</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="header-container">
        <h1>List of books</h1>
        <?php $q_get = isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; $genre_get = isset($_GET['genre']) ? $_GET['genre'] : ''; ?>
            <a href="addbook.php" class="btn">Add book</a>
            <form method="get" class="search-form">
                <input type="search" name="q" placeholder="Search books..." value="<?= $q_get ?>">
                <select name="genre" id="genre">
                    <option value="">--all--</option>
                    <option value="history" <?= ($genre_get == "history") ? "selected" : ""; ?>>History</option>
                    <option value="science" <?= ($genre_get == "science") ? "selected" : "" ?>>Science</option>
                    <option value="fiction" <?= ($genre_get == "fiction") ? "selected" : "" ?>>Fiction</option>
                </select>
                <input type="submit" value="Search">
            </form>
    </div>
    <div class="table-container">
        <table border=1>
            <tr>
                <th>No.</th>
                <th>title</th>
                <th>author</th>
                <th>genre</th>
                <th>publication_year</th>
                <th>publisher</th>
                <th>copies</th>
            </tr>
        <?php
        $counter = 1;
        $q = isset($_GET['q']) ? trim($_GET['q']) : null;
        $genre = isset($_GET['genre']) ? trim($_GET['genre']) : null;
        $books = $productObj->viewbook($q, $genre);
        if ($books)
        foreach ($books as $product)
        {
        ?>
                <tr>
                    <td><?= $counter++ ?></td>
                    <td><?= $product["title"] ?></td>
                    <td><?= $product["author"] ?></td>
                    <td><?= $product["genre"] ?></td>
                    <td><?= $product["publication_year"] ?></td>
                    <td><?= $product["publisher"] ?></td>
                    <td><?= $product["copies"] ?></td>
                </tr>
            <?php
        }
            ?>
        </table>
    </div>
</body>
</html>