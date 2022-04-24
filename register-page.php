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
            <form class="form-login" action="register.php" method="post">
            <input type="text" placeholder="Nickname" name="nickname">
                <input type="text" placeholder="Login" name="login">
                <input type="password" placeholder="Password" name="password">
                <input type="password" placeholder="repeat Password" name="passwordRepeat">
                <input type="submit" name="registerSubmit" value="Register">                
            <form>
            <br>
            <a href="index.php">Log in</a>
            <br><br>
            <?php
                if(isset($_SESSION['result'])){ 
                    echo $_SESSION['result'];
                    unset($_SESSION['result']); }               
            ?>
        </div>
    </div>

</body>
</html>