<?php
require_once 'config.php';
session_start();

if(isset($_GET['code'])){
    $code = $_GET['code'];
    $url = "https://www.linkedin.com/oauth/v2/accessToken?code=$code&grant_type=authorization_code&client_id=".CLIENT_ID."&client_secret=".CLIENT_SECRET."&redirect_uri=".REDIRECT_URL;

    require_once 'getuserdata.php';
    header("location: createpost.php");
} else if (isset($_GET['token'])) {
    echo $_GET['token'];
} else {
    $url = "https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=".CLIENT_ID."&redirect_uri=".REDIRECT_URL."&scope=".SCOPES;
}
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
</head>
<body>  
    <div class="container">
        <form id="postdata">
            <div class="brand-logo"><img src="LinkedIn.png"></div>
            <div class="brand-title">LinkedIn</div>
            <div class="inputs">
                <a href="<?php echo $url; ?>">login</a>
            </div>
        </form>
    </div>
    
    <script src="index.js"></script>
</body>
</html>