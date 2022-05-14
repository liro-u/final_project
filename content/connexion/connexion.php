<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="project.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Koulen&display=swap" rel="stylesheet">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>
<body>
<div class="container">
    <div class="screen">
        <div class="screen_content">
            <span class="login_top">Login</span>
            <form class="login" action="connexion_func/verif_connexion.php" method="post">
                <div class="login_field">
                    <i class='fas fa-user-alt'></i>
                    <input type="text" name="login" class="login_input" placeholder="User name"/>
                </div>
                <div class="login_field">
                    <i class='fas fa-lock'></i>
                    <input type="password" name="password" class="login_input" placeholder="Password"/>
                </div>
                <div class="text-right">
                    <a href="#">Forgot password?</a>
                </div>
                <input type="submit" class="button login_submit" value="Log In">
                <i class="button_icon fas fa-chevron-right"></i>
            </form>



        <?php
        if(isset($_GET['error'])){
            if($_GET['error'] == "wrong_mdp"){
                echo "<p style='color:red'>Username or password is not correct</p>";
            }
        }
        ?>
</body>
</html>
