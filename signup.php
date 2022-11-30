<?php
include "_dbconnect.php";
$user = false;
$pass = false;
$insert = false;
if($_SERVER['REQUEST_METHOD']=="POST")
{
    $uname = $_POST['uname'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $sqlu = "SELECT * FROM `user_notes05` WHERE `u_name`='$uname'";//user found 
    $resu = mysqli_query($conn,$sqlu);
    $aff = mysqli_affected_rows($conn);
    if($aff > 0)
    {
        $user = true;
    }
    else
    {
        if($password == $cpassword )
        {
            
            $sqli = "INSERT INTO `user_notes05` ( `u_name`, `password`, `dt`) VALUES ( '$uname', '$password', current_timestamp());";
            $resi = mysqli_query($conn,$sqli);
            $affi = mysqli_affected_rows($conn);
            if($affi)
            {
                $insert = true;
            }
        }
        else
        {
            $pass = true;       
        }
    }
}


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
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
        if($user)
        {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Username already exist ! </strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        else if($pass)
        {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Password doesn't match..</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";    
        }
        else if($insert)
        {   
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Your account is created! Now you can login..</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }

    
    ?>
    <div class="container">
        <h1 class="text-center">Signup to our website</h1>
    </div>
    <div class="m-3 border border-success  border-opacity-25">
        <div class="m-3">
            <form action="signup.php" method="post">
                <label for="uname" class="form-label">UserName</label>
                <input type="text" class="form-control" id="uname" name="uname" placeholder="username" required>
        </div>
        <div class="m-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="password" required>
            <label for="cpassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="password" required>
            <h5 class="my-3">Make sure password must be same.</h5>
            <button type="submit" class="btn btn-primary">Signup</button>
            <button type="reset" class="btn btn-primary">Reset</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
</body>

</html>