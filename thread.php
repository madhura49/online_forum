<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>WeTalk Forum</title>
</head>

<body>
    <?php include 'partials/_dbconnect.php'  ?>
    <?php include 'partials/_header.php'  ?>
    <!-- '_' underscore is always used so that an outside user doesnt directly access the file -->



    <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `threads` WHERE `thread_id` = '$id'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_user_id = $row['thread_user_id'];
            $sql2 = "SELECT `user_email` FROM `users` WHERE `sno` = '$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);   
            $posted_by = $row2['user_email'];
        }
        ?>

<?php
        $method = $_SERVER['REQUEST_METHOD'];
        // echo $method;
        $showAlert = false;
        if($method=='POST'){
            $comment = $_POST['comment'];
            $comment = str_replace("<", "&lt;", $comment);
            $comment = str_replace(">", "&gt;", $comment);

            // str_replace(array|string $search, array|string $replace, string|array $subject, int &$count = null ): string|array .This function returns a string or an array with all occurrences of search in subject replaced with the given replace value.If you don't need fancy replacing rules (like regular expressions), you should use this function instead of preg_replace().
            $sno = $_POST['sno'];
            $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$sno', current_timestamp())";
            $result = mysqli_query($conn,$sql);
            $showAlert = true;
            if($showAlert){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Your comment has been posted!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            }

        }
        ?>



    <div class="container my-3">


        <div class="jumbotron p-3" style="background-color:#B8B8B8" >
            <h1 class="display-4"><?php echo $title; ?></h1>
            <p class="lead"> <?php echo $desc; ?></p>
            <hr class="my-4">
            <p>It will help everyone who participates to widen their horizons of knowledge.</p>
            <p class="lead">
            <p>Posted by: <b><?php echo $posted_by ?></b></p>
            </p>
        </div>
    </div>

    <?php
    if(isset($_SESSION['loggedin'])&& $_SESSION['loggedin']==true){
    echo ' <div class="container">
        <h3>Post a Comment.</h3>
        <form action="'.$_SERVER['REQUEST_URI'].'" method="POST">
            
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Type your comment.</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
        </form>
    </div>';
    // <!-- $_SERVER['PHP_SELF'] this submits the form to itself but if you want the entire url including the one after ? marks then use request_uri  -->
}
else{
    echo '<div class="container">
    <h3>Post a discussion.</h3>
<p class="lead">You are not logged in! Please login to post a comment.</p></div>';

}
?>


    <div class="container">
        <h3 class="py-2">Discussions</h3>
 
        <?php

        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE `thread_id` = '$id'";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while($row = mysqli_fetch_assoc($result)){
            $noResult = false;
            $id = $row['comment_id'];
            $content = $row['comment_content'];
            $comment_time = $row['comment_time'];
            $newDate = date("l d F y h: i", strtotime($comment_time));
            $thread_user_id = $row['comment_by'];
            $sql2 = "SELECT `user_email` FROM `users` WHERE `sno` = '$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);   
           
        echo '<div class="media my-3 d-flex ">
            <img class="mr-3" src="images/user.jpg" width="64px" height="65px" alt="Generic placeholder image">
            <div class="media-body mx-3">   
            <p class="fw-bold my-0">'.$row2['user_email']. ' on '.$newDate.' </p>
                ' .$content. '
            </div>
            
        </div>';
        }


        if($noResult){
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <h1 class="display-5">No Comments Found.</h1>
              <p class="lead">Be the first to comment.</p>
            </div>
          </div>';
        }


        



        // if(isset($_POST['catname'])&& $_POST['catdesc'])
        // if(isset($_GET['catid'])){
        //     $update = true;
        // }
        // else{
        //     $update = false;           
        // }
        // echo var_dump($update);
        ?> 

    </div>

    <?php include 'partials/_footer.php'  ?>



    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>


</body>

</html>