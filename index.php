<?php
session_start();

if(!isset($_SESSION['login']) || $_SESSION['login']!=true)
{
  header("location:login.php");
}

$un = $_SESSION['uname']; 
include "_dbconnect.php";
$insert = false;
$del  =false;
$update = false ; 

if($conn)
{
    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        if(isset($_POST['esid']))
        {
            //update
            $enid = $_POST['esid'];
            $etitle = $_POST['etitle'];
            $edesc = $_POST['enote'];
            $sqlu = "UPDATE `notes` SET `title` = '$etitle', `description` = '$edesc' WHERE `notes`.`nid` = $enid;";
            $resu = mysqli_query($conn,$sqlu);
            $affu = mysqli_affected_rows($conn);
            if($affu)
            {
                $update = true;
            }
        }
        else
        {
            //insert
            $title = $_POST['title'];
            $title = str_replace("<","&lt;",$title);
            $title = str_replace(">","&gt;",$title);
            $desc = $_POST['note'];
            $desc = str_replace("<","&lt;",$desc);
            $desc = str_replace(">","&gt;",$desc);
            $userid = $_SESSION['uid'];
            $sqli = "INSERT INTO `notes` ( `title`, `description`, `uid`, `dt`) VALUES ('$title', '$desc', '$userid', current_timestamp());";
            $resi = mysqli_query($conn,$sqli);
            if($resi)
            {
                $insert = true;
            }
        }
    }


    //delete
    if(isset($_GET['del']))
    {
        $nid = $_GET['del'];
        $sqld = "DELETE FROM `notes` WHERE `notes`.`nid` = $nid;";
        $resd = mysqli_query($conn,$sqld);
        $affd = mysqli_affected_rows($conn);
        if($affd)
        {
            $del = true;
        }
    }
}
else
{
    echo "error";
}



?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>

    <!-- //modal -->
    <div class="modal" id="emodal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- form for edit modal -->
                    <form action="index.php?" method="post">
                        <input type="hidden" id="esid" name="esid">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="etitle" name="etitle">
                        <div class="mb-3">
                            <label for="note" class="form-label">Description</label>
                            <textarea class="form-control" name="enote" id="enote" rows="3"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" data-bs-dismiss="modal" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


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
                    <ul class="navbar-nav me-auto m-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    <p class='navbar-nav m-2 ms-4  text-dark'>welcome <?php echo $un;?></p>
                </div>
            </div>
        </nav>
    </div>
    <?php
       if($insert)
       {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Successfull !</strong> Note successfully added.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
       } 
       if($del)
       {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Successfull !</strong> Note deleted.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
       } 
       if($update)
       {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Successfull !</strong> Note update.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
       } 
    
    ?>
    <!-- add notes -->
    <div class="container mt-3">
        <div class="mb-3">

            <h2>Add notes</h2>
            <form action="index.php" method="post">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="note" class="form-label">Description</label>
            <textarea class="form-control" name="note" id="note" rows="3" required></textarea>
            <button type="submit" class="btn btn-outline-primary mt-3">Add note</button>
            </form>
        </div>
    </div>
    <!-- this is table for reading the data -->
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $uid = $_SESSION['uid'];
                    $sqls = "SELECT * FROM `notes` WHERE `uid` = '$uid'";
                    $ress = mysqli_query($conn,$sqls);
                    $aff = mysqli_affected_rows($conn);

                    if($aff)
                    {
                        $n = 0;
                        while($row = mysqli_fetch_assoc($ress))
                        {
                            $n++;
                            echo "<tr>
                              <th scope='row'>".$n."</th>
                                        <td>".$row['title']."</td>
                                        <td>".$row['description']."</td>
                                        <td><button data-bs-toggle='modal' id='".$row['nid']."' data-bs-target='#emodal'
                                        class='edit btn btn-primary'>Edit</button> <button type='button' id='d".$row['nid']."'
                                        class='delete btn btn-primary'>Delete</button></td>
                             </tr>";
                        }
                    }
                ?>
                <!-- <tr>
                    <th scope='row'>1 </th>
                    <td>title</td>
                    <td>desc</td>
                    <td><button data-bs-toggle='modal' id='' data-bs-target='#emodal'
                            class='edit btn btn-primary'>Edit</button> <button type='button' id=''
                            class='delete btn btn-primary'>Delete</button></td>
                </tr> -->

            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <script>
        let edit = document.getElementsByClassName("edit");
        Array.from(edit).forEach((e)=>{
            e.addEventListener("click",(e)=>{
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerHTML;
                desc = tr.getElementsByTagName("td")[1].innerHTML;

                enid = document.getElementById("esid");
                etitle = document.getElementById("etitle");
                enote = document.getElementById("enote");

                etitle.value = title;
                enote.value = desc;
                enid.value = e.target.id;
            })
        })                
         


        let del = document.getElementsByClassName("delete");
        Array.from(del).forEach((e)=>{
            e.addEventListener("click",(e)=>{
                let nid = e.target.id.substr(1);
                // console.log(nid);
                if(confirm("are you sure to delete ?"))
                {
                    window.location = `index.php?del=${nid}`;
                }
            })
        })
    </script>
</body>

</html>