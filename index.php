<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>We Talk Forum</title>
</head>

<body>
    <?php include 'partials/_dbconnect.php'  ?>
    <?php include 'partials/_header.php'  ?>
    <!-- '_' underscore is always used so that an outside user doesnt directly access the file -->

    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://source.unsplash.com/2400x700/?programming" class="d-block w-100" alt="...">
            </div>
            <!-- 2400x700 = width x height -->
            <div class="carousel-item">
                <img src="https://source.unsplash.com/2400x700/?code" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://source.unsplash.com/2400x700/?webdevelopment" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>


    <div class="container my-3">
        <h2 class="text-center my-3">Categories</h2>

        <div class="row my-4">

            <!-- Fetch all the categories -->

            <?php
        $sql = "SELECT * FROM `categories`";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
          // echo $row['category_id'];
          // echo $row['category_name'];
          $id = $row['category_id'];
          $cat = $row['category_name'];
          $desc = $row['category_description'];
          echo '<div class="col-md-4 my-2">
          <div class="card" style="width: 18rem;">
              <img src="https://source.unsplash.com/500x400/?'.$cat.',coding" class="card-img-top" alt="...">
              <div class="card-body">
                  <h5 class="card-title"><a href="threadlist.php?catid=' .$id. '">' .$cat. '</a></h5>
                  <p class="card-text">'.substr($desc,0,100).'...</p>
                  <a href="threadlist.php?catid=' .$id. '" class="btn btn-primary">View Threads</a>
              </div>
          </div>
      </div>';
        }

        ?>




        </div>

    </div>

    <?php include 'partials/_footer.php'  ?>



    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/9.8.1/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.8.1/firebase-analytics.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: "AIzaSyAWuShsX6DoyXjKxSGDIutcBpesq-8njFE",
    authDomain: "online-discussion-forum-5eea4.firebaseapp.com",
    projectId: "online-discussion-forum-5eea4",
    storageBucket: "online-discussion-forum-5eea4.appspot.com",
    messagingSenderId: "372264832174",
    appId: "1:372264832174:web:c0df90cbe1c262cab1b13f",
    measurementId: "G-YN397VB2QL"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);
</script>
</body>

</html>