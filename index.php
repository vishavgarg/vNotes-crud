<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "vnotes";

$conn=mysqli_connect($servername, $username, $password, $database);

if(!$conn){
   die("Failed to connect due to: ".mysqli_connect_error()); 
}

$insert = false;
$insert_error = false;
$insertEdit = false;
$insertEditError= false;
$delete = false;
$delete_error = false;
if($_SERVER['REQUEST_METHOD']=='POST'){

    if(isset($_POST['snoEdit'])){
        $snoEdit = $_POST["snoEdit"];
        $titleEdit = $_POST["titleEdit"];
        $descEdit = $_POST["descEdit"];

        $sql="UPDATE `table1` SET `title` = '$titleEdit', `description` = '$descEdit' WHERE `table1`.`sno` = $snoEdit";
        $result= mysqli_query($conn,$sql);

        if($result){
            $insertEdit = true;
        }
        else{
            $insertEditError= true;
        }
    }


    else{
    $title = $_POST["title"];
    $desc = $_POST["desc"];

$sql = "INSERT INTO `table1` (`title`, `description`, `timestamp`) VALUES ('$title' , '$desc', current_timestamp())"; 
$result= mysqli_query($conn,$sql);

if($result){
    $insert = true;
}
else{
    $insert_error= true;
}
}
}

if(isset($_GET['delete'])){
    $sno = $_GET['delete'];
    $sql = "DELETE FROM `table1` WHERE `table1`.`sno` = $sno";
    $result= mysqli_query($conn,$sql);

    if($result){
        $delete = true;
    }
    else{
        $delete_error= true;
    }
}
?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>V-Notes</title>

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/datatables.min.css">
    </head>

    <body>

        <!-- Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editLabel">Edit Note</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <input type="hidden" name="snoEdit" id="snoEdit">
                                <label for="titleEdit" class="form-label">Title</label>
                                <input type="text" class="form-control" name="titleEdit" id="titleEdit">
                            </div>
                            <div class="mb-3">
                                <label for="descEdit" class="form-label">Description</label>
                                <textarea class="form-control" name="descEdit" id="descEdit" rows="3"></textarea>
                            </div>
                            <input class="btn btn-primary" type="submit" value="Update Note">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">V-Notes</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>

                    </ul>
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>

        <?php
        if($insert==true){
            echo '<div class="alert alert-success" role="alert">
            Note has been inserted succesfully
          </div>';
        }
        if($insert_error==true){
            echo '<div class="alert alert-danger" role="alert">
            Note can\'t be added due to some error
          </div>';
        }
        if($delete==true){
            echo '<div class="alert alert-success" role="alert">
            Note has been deleted succesfully
          </div>';
        }
        if($delete_error==true){
            echo '<div class="alert alert-danger" role="alert">
            Note can\'t be deleted due to some error
          </div>';
        }
        if($insertEdit==true){
            echo '<div class="alert alert-success" role="alert">
            Note has been updated succesfully
          </div>';
        }
        if($insertEditError==true){
            echo '<div class="alert alert-danger" role="alert">
            Note can\'t be updated due to some error
          </div>';
        }
        ?>
            <div class="container my-4">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" id="title">
                    </div>
                    <div class="mb-3">
                        <label for="desc" class="form-label">Description</label>
                        <textarea class="form-control" name="desc" id="desc" rows="3"></textarea>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Add Note">
                </form>
            </div>

            <div class="container">

                <table id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">S.no</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    $sql = "SELECT * FROM `table1`";
                    $result = mysqli_query($conn, $sql);

                    while($row = mysqli_fetch_assoc($result)){
                        echo "<tr>
                        <th scope='row'>{$row['sno']}</th>
                        <td>{$row['title']}</td>
                        <td>{$row['description']}</td>
                        <td><button id='{$row["sno"]}' class='edit btn btn-primary mx-1'>Edit</button><button id='d{$row["sno"]}' class='delete btn btn-danger mx-1'>Delete</button></td>
                    </tr>";
                        echo "<br>";
                    }
                    ?>


                    </tbody>
                </table>
            </div>



            <script src="js/bootstrap.bundle.min.js"></script>
            <script src="js/jquery-3.6.0.min.js"></script>
            <script src="js/datatables.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#myTable').DataTable();
                });
            </script>
            <script>
                const edits = document.getElementsByClassName('edit');
                const deletes = document.getElementsByClassName('delete');
                snoEdit = document.getElementById('snoEdit');
                titleEdit = document.getElementById('titleEdit');
                descEdit = document.getElementById('descEdit');
                Array.from(edits).forEach((element) => {
                    element.addEventListener("click", (e) => {
                        tr = e.target.parentNode.parentNode;
                        title = tr.getElementsByTagName("td")[0].innerText;
                        description = tr.getElementsByTagName("td")[1].innerText;
                        sno = e.target.id;
                        snoEdit.value = sno;
                        titleEdit.value = title;
                        descEdit.value = description;
                        $('#editModal').modal("toggle");
                        console.log(snoEdit);
                    });
                });

                Array.from(deletes).forEach((element) => {
                    element.addEventListener("click", (e) => {
                        sno = e.target.id.substr(1,)
                        if(confirm("Want to delete?")){
                            console.log("yes");
                            window.location=`index.php?delete=${sno}`;
                        }
                        else{
                            console.log("no");
                        }
                    });
                });
            </script>
    </body>

    </html>