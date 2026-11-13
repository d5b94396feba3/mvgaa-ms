<?php 
	require 'config.php';
	session_start();
	session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="mvga" />
        <meta name="author" content="mvga" />
        <title>WELCOME TO MVGAA SITE</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap-->
        <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,600,700&display=swap" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body class="d-flex flex-column h-100" style="background-color: #9e9e9e;">
        <main class="flex-shrink-0" style="background-color: #9e9e9e;">
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-mvga" style="background-color: #9e9e9e;">
                <div class="container px-5">
                	<button class="btn btn-mvga fw-bolder text-white">
                		MVGAA
                	</button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse " id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link ahref-black" href="index.php">Home</a></li>
                            <!-- <li class="nav-item"><a class="nav-link ahref-black" href="admin.php">Login</a></li> -->
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Header-->
            <header class="bg-mvga py-3" style="background-color: #9e9e9e;">
                <div class="container px-5">
                    <div class="row no-gutters align-items-center justify-content-center bg-mvga p-3">
                    	<?php
                    		if (!empty($_POST['file_code'])) { 
                    			$file_code = mysqli_real_escape_string($conn, $_POST['file_code']);
                    			$sql = "SELECT * from file where code='".$file_code."' LIMIT 1";
						        $res = $conn->query($sql);
                    		?>
                    		 		<div class="col-lg-12 col-xl-12 col-xxl-12 bg-mvga text-center" style="min-height: 400px;">
                    		 			<?php 
                    		 				if($res->num_rows > 0){
									            $row = $res->fetch_assoc();
                    		 					echo '<img class="img-fluid" src="./uploads/'.$row['image'].'">';
                    		 				}else{
                    		 					echo '<h2 class="p-5">Unrecognized Code !</h2>';
                    		 				}
                    		 			?>
                    		 			
                    		 		</div>
                    		 		<div class="col-lg-12 col-xl-12 col-xxl-12 text-center mt-2">
                    		 			<button class="btn btn-mvga fw-normal text-white" onclick="window.location.replace('index.php')">Enter another code</button>
                    		 		</div>
                    		<?php } else { ?>
                    		 		<div class="col-lg-6 col-xl-6 col-xxl-6 bg-p" style="height:500px;">
			                            <!-- <div class="my-5 text-center text-xl-start">
			                                <h1 class="display-5 fw-bolder mb-2 text-center text-mvga-orange">MVGA</h1>
			                                <p class="lead fw-bolder mb-2 text-center">
			                                	MASTER VALUE GEMOLOGIST ASSOCIATION <br> AUCTION APPARAISALS</p>
			                                <div class="d-grid text-center">
			                                    <img class="img-fluid rounded-2 my-0 mx-auto d-block" src="img/mvga-logo-latest.png" alt="mvga-logo" style="width:280px" />
			                                </div>
			                                <p class="fw-bolder mt-0 text-center text-mvga-orange">
			                                www.MVGAAA.com
			                                </p>
			                            </div> -->
			                        </div>
			                        <div class="col-lg-6 col-xl-6 col-xxl-6" style="height:603px;border: solid 1px gray;">
			                        	<p class="lead fw-bolder text-center text-white mt-4 mb-4 pb-5">
			                            	<!-- CERTIFICATE AND APPRAISAL -->
			                            </p>
			                           <div class="row bg-mvga col-lg-9 p-3 mx-auto d-block">
			                           	<h1 class="display-5 fw-bolder mb-2 text-center">
			                            	APPRAISEL <span class="fw-normal">ACCESS!</span>
			                            </h1>
			                            <p class="fw-normal text-center mb-4">Please Enter The JEWELRY APPRAISAL CODE Found on the Appraisal and click ENTER</p>
			                            <form action="index.php" method="POST">
										  <div class="col-lg-9 mb-3 mx-auto d-block">
										    <input type="text" name="file_code" class="form-control" id="code" placeholder="Enter your code" required="">
										  </div>
										  <button type="submit" class="btn btn-mvga mx-auto d-block mb-3 text-white" id="btnApply">ENTER</button>
										</form>
									   </div>
			                        </div>
                    	<?php 	} 
                    	?>
                    </div>
                </div>
            </header>
        </main>
        <!-- Footer-->
        <footer class="bg-mvga py-0 mt-auto" style="background-color: #9e9e9e;">
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
        <script src="js/flatshadow.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script>
        	//additional for mvga
        	$(".flat-icon").flatshadow({
			  fade: true,
			  angle: "SE",
			  boxShadow: "#b37a37"
			});

        	var el = document.getElementById("code");
			var wd = el.offsetWidth;
			   document.getElementById("btnApply").style.width = wd+".px";

        	window.addEventListener('resize', function(event) {
			var el = document.getElementById("code");
			var wd = el.offsetWidth;
			   document.getElementById("btnApply").style.width = wd+".px";
			}, true);
			
        </script>
    </body>
</html>