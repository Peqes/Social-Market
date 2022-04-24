 
<?php session_start();
if(!isset($_SESSION['loggedin'])){
    header('Location:index.php');
    exit();
}
  require_once "connect.php";  
  $connect = @new mysqli($host, $db_user, $db_password, $db_name);
  if($connect->connect_errno!=0){//Connection failed
      echo "Error: ".$connect->connect_errno;
  }
  else{//Connection approved
        $nickname = $_SESSION['nickname'];
        $sql = "SELECT * FROM `articles` WHERE status='public' OR status='private' AND author='$nickname'";
        if($articles = @$connect->query($sql)){
            $articles_num = $articles->num_rows;              
        }
        else{
            $_SESSION['result']='<span class="error"> Error occur while displaying articles from database </span>';
        }
    }
  include('header.php');  
?> 
<body>
    <header>
    <h1>Add Article</h1>
    <div id="welcome">       
        <?php echo "<p>Welcome ".$_SESSION['nickname']."</p>"  ?>
        <a href="logout.php">Log out</a>
    </div>
        <div id="panel-add-article">
            <form action="add-article.php" method="post">
                <input type="text" id="add-article-title" name="articleTitle" placeholder="Title - MAX 30">
                <textarea id="add-article-description" name="articleDescription" placeholder="Description - MAX 150" max-length="150"></textarea>      
                <div id="add-selected">
                    <label for="add-article-status">Status</label> 
                    <select id="add-article-status" name="articleStatus">
                        <option value="public">public</option>
                        <option value="private">private</option>
                    </select><br>
                    <label for="add-article-category">Category</label>          
                    <select id="add-article-category" name="articleCategory">
                        <option value="wallstreet">Wall Street</option>
                        <option value="crypto">Crypto</option>
                        <option value="housingmarket">Housing Market</option>
                    </select>
                </div>
                <input type="submit" id="add-article-submit" name="addArticleSubmit" value="Post">
            </form>
            <br>
            <?php
                if(isset($_SESSION['result'])){ 
                    echo $_SESSION['result'];
                    unset($_SESSION['result']); }               
            ?>
        </div>
    </header>
    <main>
        <div class="articles-wrapper">
            <?php                
                if($articles_num>0){
                    while($article=$articles->fetch_array())                    {
                        echo '<article class="article">
                                <h2 class="article-title">'.$article['title'].'</h2>
                                <p class="article-description">'.$article['description'].'</p>
                                <span class="article-author">'.$article['author'].'</span>
                                <span class="article-status">'.$article['status'].'</span>
                                <span class="article-category">'.$article['category'].'</span>';
                            if($article['author']==$_SESSION['nickname']){     
                                echo '<form action="delete-article.php" method="post">
                                    <input type="submit" value="Delete" name="btnDel['.$article['id'].']" class="article-delete"></form>';                                                          ;
                            }
                            echo '</article>';
                    }                      
                }
                $articles->close();                
            ?> 
        </div>
    </main>
</body>
</html>