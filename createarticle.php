<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>  
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'></link>  

    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

</head>
<body>  
    <div class="container-article">
    <a href="createarticle.php">Article</a>
    <a href="createpost.php">Post</a>
    <a href="createpost.php">Text</a><a href="logout.php">Logout</a><br><br>
        <form id="postdata">
            <div class="brand-logo"><img src="<?php echo $_SESSION['image_link']; ?>"></div>
            <div class="brand-title"><? echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] ?></div>
            <div class="inputs">
                <label>Title</label>
                <input name="title" type="text" placeholder="Title" />
                <label>URL</label>
                <input name="url" type="text" placeholder="URL" />
                <label>URL Desription</label>
                <input name="urldesc" type="text" placeholder="URL description" />
                <label>Description</label>
                <textarea name="desc" id="" placeholder="Description" cols="30" rows="10"></textarea>
                <label>Tags</label>
                <input type="text" id="input-tags" placeholder="Tags"/>
                <div id="tags"></div>
                <input type="text" name="tags" style="display:none">
                <input type="text" name="page" value="article" style="display:none">
                <button id="submit" onclick="this.blur()" type="submit">POST</button>
            </div>
        </form>
    </div>
    <div id="target"></div>
    
    <script src="index.js"></script>
</body>
</html>