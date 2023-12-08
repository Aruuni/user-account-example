<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="../style.css" rel="stylesheet" type="text/css">
    <link href="gallery.css" rel="stylesheet" type="text/css">
    
    <title>Requested Evaluations</title>
</head>
<body>
    <div class ="commonBox">
    <h1>Requested Evaluations</h1>

    <?php
    include_once '../src/connection.php';
    function getImagesFromDatabase($id, $conn) {
        $images = [];
        $result = $conn->prepare('SELECT * FROM images WHERE id = ?');
        $result->bind_param("i", $id); 
        $result->execute();
        $result = $result->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $images[] = $row;
            }
        }
        return $images;
    } 

    $imageRecords = [];
    $statement = $connection->query('SELECT id FROM accounts');
    if ($statement->num_rows > 0) {
        while ($row = $statement->fetch_assoc()) {
            $imageRecords = array_merge($imageRecords,  getImagesFromDatabase($row['id'], $connection));
        }
    }   

    if (!empty($imageRecords)) {
        echo "<div class='gallery'>";
        foreach ($imageRecords as $image) {
            echo "<div class='image-card'>";
            $imagePath = $image['file_name'];
            $comment = $image['comment'];
            $contact = $image['contact'];
            ?>
            <div class='gallery-item'>
                <img src='<?php echo "photos/".$image['id']."/".$imagePath; ?>'>
                <div class="comment"><?php echo $comment; ?></div>
                <div class="comment">Contact: <?php echo $contact; ?></div>
            </div>
            <?php
        }
        echo "</div>";
    } else {
        echo "No request evaluations found in the database.";
    }

    $connection->close();
    ?>
</div>
</body>
</html>