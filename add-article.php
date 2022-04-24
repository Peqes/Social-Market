<?php
session_start();
if(!isset($_POST['addArticleSubmit']) || ($_POST['articleTitle']==NULL) || $_POST['articleDescription']==NULL){
    
    $_SESSION['result']='<span class="error"> Fill in all the fields of the form </span>';
    header('Location:main.php');  
    exit();
}

require_once "connect.php";
$connect = @new mysqli($host, $db_user, $db_password, $db_name);
if($connect->connect_errno!=0){
    echo "Error: ".$connect->connect_errno;
}
else{
    $title = $_POST['articleTitle'];
    $description = $_POST['articleDescription'];
    $status = $_POST['articleStatus'];
    $category = $_POST['articleCategory'];
    $nickname = $_SESSION['nickname'];
    $title = htmlentities($title, ENT_QUOTES, "UTF-8");
    $description = htmlentities($description, ENT_QUOTES, "UTF-8");

    if($result = @$connect->query(sprintf("INSERT INTO `articles` (`id`, `author`, `title`, `description`, `status`,`category`) VALUES (NULL, '$nickname', '%s', '%s', '$status', '$category')",
    mysqli_real_escape_string($connect,$title),
    mysqli_real_escape_string($connect,$description)))){     
        $_SESSION['result']='<span class="correct"> Article has been added </span>';
    }
    else{
        $_SESSION['result']='<span class="error"> Incorrect Values </span>';
    }
    header('Location:main.php');
    $result->close();
}

?>