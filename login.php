<?php  
    session_start();
    if(!isset($_POST['loginSubmit'])){
        header('Location:index.php');
        exit();
    }
    require_once "connect.php";
    
    $connect = @new mysqli($host, $db_user, $db_password, $db_name);
    if($connect->connect_errno!=0){//Connection failed
        echo "Error: ".$connect->connect_errno;
    }
    else{//Connection approved

        $login = $_POST['login'];
        $password = $_POST['password'];
        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        $password = htmlentities($password, ENT_QUOTES, "UTF-8");

        if($result = @$connect->query(sprintf("SELECT * FROM users WHERE login='%s' AND passwd='%s'",
        mysqli_real_escape_string($connect,$login),
        mysqli_real_escape_string($connect,$password)))){
            $users_num = $result->num_rows;
            if($users_num>0){
                $_SESSION['loggedin']=true;
                $row_login = $result->fetch_assoc();
                $nickname = $row_login['nickname'];
                $_SESSION['nickname'] = $nickname;
                $result->close();
                header('Location:main.php'); 
            }
            else{
                $_SESSION['result']='<span class="error">Incorrect login or password </span>';
                header('Location:index.php');
            }
        }
        $connect->close();
    }

   
?>