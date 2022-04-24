<?php  
    session_start();
    if((!isset($_POST['registerSubmit'])) || ($_POST['nickname']==NULL) || ($_POST['login']==NULL) || ($_POST['password']==NULL) || ($_POST['passwordRepeat']==NULL)){
        header('Location:register-page.php');
        $_SESSION['result']='<span class="error"> Fill in all the fields of the form </span>';
        exit();
    }
    require_once "connect.php";
    
    $connect = @new mysqli($host, $db_user, $db_password, $db_name);
    if($connect->connect_errno!=0){//Connection failed
        echo "Error: ".$connect->connect_errno;
    }
    else{//Connection approved
        $nickname = $_POST['nickname'];
        $login = $_POST['login'];
        $password = $_POST['password'];
        $rep_password = $_POST['passwordRepeat'];

        $nickname = htmlentities($nickname, ENT_QUOTES, "UTF-8");
        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        $password = htmlentities($password, ENT_QUOTES, "UTF-8");       
        $rep_password = htmlentities($rep_password, ENT_QUOTES, "UTF-8");

        if($result = @$connect->query(sprintf("SELECT * FROM `users` WHERE nickname='%s'",
        mysqli_real_escape_string($connect,$nickname)))){
            $nicknames_num = $result->num_rows;
        }
        else{
            $_SESSION['result']='<span class="error"> Database connection error </span>';
        }
        $result->close();
        
        if($result = @$connect->query(sprintf("SELECT * FROM `users` WHERE login='%s'",
        mysqli_real_escape_string($connect,$login)))){
            $logins_num = $result->num_rows;
        }
        $result->close();

        if($nicknames_num>0){
            $_SESSION['result']='<span class="error"> Someone else is using this nickname </span>';
        }
        if($logins_num>0){
            $_SESSION['result']='<span class="error"> Someone else is using this login </span>';
        }
        if($rep_password!=$password){
            $_SESSION['result']='<span class="error"> Passwords are not identical </span>';
        }
        if(strlen($nickname)>20){
            $_SESSION['result']='<span class="error"> Nickname is too long </span>';
        }
        if(strlen($login)>20){
            $_SESSION['result']='<span class="error"> Login is too long </span>';
        }
        if(strlen($password)>30){
            $_SESSION['result']='<span class="error"> Password is too long </span>';
        }
        if(isset($_SESSION['result'])){
            header('Location:register-page.php');
            $connect->close();
            exit();
        }
        if($result = @$connect->query(sprintf("INSERT INTO `users` (`nickname`, `login`, `passwd`, `superuser`) VALUES ('%s', '%s', '%s', '%s');",
        mysqli_real_escape_string($connect,$nickname),
        mysqli_real_escape_string($connect,$login),
        mysqli_real_escape_string($connect,$password),
        mysqli_real_escape_string($connect,$rep_password)))){
            
            $_SESSION['result']='<span class="correct"> Account registered </span>';
        }
        else{
            $_SESSION['result']='<span class="error">Incorrect data </span>';  
        }
        header('Location:index.php');
        $connect->close();
    }

   
?>