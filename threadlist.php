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
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `categories` WHERE `category_id` = '$id'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $catname = $row['category_name'];
            $catdesc = $row['category_description'];
            

        }
        ?>


    <?php
        $method = $_SERVER['REQUEST_METHOD'];
        // echo $method;
        $showAlert = false;
        if($method=='POST'){
            $th_title = $_POST['title'];
            $th_title = str_replace("<", "&lt;", $th_title);
            $th_title = str_replace(">", "&gt;", $th_title);


            $th_desc = $_POST['desc'];
            $th_desc = str_replace("<", "&lt;", $th_desc);
            $th_desc = str_replace(">", "&gt;", $th_desc);


            $sno = $_POST['sno'];
            $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
            $result = mysqli_query($conn,$sql);
            $showAlert = true;
            if($showAlert){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Your thread has been added! Please wait for the community to respond.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            }

        }
        ?>



    <div class="container my-3">


        <div class="jumbotron p-3" style="background-color:#B8B8B8">
            <h1 class="display-4">Welcome to <?php echo $catname; ?> Forums</h1>
            <p class="lead"> <?php echo $catdesc; ?></p>
            <hr class="my-4">
            <p>It will help everyone who participates to widen their horizons of knowledge.</p>
            <p class="lead">
                <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
            </p>
        </div>
    </div>

    <?php

if(isset($_SESSION['loggedin'])&& $_SESSION['loggedin']==true){
    echo '<div class="container">
        <h3>Start a discussion.</h3>
        <form action="'.$_SERVER["REQUEST_URI"].'" method="POST">
    
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Problem Title</label>
        <input type="text" name="title" id="title" class="form-control" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">Keep the title crisp and short.</div>
    </div>
    <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Elaborate your problem.</label>
        <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Submit</button>
    </form>
    </div>';
    // <!-- $_SERVER['PHP_SELF'] this submits the form to itself but if you want the entire url including the one after ? marks then use request_uri  -->
}
else{
    echo '<div class="container">
    <h3>Start a discussion.</h3>
<p class="lead">You are not logged in! Please login to continue with the discussion.</p></div>';

}

    ?>

    <div class="container">
        <h3 class="py-2">Browse Questions</h3>

        <?php



        $id = $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE `thread_cat_id` = '$id'";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while($row = mysqli_fetch_assoc($result)){
            $noResult = false;
            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_time = $row['timestamp'];
            $newDate = date("l d F y h: i", strtotime($thread_time)); 
            $thread_user_id = $row['thread_user_id'];
            $sql2 = "SELECT `user_email` FROM `users` WHERE `sno` = '$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2); 
        
       

        echo '<div class="media my-3 d-flex">
            <img class="mr-3" src="images/user.jpg" width="64px" height="65px" alt="Generic placeholder image">
            <div class="media-body px-3">'.
            
                '<h5 class="mt-0"><a class="text-dark" href="thread.php?threadid='.$id.'">' .$title. '</a></h5>
                ' .$desc. '<p class="fw-bold my-0"> Asked by: '.$row2['user_email']. ' on '.$newDate.' </p>
            </div>
        </div>';
        }

        // echo var_dump($noResult);
        if($noResult){
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <h1 class="display-5">No Results Found.</h1>
              <p class="lead">Be the first to ask a question.</p>
            </div>
          </div>';
        }


        //  This is a debugger to check if the given fields are declared or not.
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