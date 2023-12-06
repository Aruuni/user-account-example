<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet" type="text/css">
    <link href="gallery.css" rel="stylesheet" type="text/css">

    <title>Image Gallery</title>
</head>
<body>
    <div class ="commonBox">
    <h1>Image Gallery</h1>

    <?php
    
    // Function to get a list of image files in a directory
    session_start();
           
    function getImagesFromDatabase() {
        include_once '../src/connection.php';
        $id = $_SESSION['session_id'];
        $images = [];
        $result = $connection->query("SELECT * FROM images WHERE id = '$id'");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $images[] = $row;
            }
        }
        $connection->close();
        return $images;
    }

    // Loop through user folders and display images
    $imageRecords = getImagesFromDatabase();
    $id = $_SESSION['session_id'];
    if (!empty($imageRecords)) {
        echo "<div class='gallery'>";
        foreach ($imageRecords as $image) {
            echo "<div class='image-card'>";
            $imagePath = $image['file_name'];
            $comment = $image['comment'];
    
            ?>
            <div class='gallery-item'>
                <img src='<?php echo "photos/".$id."/".$imagePath; ?>'>
                <div class="comment"><?php echo $comment; ?></div>
            </div>
            <?php
        }
        echo "</div>";
    } else {
        echo "No images found in the database.";
    }

    // Close the database connection

    ?>
</div>
</body>
</html>