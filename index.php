<?php session_start();
if((isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==true)){
    header('Location:main.php');
    exit;
}
include('header.php');
?>
<body>
    <div class="wrapper">
        <div class="form-container">
            <form class="form-login" action="login.php" method="post">
                <input type="text" id="login" placeholder="Login" name="login">
                <input type="password" id="password" placeholder="Password" name="password">
                <input type="submit" name="loginSubmit" value="Log in">                
            <form>
            <br>
            <a href="register-page.php" id="link-register">Create an account</a>
            <br>
            <?php
                if(isset($_SESSION['result'])){ 
                    echo $_SESSION['result'];
                    unset($_SESSION['result']); }               
            ?>
        </div>
    </div>

</body>
</html>