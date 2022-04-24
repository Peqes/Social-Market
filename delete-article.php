<?php 
    session_start();
    require_once "connect.php";
    $connect = @new mysqli($host, $db_user, $db_password, $db_name);
    if($connect->connect_errno!=0){
        echo "Error: ".$connect->connect_errno;
    }
    else{
        if(isset($_POST['btnDel']) && is_array($_POST['btnDel'])){
            foreach($_POST['btnDel'] as $id_to_del => $useless_value){
                $nickname = $_SESSION['nickname'];
                $sql = "DELETE FROM `articles` WHERE id = '$id_to_del' AND author = '$nickname' ";
                if($result = @$connect->query($sql)){ 
                    
                }
                else{
                    $_SESSION['result']='<span class="error"> An error occur while deleting the article (Article missing) </span>';
                }
            }
        }
        header('Location:main.php'); 
        $result->close();
    }
?>