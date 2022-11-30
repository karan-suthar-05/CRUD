<?php
include "_dbconnect.php";
$found = false;
$match = false;
if($_SERVER['REQUEST_METHOD']=="POST")
{
    $user = $_POST['uname'];
    $pass = $_POST['password'];
      
    $sql = "SELECT * FROM `user_notes05` WHERE `u_name`='$user'";//user
    $res = mysqli_query($conn,$sql);
    $aff = mysqli_affected_rows($conn);
    if($aff > 0)
    {
         $sqlp = "SELECT * FROM `user_notes05` WHERE `u_name` = '$user' AND `password` = '$pass';";
         $resp = mysqli_query($conn,$sqlp);
         $row = mysqli_fetch_assoc($resp);
         $affp = mysqli_affected_rows($conn);
         if($affp)
         {
            
            session_start();
            $_SESSION['login'] = true;
            $_SESSION['uname'] = $user;
            $_SESSION['uid'] = $row['uid'];
            header("location:index.php");
            exit;
         }
        
        $match = true; 
    }
    else
    {
        $found = true;
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <!-- navbar   -->
    <div>
        <nav class="navbar navbar-expand-lg bg-light ">
            <div class="container-fluid text-light">
                <a class="navbar-brand" href="index.php">KK NOTE</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="signup.php">Signup</a>
                        </li>
                         
                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </div>
    <?php
        if($found)
        {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Please create account first! press signup.. </strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        if($match)
        {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Password doesn't match.</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
    ?>
    <div class="container">
        <h1 class="text-center">Login to our website</h1>
    </div>
    <div class="m-3 border border-success  border-opacity-25">
        <div class="m-3">
            <form action="login.php" method="post">
                <label for="uname" class="form-label">UserName</label>
                <input type="text" class="form-control" id="uname" name="uname" placeholder="username" required>
        </div>
        <div class="m-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="password" required>
            <button type="submit" class="btn btn-primary my-3">Login</button>
            <button type="reset" class="btn btn-primary">Reset</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
</body>

</html>