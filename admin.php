<?php 
    require 'config.php'; 

    session_start();
    if (!empty($_POST["username"])) {
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);
        $sql = "SELECT * from user where username='$username' and password='$password' LIMIT 1";
        $res = $conn->query($sql);

        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
            //set session
            $_SESSION['username']   = $row['username']; 
            $_SESSION['name']       = $row['name']; 
        }else{
            echo '<script language="javascript">';
            echo 'alert("Wrong Username or Password !!")';
            echo '</script>';
        }
    }

    //for upload image
    if (!empty($_POST['file_code'])) {
        $file_code      = mysqli_real_escape_string($conn, $_POST['file_code']);
        $rand_name      = rand(111,999);
        $image_name     = $_FILES['image']['name'] ;
        $image_tmp_name = $_FILES['image']['tmp_name'] ;
        $file_type      = $_FILES['image']['type']; 

        if($_FILES["image"]["type"]=="image/jpeg" || $_FILES["image"]["type"]=="image/gif" || $_FILES["image"]["type"]=="image/png"){
            $target_file = "./uploads/";
            $f_name      = $rand_name."_".$image_name;
            $target_fileItems = $target_file . basename($f_name);
            // if folder not exists than it will make folder.

            if(!file_exists($target_file))
            {
                   mkdir($target_file, 0777, true);
            }

            if(move_uploaded_file($image_tmp_name, $target_fileItems))
            {
                $sql = "INSERT INTO file (code, image)
                        VALUES ('$file_code', '$f_name')";
                if ($conn->query($sql) === TRUE) {
                    echo '<script language="javascript">';
                    echo 'alert("file successfully uploaded")';
                    echo '</script>';
                    header("Refresh:0");
                } else {
                    unlink($target_fileItems);
                    echo '<script language="javascript">';
                    echo 'alert("error in file upload")';
                    header("Refresh:0");
                }
                
            }
            else
            {
                echo '<script language="javascript">';
                echo 'alert("error in file upload")';
                header("Refresh:0");
            }
        }else {
            echo '<script language="javascript">';
            echo 'alert("Only jpg, gif, and png files are allowed.")';
            echo '</script>';
            header("Refresh:0");
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="mvga" />
        <meta name="author" content="mvga" />
        <title>ADMIN PANEL</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap-->
        <link href="css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap5.min.css">
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body class="d-flex flex-column h-100" style="background-color: #f5f4f0;">
        <main class="flex-shrink-0" style="background-color: #f5f4f0;">
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-mvga" style="background-color: #f5f4f0;">
                <div class="container px-5">
                    <div class="d-grid text-center">
                        <img class="img-fluid rounded-2 my-0 mx-auto d-block" src="img/mvgaa-seal.png" alt="mvga-logo" />
                    </div>
                	<h1 class="display-4 fw-bold text-mvga-orange">MVGAA</h1>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse " id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item"><button class="btn btn-mvga btn-sm text-white"><a class="nav-link ahref-white" href="index.php">Go Back Home</a></button></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Header-->
            <header class="bg-mvga py-3" style="background-color: #f5f4f0;">
                <div class="container px-5">
                    <div class="row gx-5 align-items-center justify-content-center p-3">
                        <div class="col-lg-12 col-xl-12">
                            <h1 class="fw-bold mb-0 text-center">Admin Panel</h1>
                            <p class="text-center mb-2"><small><?php 
                                    if(isset($_SESSION['name'])){
                                       echo "Hi, ".$_SESSION['name']; 
                                    }
                                 ?></small></p>
                        </div>                        
                    </div>
                </div>
            </header>
            <?php if (isset($_SESSION['username'])) { ?>
            <div class="container px-5">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-10 col-xl-10 bg-white p-2 mb-3 gmd gmd-1">
                        <form action="admin.php" method="POST" enctype="multipart/form-data">
                        <h2 class="fw-normal mb-2 mt-2 text-center">Upload Image</h2>
                        <div class="container mt-5">
                         <div class="row">
                            <div class="mb-3 col-xl-6">
                                <label for="file-code" class="form-label">File Code</label>
                                <input type="text" name="file_code" class="form-control" id="file-code" aria-describedby="file-code" required="">
                            </div>
                            <div class="mb-3 col-xl-6">
                                <label for="file-code" class="form-label">Choose a Image</label>
                                <input type="file" name="image" class="form-control" id="choose-image" aria-describedby="choose-image" aria-label="Upload" required="">
                            </div>
                         </div>
                         <div class="row">
                            <div class="mb-3 col-xl-6">
                              <button type="submit" class="btn btn-mvga mb-3 text-white">Submit</button>
                            </div>
                         </div>
                        </div>
                        </form>
                    </div>
                </div>
                <!-- table -->
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-10 col-xl-10 p-2 mb-3">
                        <table class="table table-striped" width="100%" id="data_file">
                            <thead>
                                <th>No</th>
                                <th>Image</th>
                                <th>Code</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php 
                                    $sql = "SELECT * from file order by file_id asc";
                                    $res = $conn->query($sql);
                                    if($res->num_rows > 0){
                                        $key=1;
                                        for ($i=0; $i < $res->num_rows ; $i++) { 
                                            $row = $res->fetch_assoc();
                                        ?>
                                            <tr>
                                                <td><?php echo $key; ?></td>
                                                <td><?php echo '<a id="single_image" href="./uploads/'.$row['image'].'"><img src="./uploads/'.$row['image'].'" class="img img-thumbnail " style="max-width:100px"></a>'; ?></td>
                                                <td><?php echo $row['code']; ?></td>
                                                <td><a href="javascript:remove_file(<?php echo $row['file_id']; ?>)" class="text-danger">remove</a></td>
                                            </tr>
                                    <?php $key++;}
                                    }else{ ?>
                                            <tr>
                                                <td></td><td></td><td></td><td></td>
                                            </tr>   
                                    <?php }
                                    
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php }else{ ?>
            <div class="container px-5">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-10 col-xl-10 bg-white p-2 mb-3 gmd gmd-1">
                        <form action="admin.php" method="POST">
                        <h2 class="fw-normal mb-2 mt-2 text-center">Login Form</h2>
                        <div class="container mt-5">
                         <div class="row">
                            <div class="mb-3 col-xl-6">
                                <label for="file-code" class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" id="username" aria-describedby="username" required="">
                            </div>
                            <div class="mb-3 col-xl-6">
                                <label for="file-code" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password" aria-describedby="password" required="">
                            </div>
                         </div>
                         <div class="row">
                            <div class="mb-3 col-xl-6">
                              <button type="submit" class="btn btn-mvga mb-3 text-white">Submit</button>
                            </div>
                         </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
            
        </main>
        <!-- Footer-->
        <footer class="bg-mvga py-1 mt-auto" style="background-color: #f5f4f0;">
            <div class="container px-5">
                <div class="row align-items-center justify-content-between flex-column">
                    <div class="col-auto">
                    	<div class="small m-0 text-black">Copyright &copy; MVGA 2024</div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap5.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script>
            $(document).ready(function() {
                $('#data_file').DataTable();
            });
			
            //delete file 
            function remove_file(id){
                var result = confirm("Want to delete?");
                if (result) {
                    document.location = "delete.php?id="+id;
                }
            }
        </script>
    </body>
</html>
