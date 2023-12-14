<?php
session_start();
$_SESSION['token'] = md5(uniqid(mt_rand(), true));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Request evaluation</title>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="../style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="commonBox">
        <h1>Submit an evaluation</h1>
        <form action="uploadfile.php"  method="post" enctype="multipart/form-data">
            
            <label for="comment">
                <i class="fas fa-comment"></i>
            </label>
            <input type="text" name="comment" placeholder="Comment" id="username" required>
            
            <select name="contact" id="contact" required>
                <option value="" disabled selected hidden>How would you like to be contacted?</option>
                <option value="Email">Email</option>
                <option value="Phone">Phone</option>
            </select>
            
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">

            <input type="file" name="fileToUpload" id="fileToUpload" enctype="multipart/form-data" required>

            <input type="submit"  value="See your evaluation list">
        </form>

    </div>
</body>
</html>
