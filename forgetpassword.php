<!DOCTYPE html>
<html>
<head>
	<title>Forget Password</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Farsan|Indie+Flower|Itim|Mina|Sacramento|Nunito" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-grid.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-grid.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-reboot.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-reboot.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style="background-color:aliceblue;">
	<header class="fixed-top">
		<nav class="navbar navbar-expand-lg navbar-light" style="background: linear-gradient(45deg, #1de099, #1dc8cd);">
  			<a class="navbar-brand" href="#" style="font-family: 'Itim', cursive; font-weight: bold; font-size: 20px;">Student Record Management System</a>
		</nav>		
	</header>
	<div class="main_div">
		<div class="row">
			<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-12">
				<p class="maintext">Welcome<br>to<br>&quot;Student Record Managment System&quot;</p>
			</div>
		</div>
		<div id="facultypagediv" class="container col-lg-8">
			<center><br>
			<div class="">
	      			<p style="font-size: 18px; line-height: 18px; color: ghostwhite;">We are sorry that you forget your password, please fill the given form and you will recieve a link through gmail to reset the password</p>
	      	</div>
			<div id="passwordrecoveryerror">
				
			</div>
	      	<form id="passwordrecoveryform">
	      		<?php
		      		if(isset($_GET["user"]))
					{
						$user=$_GET['user'];
	      		?>
	      				<input type="hidden" name="usertype" id="usertype" value="<?php echo $user;?>">
	      		<?php
	      			}else{
	      		?>
	      				<input type="hidden" name="usertype" id="usertype" value="faculty">
	      		<?php
	      			}
	      		?>
	      		<div class="form-group col-lg-6 col-xl-6 col-md-6 col-sm-12 col-12">
	      			<input class="form-control" type="text" name="username" id="username" placeholder="Enter your username" required>
	      		</div>
	      		<div class="form-group col-lg-6 col-xl-6 col-md-6 col-sm-12 col-12">
	      			<input class="form-control" type="email" name="useremail" id="useremail" placeholder="Enter email address" required>
	      		</div>
	      	</form>
	      	<button class="btn btn-sm dismissbtn" type="submit" title="Recover Password" id="recoverpass" name="recoverpass">Recover Password</button>&nbsp;&nbsp;
	      	<a href="index.php"><button class="btn btn-sm dismissbtn" type="submit" title="Home">Back to home</button></a>
	      	</center>
	      	<br>
		</div>
	</div>
	<br>
	<footer id="footer_faculty">
		<div class="site_footer">
				<p class="copyrighttext text-center" style="padding-bottom: 10px; margin-bottom: 0px;">
					&copy; THDC IHET || <?php echo date('Y');?> || <a href="#developermodal" data-toggle="modal">Team</a>
				</p>
		</div>
	</footer>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="main.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap.bundle.js"></script>
<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>



<!-- Modal -->
<div class="modal fade" id="developermodal" tabindex="-1" role="dialog" aria-labelledby="developermodalTitle" aria-hidden="true" style="background: linear-gradient(45deg, #1de099, #1dc8cd);">
 	<div class="modal-dialog modal-dialog-centered" role="document">
    	<div class="modal-content">
      		<div class="modal-header modalstyle">
	        	<h5 class="modal-title" id="developermodaltitle">Developers</h5>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          	<span aria-hidden="true">&times;</span>
	        	</button>
      		</div>
      		<div class="modal-body">
      			<div class="container-fluid">
	      			<div class="row">
	      				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
	      				<center>
		      				<h3 style="padding-top: 40px; font-family: 'Indie Flower', cursive; font-weight:bolder;">Guide</h3>
							<span class="sectiondivider"></span>
							<img src="images/pspandey.jpg" class="img-thumbnail rounded-circle">
							<p class="foocolext">Mr. P. S. Pandey<br>Assitant Prof. ECE Dept.</p>
						</center>
						</div>
	      			</div>
	      			<center>
	      			<h3 style="padding-top: 40px; font-family: 'Indie Flower', cursive; font-weight:bolder;">Students</h3>
					<span class="sectiondivider"></span>
					</center>
	      			<div class="row">
	      				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
	      					<center>
		      					<img src="images/ankuj.jpg" class="img-thumbnail rounded-circle">
								<p class="foocolext">Ankuj Bisht</p>
							</center>
	      				</div>
	      				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
	      					<center>
		      					<img src="images/nidhi.jpeg" class="img-thumbnail rounded-circle">
								<p class="foocolext">Nidhi Gagat</p>
							</center>
	      				</div>
	      				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
	      					<center>
		      					<img src="images/vkg.jpeg" class="img-thumbnail rounded-circle">
								<p class="foocolext">Vivek Kumar Gupta</p>
							</center>
	      				</div>
	      			</div>
      			</div>
      		</div>
      		<div class="modal-footer modalstyle">
        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      		</div>
    	</div>
  	</div>
</div>
</html>