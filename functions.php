<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "majorproject";
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) 
	{
	    die("Connection failed: " . $conn->connect_error);
	}
	
	function changeselectinput(){
		global $conn;
		$output='';
		$branch= mysqli_real_escape_string($conn, $_POST["branch"]);
		$year= mysqli_real_escape_string($conn, $_POST["year"]);
		$sem = mysqli_real_escape_string($conn, $_POST["sem"]);
		$query ="SELECT * FROM subjects
				WHERE branch='$branch' AND year ='$year' AND semester='$sem'";
		// die($query);
		$count_if_exsist=mysqli_num_rows(mysqli_query($conn,$query));
		if ($conn->connect_error) 
		{
		    die("Connection failed: " . $conn->connect_error);
		}else{
				if($count_if_exsist>0)
				{
					$output .='<option value="default" selected>Select Subject</option>';
					$result=mysqli_query($conn,$query);
					while ($row=mysqli_fetch_array($result)) 
					{
						$output .='<option value="'.$row["subjectode"].'">'.$row["subjectode"].'</option>';
					}
				}else{
					$output .='<option>Something went wrong</option>';
				}
		}
		echo $output;
	}

	function addstudent(){
		global $conn;
		$output ='';
		$name =mysqli_real_escape_string($conn,$_POST["studentname"]);
		$year = mysqli_real_escape_string($conn, $_POST["studentyear"]);
		$branch = mysqli_real_escape_string($conn , $_POST["studentbranch"]);
		$rollno = mysqli_real_escape_string($conn, $_POST["studentrollno"]);
		$addstudentquery = "INSERT INTO studentdetails(rollno, nameofstudent, studentbranch, studentyear)
					VALUES('$rollno','$name','$branch','$year')";
		if (mysqli_query($conn,$addstudentquery)){
			$output .='<p class="text-success"><br>Student Details Added Successfully</p>';
		}else{
			// $output .='<p class="text-danger"><br>Something went wrong</p>';
			$output .= mysqli_error($conn);
		}
		echo $output;
	}

	function addfaculty(){
		global $conn;
		$output ='';
		$name =mysqli_real_escape_string($conn, $_POST["facultyname"]);
		$emailid = mysqli_real_escape_string($conn, $_POST["facultyemailid"]);
		$uid = mysqli_real_escape_string($conn, $_POST["facultyid"]);
		$pass = mysqli_real_escape_string($conn , $_POST["facultyassignpassword"]);
		$options = [
			'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
		    'cost' => 12,
		];
		$hash = password_hash($pass, PASSWORD_BCRYPT, $options);
		$checkexistance ="SELECT * FROM facultydetails
						WHERE emailid='$emailid' OR username='$uid'";
		if (mysqli_query($conn,$checkexistance)){
			if ($conn->connect_error) 
			{
			    die("Connection failed: " . $conn->connect_error);
			}else{
					$count_if_exsist=mysqli_num_rows(mysqli_query($conn,$checkexistance));
					if($count_if_exsist>0)
					{
						$output .='<p class="text-danger">The given details already exsist in database</p>';
					}else{
						$addfacultyquery ="INSERT INTO facultydetails(facultyname,username,facultypassword, emailid)
							VALUES ('$name','$uid','$hash','$emailid')";
							if (mysqli_query($conn,$addfacultyquery)){
								$output .='<p class="text-success"><br>Faculty Details Added Successfully</p>';
							}else{
								// $output .='<p class="text-danger"><br>Something went wrong</p>';
								$output .= mysqli_error($conn);
							}		
					}
			}
		}
		echo $output;
	}
	function checkpass(){
	// 	global $conn;
	// 	$output ='';
	// 	$name =mysqli_real_escape_string($conn, $_POST["facultyname"]);
	// 	$emailid = mysqli_real_escape_string($conn, $_POST["facultyemailid"]);
	// 	$uid = mysqli_real_escape_string($conn, $_POST["facultyid"]);
	// 	$pass = mysqli_real_escape_string($conn , $_POST["facultyassignpassword"]);
	// 	$options = [
	// 	    'cost' => 10,
	// 	];
	// 	$hash = password_hash($pass, PASSWORD_BCRYPT, $options);
	// 	// echo $hash;
	// 	$query = "SELECT * FROM facultydetails
	// 				WHERE emailid='$emailid'";
	// 	if (mysqli_query($conn,$query)) {
	// 		$result=mysqli_query($conn,$query);
	// 		$row=mysqli_fetch_array($result);
	// 		$strdpass = $row["facultypassword"];
	// 		// echo $strdpass;
	// 	}
	// 	if (password_verify($pass, $strdpass)) {
	// 		echo 'Password is valid!';
	// 	} else {
	// 		echo 'Invalid password.';
	// 	}
	}

	function storefeedback(){
		global	$conn;
		$name = mysqli_real_escape_string($conn, $_POST["feedname"]);
		$email = mysqli_real_escape_string($conn, $_POST["feedemail"]);
		$subject = mysqli_real_escape_string($conn, $_POST["feedsubject"]);
		$messege =mysqli_real_escape_string($conn, $_POST["feedbackmsg"]);
		// echo $name.', '.$email.', '.$subject.', '.$messege;
		$submitquery = "INSERT INTO feedback(name, email, subject, messege)
						VALUES ('$name', '$email', '$subject', '$messege')";
		if(mysqli_query($conn,$submitquery)){
			if ($conn->connect_error) {
				echo $conn->connect_error;
			}else{
				echo "Thank you for submitting your query you will be contacted soon";
			}
		}
	}

	function showfeedbacks(){
		global $conn;
		$output ='';
		$showfeed ="SELECT * FROM feedback
					ORDER BY id DESC";
		if(mysqli_query($conn, $showfeed)){
			if ($conn->connect_error) {
				$output .="Connection Error : ". $conn->connect_error;
			}else{
				$count_if_exsist=mysqli_num_rows(mysqli_query($conn,$showfeed));
					if($count_if_exsist>0){
						$result=mysqli_query($conn,$showfeed);
						$output .='<br>';
						while ($row=mysqli_fetch_array($result)) 
						{
							$output .='<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
											<p>Name :&nbsp;'.$row["name"].'</p>
											<p> Subject :&nbsp;'.$row["subject"].'</p>
											<p> Messege :&nbsp;'.$row["messege"].'</p>
											<button type="button" href="#replymodal" class="btn btn-sm reply" name="reply" value="'.$row["id"].'" data-toggle="modal">Reply</button>
											<br>
											<hr>
									   </div>';
						}
					}else{
						$output .='<p class="text-primary">No feedback is available<p>';
					}
			}
		}
		echo $output;
	}

	function showattendance(){
		global $conn;
		$temp='';
		$output ='';
		$year = mysqli_real_escape_string($conn, $_POST["year"]);
		$branch =mysqli_real_escape_string($conn, $_POST["branch"]);
		$subject = mysqli_real_escape_string($conn , $_POST["subject"]);
		$fetchstudentquery = "SELECT * FROM studentdetails
							  WHERE studentbranch ='$branch' AND studentyear='$year' ";
		$output .='<h4 class="text-center modalheading">'.$branch.'&nbsp;'.$year.'&nbsp;Year Attendance Status</h4>
					<table class="table table-hover table-border text-center table-responsive-lg">
						<thead class="tablehead">
							<tr>
								<td>Roll No</td>
								<td>Subject</td>
								<td>Attendance</td>
								<td>Total Lecture</td>
								<td>Percentage</td>
							</tr>
						</thead>
						<tbody>
						<input type="hidden" name="subfilterbranch" id="subfilterbranch" value="'.$branch.'">
						<input type="hidden" name="subfilteryear" id="subfilteryear" value="'.$year.'">';
		if(mysqli_query($conn,$fetchstudentquery)){
			if($conn->connect_error){
				echo "Unable to connect with db becuase of :".$conn->connect_error;
			}else{
				$getrowsno = mysqli_num_rows(mysqli_query($conn,$fetchstudentquery));
				if($getrowsno>0){
					$resulta=mysqli_query($conn,$fetchstudentquery);
					while ($rowa =mysqli_fetch_array($resulta)){
						$temp=$rowa["rollno"];
						$getattendacestatusquery ="SELECT DISTINCT 	studentrollno FROM attendance
												   WHERE year='$year' AND branch ='$branch' AND studentrollno='$temp' ";
						if(mysqli_query($conn,$getattendacestatusquery)){
							if($conn->connect_error){
								echo "Error";
							}else{
								$count_if_exsist=mysqli_num_rows(mysqli_query($conn,$getattendacestatusquery));
								if($count_if_exsist>0){
									$result=mysqli_query($conn,$getattendacestatusquery);
									while ($row =mysqli_fetch_array($result)) {
										$currentrollno=$row["studentrollno"];
										$countquery1= "SELECT COUNT(attendance) FROM attendance 
														WHERE studentrollno='$currentrollno'AND subjectcode='$subject'";
										$countquery2= "SELECT COUNT(attendance) FROM attendance 
														WHERE studentrollno='$currentrollno'AND subjectcode='$subject' AND attendance='P'";
										$rs = mysqli_query($conn, $countquery2);
										$ds = mysqli_query($conn, $countquery1);
										$resultb = mysqli_fetch_array($rs);
										$resultc = mysqli_fetch_array($ds);
										$output .='
							<tr>					
								<td>'.$currentrollno.'</td>
								<td>'.$subject.'</td>
								<td>'.$resultb[0].'</td>
								<td>'.$resultc[0].'</td>
									'.countpercentage($resultb[0] ,$resultc[0]);
										$output .='
							</tr>';	
									}
								}else{
									$output .='<h4 class="modalheading">Please try again later</h4>';
								}
							}
						}
					}
				}else{
					$output .='<h4 class="modalheading text-warning">Please try again later</h4>';
				}
			}
		}
		$output .='
						</tbody>
					</table>';
		echo $output;
	}
	function countpercentage($x,$y,$z=75){
		$result ='';
		$z=(float)($z);
		if($y==0){
			$result ='<td class="text-warning">NA</td>';
		}else{
			$perct = (float)(($x/$y) * (100));
			if($perct < $z){
				$result = '<td class="text-danger">'.number_format((float)$perct, 2, '.', '');
			}else{
				$result = '<td class="text-success">'.number_format((float)$perct, 2, '.', '');
			}
			$result .='</td>';
		}
		return $result;
	}

	function showmarks(){
		global $conn;
		$output ='';
		$year = mysqli_real_escape_string($conn, $_POST["year"]);
		$branch =mysqli_real_escape_string($conn, $_POST["branch"]);
		$getmarksquery ="SELECT * FROM marks
									WHERE branch='$branch' AND year='$year'
									ORDER BY studentrollno ASC";
		// die($getmarksquery);
		if(mysqli_query($conn,$getmarksquery)){
			if($conn->connect_error){
				echo "Error";
			}else{
				$count_if_exsist=mysqli_num_rows(mysqli_query($conn,$getmarksquery));
				if($count_if_exsist>0){
					$output .='<h4 class="text-center modalheading">'.$branch.'&nbsp;'.$year.'&nbsp;Year Marks Status</h4>
								<input type="hidden" name="branchmarks" id="branchmarks" value="'.$branch.'">
								<input type="hidden" name="yearmarks" id="yearmarks" value="'.$year.'">
								<table class="table table-hover table-border text-center">
									<thead class="tablehead">
										<tr>
											<td>Roll No</td>
											<td>Subject</td>
											<td>CT 1</td>
											<td>CT 2</td>
											<td>Assignments</td>
										</tr>
									</thead>
									<tbody>
										<h5 class="text-warning text-center">
											Please select a subject
										</h5>
									</tbody>
								</table>';
				}else{
					$output .='<h4 class="modalheading">Please try again later</h4>';
				}
			}
		}
		echo $output;
	}

	function getstudents(){
		global $conn;
		$i ='1';
		$output ='';
		$year= mysqli_real_escape_string($conn, $_POST["attendanceyear"]);
		$branch =mysqli_real_escape_string($conn, $_POST["attendancebranch"]);
		$sem = mysqli_real_escape_string($conn, $_POST["attendancesem"]);
		$subject = mysqli_real_escape_string($conn, $_POST["attendancesubject"]);
		$date = mysqli_real_escape_string($conn, $_POST["dateofattendance"]);
		$getstudentsquery ="SELECT * FROM studentdetails
							WHERE studentbranch='$branch' AND studentyear='$year' 
							ORDER BY rollno ASC";
		// die($getstudentsquery);
		if(mysqli_query($conn, $getstudentsquery)){
			if ($conn->connect_error) {
				$output .="Connection Error : ". $conn->connect_error;
			}else{
				$count_if_exsist=mysqli_num_rows(mysqli_query($conn,$getstudentsquery));
					if($count_if_exsist>0){
						$result=mysqli_query($conn,$getstudentsquery);
						$output .='<br>';
						$output .='<form id="submitattendance" style="color:teal;">
										<input type="hidden" id="subjectcodeattendance" name="subjectcodeattendance" value="'.$subject.'">
										<input type="hidden" id="yearattendance" name="yearattendance" value="'.$year.'">
										<input type="hidden" id="semattendance" name="semattendance" value="'.$sem.'">
										<input type="hidden" id="branchattendance" name="branchattendance" value="'.$branch.'">
										<input type="hidden" id="dateattendance" name="dateattendance" value="'.$date.'">
									</form>
										<div class="row">
										';
						while ($row=mysqli_fetch_array($result)) 
						{			
							$output .=	'	<div class="form-check form-check-inline col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12">
										  		<input class="form-check-input" type="checkbox" name="studentrollnumber" value="'.$row["rollno"].'">
												<label class="form-check-label" for="inlineCheckbox1">'.$row["nameofstudent"].'</label>
											</div>';
						}
						$output .='		</div>';
					}else{
						$output .='<p class="text-primary">Sorry No student details are available<p>';
					}
			}
		}
		echo $output;
	}

	function addmarks(){
		global $conn;
		$output ='';
		$year= mysqli_real_escape_string($conn, $_POST["attendanceyear"]);
		$branch =mysqli_real_escape_string($conn, $_POST["attendancebranch"]);
		$sem = mysqli_real_escape_string($conn, $_POST["attendancesem"]);
		$subject = mysqli_real_escape_string($conn, $_POST["attendancesubject"]);
		$date = mysqli_real_escape_string($conn, $_POST["dateofattendance"]);
		$firstsessional ="firstsessional";
		$secondsessional ="secondsessional";
		$assignment="assignment";
		$getstudentsquery ="SELECT * FROM studentdetails
							WHERE studentbranch='$branch' AND studentyear='$year' 
							ORDER BY rollno ASC";
		// die($getstudentsquery);
		if(mysqli_query($conn, $getstudentsquery)){
			if ($conn->connect_error) {
				$output .="Connection Error : ". $conn->connect_error;
			}else{
				$count_if_exsist=mysqli_num_rows(mysqli_query($conn,$getstudentsquery));
					if($count_if_exsist>0){
						$result=mysqli_query($conn,$getstudentsquery);
						$output .='<p class="text-warning">If marks not available please set to zero</p>
								   	<table class="table table-hover table-border text-center table-responsive-lg">
								   		<thead class="tablehead">
								   			<tr>
								   				<th>Name</th>
								   				<th>CT 1</th>
								   				<th>CT 2</th>
								   				<th>Assignment</th>
								   			</tr>
								   		</thead>
								   		<tbody>
								   		<input type="hidden" name="marksbranch" id="marksbranch" value="'.$branch.'">
								   		<input type="hidden" name="marksyear" id="marksyear" value="'.$year.'">';
						while ($row=mysqli_fetch_array($result)) 
						{
						$output .='			<tr>
												<td>'.$row["nameofstudent"].'</td>
												<input type="hidden" name="rollno" value="'.$row["rollno"].'">
												<td>'.checkmarks($row["rollno"], $year, $branch, $subject, $firstsessional);
						$output .='				</td>
												<td>'.checkmarks($row["rollno"], $year, $branch, $subject, $secondsessional);
						$output .='				</td>
												<td>'.checkmarks($row["rollno"], $year, $branch, $subject, $assignment);
						$output .='				</td>
											</tr>';
						}
						$output .='		</tbody>
									</table>';
					}else{
						$output .='<p class="text-primary">Sorry No student details are available<p>';
					}
			}
		}
		echo $output;	
	}

	function checkmarks($roll, $year, $branch, $subject, $type){
		global $conn;
		$result = '';
		// die($roll.$year.$branch.$subject.$type);
		$checkexistance ="SELECT * FROM marks
							WHERE subject='$subject' AND year='$year' AND branch='$branch' AND studentrollno=$roll";
		// var_dump($checkexistance);
		if (mysqli_query($conn, $checkexistance)) {
			if ($conn->connect_error) {
				echo "Connection Error : ". $conn->connect_error;
			}else{
				$count_if_exsist=mysqli_num_rows(mysqli_query($conn,$checkexistance));
				if($count_if_exsist>=0){
					$result=mysqli_query($conn,$checkexistance);
					$row =mysqli_fetch_array($result);
					if ($row[$type]>0) {
						if ($type ==="firstsessional") {
							$result = '<input type="number" class="form-control" name="ctonemarks" max="30" min="0" value="'.$row[$type].'" readonly >';	
						}
						if ($type ==="secondsessional") {
							$result = '<input type="number" class="form-control" name="cttwomarks" max="30" min="0" value="'.$row[$type].'" readonly >';	
						}
						if ($type ==="assignment") {
							$result = '<input type="number" class="form-control" name="assignmarks" max="10" min="0" value="'.$row[$type].'" readonly >';	
						}
							$result .='<input type="hidden" name="dothis" value="update">';
					}else{
						if ($type ==="firstsessional") {
							$result = '<input type="number" class="form-control" name="ctonemarks" max="30" min="0" value="0" required>';	
						}
						if ($type ==="secondsessional") {
							$result = '<input type="number" class="form-control" name="cttwomarks" max="30" min="0" value="0" required>';	
						}
						if ($type ==="assignment") {
							$result = '<input type="number" class="form-control" name="assignmarks" max="10" min="0" value="0" required>';	
						}
						$result .='<input type="hidden" name="dothis" value="add">';
					}
					
				}else{
					$result = 'Something went wrong';
				}
			}
		}
		return $result;		
	}

	function saveattendance(){
		global $conn;
		$subject = mysqli_real_escape_string($conn, $_POST["subjectcodeattendance"]);
		$year = mysqli_real_escape_string($conn, $_POST["yearattendance"]);
		$sem = mysqli_real_escape_string($conn, $_POST["semattendance"]);
		$branch = mysqli_real_escape_string($conn, $_POST["branchattendance"]);
		$date = mysqli_real_escape_string($conn, $_POST["dateattendance"]);
		// $rollno = mysqli_real_escape_string($conn, $_POST["rollno"]);
		$fetchstudentquery = "SELECT * FROM studentdetails
								WHERE studentbranch='$branch' AND studentyear='$year'";
		if (mysqli_query($conn, $fetchstudentquery)) {
			if ($conn->connect_error) {
				echo "Connection Error : ". $conn->connect_error;
			}else{
				$count_if_exsist=mysqli_num_rows(mysqli_query($conn,$fetchstudentquery));
					if($count_if_exsist>0){
						$result=mysqli_query($conn,$fetchstudentquery);
						while ($row= mysqli_fetch_array($result)) 
						{
							foreach ($_POST["rollno"] as $rollno) {
								if ($row["rollno"]==$rollno) {
									$presentquery ="INSERT INTO attendance(date, subjectcode, studentrollno, attendance, year, sem, branch)
													VALUES ('$date','$subject','$rollno','P','$year','$sem','$branch')";
									if(mysqli_query($conn, $presentquery)){
										if ($conn->connect_error) {
											echo "Connection Error : ". $conn->connect_error;
										}
									}
								}
							}
							foreach ($_POST["absent"] as $absent) {
								if ($row["rollno"]==$absent) {
									$absentquery ="INSERT INTO attendance(date, subjectcode, studentrollno, attendance, year, sem, branch)
													VALUES ('$date','$subject','$absent','A','$year','$sem','$branch')";
									if(mysqli_query($conn, $absentquery)){
										if ($conn->connect_error) {
											echo "Connection Error : ". $conn->connect_error;
										}
									}
								}
							}
						}
					}else{
						echo "Something Went wrong try again later";
					}
			}
		}
	}

	function savemarks(){
		global $conn;
		$i=0;
		$roll=array();
		$ctone=array();
		$cttwo=array();
		$assign =array();
		$subject =mysqli_real_escape_string($conn,$_POST["subject"]);
		$year =mysqli_real_escape_string($conn,$_POST["year"]);
		$branch = mysqli_real_escape_string($conn, $_POST["branch"]);
		$todo = mysqli_real_escape_string($conn, $_POST["whattodo"]);
		foreach ($_POST["rollno"] as $rollno) {
			$i=$i+1;
			$roll[]=$rollno;
		}
		foreach ($_POST["ctonemarks"] as $ctonemarks) {
			$ctone[]=$ctonemarks;
		}
		foreach ($_POST["cttwomarks"] as $cttwomarks) {
			$cttwo[]=$cttwomarks;
		}
		foreach ($_POST["assignmarks"] as $assignmarks) {
			$assign[]=$assignmarks;
		}
		for ($j=0; $j <$i ; $j++) { 
			if ($todo === "update") {
				$savemarksquery = "UPDATE marks 
								   SET firstsessional ='$ctone[$j]' , secondsessional ='$cttwo[$j]' , assignment ='$assign[$j]'
								   WHERE subject ='$subject' AND studentrollno='$roll[$j]' AND year='$year' AND branch = '$branch'";
			}else{
				if ($todo === "add") {
					$savemarksquery = "INSERT INTO marks(subject, studentrollno, firstsessional, secondsessional,assignment,attendance,year,branch)
								VALUES ('$subject','$roll[$j]','$ctone[$j]','$cttwo[$j]','$assign[$j]','0','$year','$branch')";
				}
			}
			
			if (mysqli_query($conn, $savemarksquery)) {
				if ($conn->connect_error) {
					echo "Connection Error : ". $conn->connect_error;
				}
			}
		}
	}

	function getsubjects(){
		global $conn;
		$output ='';
		$branch =mysqli_real_escape_string($conn, $_POST["branch"]);
		$year = mysqli_real_escape_string($conn, $_POST["year"]);
		$getsubjectquery ="SELECT * FROM subjects
							WHERE branch='$branch' AND year='$year'";
		if(mysqli_query($conn, $getsubjectquery)){
			if($conn->connect_error){
				echo $conn->connect_error;
			}else{
				$count_if_exsist=mysqli_num_rows(mysqli_query($conn,$getsubjectquery));
				if($count_if_exsist>0)
				{
					$output .='<option value="default" selected>Select Subject</option>';
					$result=mysqli_query($conn,$getsubjectquery);
					while ($row=mysqli_fetch_array($result)) 
					{
						$output .='<option value="'.$row["subjectode"].'">'.$row["subjectode"].'</option>';
					}
				}else{
					$output .='<option>Something went wrong</option>';
				} 	
			}
		}
		echo $output;
	}

	function showparticularmarks(){
		global $conn;
		$output ='';
		$year = mysqli_real_escape_string($conn, $_POST["year"]);
		$branch =mysqli_real_escape_string($conn, $_POST["branch"]);
		$subject =mysqli_real_escape_string($conn, $_POST["subject"]);
		$marksfilterquery ="SELECT * FROM marks
							WHERE branch='$branch' AND year='$year' AND subject='$subject'
							ORDER BY studentrollno ASC";
		// die($marksfilterquery);
		$output .='	<input type="hidden" name="branchmarks" id="branchmarks" value="'.$branch.'">
					<input type="hidden" name="yearmarks" id="yearmarks" value="'.$year.'">';
		if(mysqli_query($conn,$marksfilterquery)){
			if($conn->connect_error){
				echo "Error";
			}else{
				$count_if_exsist=mysqli_num_rows(mysqli_query($conn,$marksfilterquery));
				if($count_if_exsist>0){
					$output .='<h4 class="text-center modalheading">'.$branch.'&nbsp;'.$year.'&nbsp;Year Marks Status</h4>
								<table class="table table-hover table-border text-center table-responsive-lg">
									<thead class="tablehead">
										<tr>
											<td>Roll No</td>
											<td>Subject</td>
											<td>CT 1</td>
											<td>CT 2</td>
											<td>Assignments</td>
										</tr>
									</thead>
									<tbody>';
					$result=mysqli_query($conn,$marksfilterquery);
					while ($row =mysqli_fetch_array($result)) {
						$output .='		<tr>
											<td>'.$row["studentrollno"].'</td>
											<td>'.$row["subject"].'</td>
											<td>'.$row["firstsessional"].'</td>
											<td>'.$row["secondsessional"].'</td>
											<td>'.$row["assignment"].'</td>
										</tr>';
					}
					$output .='		</tbody>
								</table>';
				}else{
					$output .='
					<h4 class="modalheading">Oops!! Its looks like you choosed wrong subject</h4>';
				}
			}
		}
		echo $output;
	}

		function showattendanceoverall(){
		global $conn;
		$temp='';
		$output ='';
		$year = mysqli_real_escape_string($conn, $_POST["year"]);
		$branch =mysqli_real_escape_string($conn, $_POST["branch"]);
		$fetchstudentquery = "SELECT * FROM studentdetails
							  WHERE studentbranch ='$branch' AND studentyear='$year' ";
		$output .='<h4 class="text-center modalheading">'.$branch.'&nbsp;'.$year.'&nbsp;Year Attendance Status</h4>
					<table class="table table-hover table-border text-center table-responsive-lg">
						<thead class="tablehead">
							<tr>
								<td>Roll No</td>
								<td>Attendance</td>
								<td>Total Lecture</td>
								<td>Percentage</td>
							</tr>
						</thead>
						<tbody>
						<input type="hidden" name="subfilterbranch" id="subfilterbranch" value="'.$branch.'">
						<input type="hidden" name="subfilteryear" id="subfilteryear" value="'.$year.'">';
		if(mysqli_query($conn,$fetchstudentquery)){
			if($conn->connect_error){
				echo "Unable to connect with db becuase of :".$conn->connect_error;
			}else{
				$getrowsno = mysqli_num_rows(mysqli_query($conn,$fetchstudentquery));
				if($getrowsno>0){
					$resulta=mysqli_query($conn,$fetchstudentquery);
					while ($rowa =mysqli_fetch_array($resulta)){
						$temp=$rowa["rollno"];
						$output .='
							<tr>					
								<td>'.$rowa["rollno"].'</td>';
						$getattendacestatusquery ="SELECT DISTINCT 	studentrollno, subjectcode FROM attendance
												   WHERE year='$year' AND branch ='$branch' AND studentrollno='$temp' ";
						if(mysqli_query($conn,$getattendacestatusquery)){
							if($conn->connect_error){
								echo "Error";
							}else{
								$count_if_exsist=mysqli_num_rows(mysqli_query($conn,$getattendacestatusquery));
								if($count_if_exsist>0){
									$result=mysqli_query($conn,$getattendacestatusquery);
									while ($row =mysqli_fetch_array($result)) {
										$currentrollno = $row["studentrollno"];
										$countquery1= "SELECT COUNT(attendance) FROM attendance 
														WHERE studentrollno='$currentrollno'";
										$countquery2= "SELECT COUNT(attendance) FROM attendance 
														WHERE studentrollno='$currentrollno' AND attendance='P'";
										$rs = mysqli_query($conn, $countquery2);
										$ds = mysqli_query($conn, $countquery1);
										$resultb = mysqli_fetch_array($rs);
										$resultc = mysqli_fetch_array($ds);
										
									}
									$output .='
								<td>'.$resultb[0].'</td>
								<td>'.$resultc[0].'</td>
								'.countpercentage($resultb[0] ,$resultc[0]);
								}else{
									$output .='<h4 class="modalheading">Please try again later</h4>';
								}
							}
						}
					}
				}
			}
		}
		$output .='
							</tr>				
						</tbody>
					</table>';
		echo $output;
	}

	function loginadmin(){
		global $conn;
		$name = mysqli_real_escape_string($conn, $_POST["adminusername"]);
		$pass = mysqli_real_escape_string($conn, $_POST["adminpassword"]);
		$options = [
		    'cost' => 12,
		];
		$hash = password_hash($pass, PASSWORD_BCRYPT, $options);
		// echo $hash;
		$query = "SELECT * FROM admincredentials
					WHERE adminid='$name'";
		if (mysqli_query($conn,$query)) {
			$result=mysqli_query($conn,$query);
			$row=mysqli_fetch_array($result);
			$strdpass = $row["adminpass"];
		}
		if (password_verify($pass, $strdpass)) {
			$_SESSION["admin"] = $row["adminid"];
			$_SESSION["mail"] =$row["adminemail"];
			$_SESSION["login"]= $row["lastlogin"];
			echo "success";
		} else {
			echo 'Invalid password.';
		}
	}

	function loginfaculty(){
		global $conn;
		$name = mysqli_real_escape_string($conn, $_POST["faultyusername"]);
		$pass = mysqli_real_escape_string($conn, $_POST["facultypassword"]);
		$options = [
		    'cost' => 12,
		];
		$hash = password_hash($pass, PASSWORD_BCRYPT, $options);
		// echo $hash;
		$query = "SELECT * FROM facultydetails
					WHERE username='$name'";
		if (mysqli_query($conn,$query)) {
			$result=mysqli_query($conn,$query);
			$row=mysqli_fetch_array($result);
			$strdpass = $row["facultypassword"];
		}
		if (password_verify($pass, $strdpass)) {
			$_SESSION["name"] = $row["facultyname"];
			$_SESSION["id"] =$row["id"];
			echo "success";
		} else {
			echo 'Invalid password.';
		}
	}

	function recoverpass(){
		global $conn;
		$username = mysqli_real_escape_string($conn, $_POST["username"]);
		$emailid = mysqli_real_escape_string($conn, $_POST["useremail"]);
		$usertype = mysqli_real_escape_string($conn , $_POST["usertype"]);
		// die($usertype);
		$uniquecode=md5(uniqid(rand()));
		$hash=base64_encode($uniquecode);
		// $hash = password_hash($uniquecode, PASSWORD_BCRYPT, $options);
		// die($hash);
		if ($usertype==="admin") {
			// die("admin hu main");
		$checkexistance ="SELECT * FROM admincredentials
						WHERE adminemail='$emailid' AND adminid='$username' " ;
		}else{
			if ($usertype==="faculty") {
				// die("faculty hu main");
			$checkexistance ="SELECT * FROM facultydetails
							WHERE emailid='$emailid' OR username='$username' " ;
			}else{
				die('<p class="text-danger">Please follow the correct path</p>');
				// die();
			}
		}
		// var_dump($checkexistance);
		if (mysqli_query($conn,$checkexistance)){
			if ($conn->connect_error) 
			{
			    die("Connection failed: " . $conn->connect_error);
			}else{
					$count_if_exsist=mysqli_num_rows(mysqli_query($conn,$checkexistance));
					// var_dump($count_if_exsist);
					if($count_if_exsist>0)
					{
						if ($usertype==="admin") {
						$store_token="UPDATE admincredentials SET passkey='$uniquecode' 
									  WHERE  adminemail='$emailid' AND adminid='$username'";
						}
						if ($usertype==="faculty") {
						$store_token="UPDATE facultydetails SET passkey='$uniquecode' 
									  WHERE emailid='$emailid' AND username='$username'";
						}
						mysqli_query($conn, $store_token);
						if ($conn->query($store_token) == TRUE){
							// echo "no prblm";
							require 'PHPMailer/PHPMailerAutoload.php';
							$mail = new PHPMailer;

							$mail->isSMTP();
							$mail->Host = 'smtp.gmail.com';
							$mail->SMTPAuth = true;
							$mail->Username = 'vivekhrd330@gmail.com';
							$mail->Password = '';
							$mail->SMTPSecure = 'tls';

							$mail->From = 'vivekhrd330@gmail.com';
							$mail->FromName = 'Vivek Kumar Gupta';
							$mail->addAddress($emailid,$username );

							$mail->addReplyTo('vivekhrd330@gmail.com', 'Vivek');

							$mail->WordWrap = 50;
							$mail->isHTML(true);

							$mail->Subject = 'Please verify your account';
							$mail->Body    = '<a href="http://localhost/majorproject/recover.php?passkey='.$hash.'"> Click Here </a> to verify your email id and recover your password';

							if(!$mail->send()) {
							   echo 'Message could not be sent.';
							   echo 'Mailer Error: ' . $mail->ErrorInfo;
							   exit;
							}
						    echo '<h3 class="alert alert-success">Request has been accepted, Please check your mail</h3>';
						 }else{
								// echo "prblm";
								echo "Error:"  . $store_token . "<br>" . $conn->error;
							}	
					}else{
						echo '<p class="text-danger"><br>Sorry wrong credentials</p>';
					}
			}
		}
	}

	function changeadminpassword(){
		global $conn;
		$oldpassword = mysqli_real_escape_string($conn, $_POST["adminpreviouspass"]);
		$newpassword = mysqli_real_escape_string($conn, $_POST["adminnewpass"]);
		$adminid = mysqli_real_escape_string($conn, $_POST["uid"]);
		// die($adminid);
		$options = [
		    'cost' => 12,
		];
		$hash = password_hash($oldpassword, PASSWORD_BCRYPT, $options);
		$anotherhash = password_hash($newpassword, PASSWORD_BCRYPT, $options);
		// echo $hash;
		$query = "SELECT * FROM admincredentials
					WHERE adminid='$adminid'";
		if (mysqli_query($conn,$query)) {
			$result=mysqli_query($conn,$query);
			$row=mysqli_fetch_array($result);
			$strdpass = $row["adminpass"];
		}
		if (password_verify($oldpassword, $strdpass)) {
			$updatepass =" UPDATE admincredentials SET adminpass='$anotherhash'
						   WHERE  adminid='$adminid'";
			if (mysqli_query($conn,$updatepass)) {
				echo '<p class="text-success">Password Changed Successfully</p>';
			}else{
				echo '<p class="text-warning">something went wrong try again later</p>';
			}
		} else {
			echo '<p class="text-danger">Your old password is wrong</p>';
		}
	}

	function changefacultypassword(){
		global $conn;
		$oldpassword = mysqli_real_escape_string($conn, $_POST["facultypreviouspass"]);
		$newpassword = mysqli_real_escape_string($conn, $_POST["facultynewpass"]);
		$facultyid = mysqli_real_escape_string($conn, $_POST["facultyid"]);
		// die($adminid);
		$options = [
		    'cost' => 12,
		];
		$hash = password_hash($oldpassword, PASSWORD_BCRYPT, $options);
		$anotherhash = password_hash($newpassword, PASSWORD_BCRYPT, $options);
		// echo $hash;
		$query = "SELECT * FROM facultydetails
					WHERE id='$facultyid'";
		if (mysqli_query($conn,$query)) {
			$result=mysqli_query($conn,$query);
			$row=mysqli_fetch_array($result);
			$strdpass = $row["facultypassword"];
		}
		if (password_verify($oldpassword, $strdpass)) {
			$updatepass =" UPDATE facultydetails SET facultypassword='$anotherhash'
						   WHERE  id='$facultyid'";
			if (mysqli_query($conn,$updatepass)) {
				echo '<p class="text-success">Paswword Changed Successfully</p>';
			}else{
				echo '<p class="text-warning">something went wrong try again later</p>';
			}
		} else {
			echo '<p class="text-danger">Your old password is wrong</p>';
		}
	}

	function endofsession(){
		echo '<p class="text-warning"> Academic session is declared to be end, please register new students</p>';
	}

	function filterdata(){
		global $conn;
		$output ='';
		$firstdate = mysqli_real_escape_string($conn, $_POST["firstdate"]);
		$seconddate = mysqli_real_escape_string($conn, $_POST["seconddate"]);
		$percent = mysqli_real_escape_string($conn, $_POST["percent"]);
		$year = mysqli_real_escape_string($conn, $_POST["filteryear"]);
		$branch =mysqli_real_escape_string($conn, $_POST["filterbranch"]);	
		$filterquery = "SELECT * FROM studentdetails
							  WHERE studentbranch ='$branch' AND studentyear='$year' ";
		$output .='<h4 class="text-center modalheading">'.$branch.'&nbsp;'.$year.'&nbsp;Year Attendance Status</h4>
					<table class="table table-hover table-border text-center table-responsive-lg">
						<thead class="tablehead">
							<tr>
								<td>Roll No</td>
								<td>Attendance</td>
								<td>Total Lecture</td>
								<td>Percentage</td>
							</tr>
						</thead>
						<tbody>
						<input type="hidden" name="subfilterbranch" id="subfilterbranch" value="'.$branch.'">
						<input type="hidden" name="subfilteryear" id="subfilteryear" value="'.$year.'">';
		if(mysqli_query($conn,$filterquery)){
			if($conn->connect_error){
				echo "Unable to connect with db becuase of :".$conn->connect_error;
			}else{
				$getrowsno = mysqli_num_rows(mysqli_query($conn,$filterquery));
				if($getrowsno>0){
					$resulta=mysqli_query($conn,$filterquery);
					while ($rowa =mysqli_fetch_array($resulta)){
						$temp=$rowa["rollno"];
						$output .='
							<tr>					
								<td>'.$rowa["rollno"].'</td>';
						$getattendacestatusquery ="SELECT DISTINCT 	studentrollno, subjectcode FROM attendance
												   WHERE year='$year' AND branch ='$branch' AND studentrollno='$temp'";
						// die($getattendacestatusquery);
						if(mysqli_query($conn,$getattendacestatusquery)){
							if($conn->connect_error){
								echo "Error";
							}else{
								$count_if_exsist=mysqli_num_rows(mysqli_query($conn,$getattendacestatusquery));
								// var_dump($count_if_exsist);
								if($count_if_exsist>0){
									$result=mysqli_query($conn,$getattendacestatusquery);
									while ($row =mysqli_fetch_array($result)) {
										$currentrollno = $row["studentrollno"];
										$countquery1= "SELECT COUNT(attendance) FROM attendance 
														WHERE studentrollno='$currentrollno' AND (date BETWEEN '$firstdate' AND '$seconddate')";
										$countquery2= "SELECT COUNT(attendance) FROM attendance 
														WHERE studentrollno='$currentrollno' AND attendance='P'AND (date BETWEEN '$firstdate' AND '$seconddate')";
										if(mysqli_query($conn,$getattendacestatusquery)){
											if($conn->connect_error){
												echo "Error";
											}
										}	
										$rs = mysqli_query($conn, $countquery2);
										$ds = mysqli_query($conn, $countquery1);
										$resultb = mysqli_fetch_array($rs);
										$resultc = mysqli_fetch_array($ds);
										
									}
									$output .='
								<td>'.$resultb[0].'</td>
								<td>'.$resultc[0].'</td>
								'.countpercentagewithfilter($resultb[0] ,$resultc[0] , $percent);
								}else{
									$output .='<h4 class="modalheading">Please try again later</h4>';
								}
							}
						}
					}
				}
			}
		}
		$output .='
							</tr>				
						</tbody>
					</table>';
		echo $output;	
	}

	function countpercentagewithfilter($x,$y,$z){
		$result ='';
		$z=(float)($z);
		if($y==0){
			$result ='<td class="text-warning">NA</td>';
		}else{
			$perct = (float)(($x/$y) * (100));
			if($perct < $z){
				$result = '<td class="text-danger">'.number_format((float)$perct, 2, '.', '');
			}else{
				$result = '<td class="text-success">'.number_format((float)$perct, 2, '.', '');
			}
			$result .='</td>';
		}
		return $result;
	}

	function passwordrecover(){
		global $conn;
		$newpass = mysqli_real_escape_string($conn, $_POST["newpass"]);
		$recoverkey = mysqli_real_escape_string($conn, $_POST["recoverkey"]);
		$usertype = mysqli_real_escape_string($conn, $_POST["uservalue"]);
		$options = [
		    'cost' => 12,
		];
		$hash = password_hash($newpass, PASSWORD_BCRYPT, $options);
		if ($usertype === "admin") {
			$changepasswordquery = "UPDATE admincredentials SET passkey='0', adminpass='$hash' 
					  WHERE  passkey ='$recoverkey'";
		}else{
			if ($usertype === "faculty") {
				$changepasswordquery = "UPDATE facultydetails SET passkey='0', facultypassword='$hash' 
					  WHERE  passkey ='$recoverkey'";
			}else{
				die('<p class="text-danger">Something went wrong please try again later!</p>');
			}
		}
		if(mysqli_query($conn,$changepasswordquery)){
			if($conn->connect_error){
				echo "Error";
			}else{
				echo '<p class="text-success"> Your Password has been updated successfully please login login again with new password</p>';
			}
		}
	}

	function getfeedbackdata(){
		global $conn;
		$output='';
		$msgid = mysqli_real_escape_string($conn, $_POST["msgid"]);
		$showfeed ="SELECT * FROM feedback
					WHERE id='$msgid'";
		if(mysqli_query($conn, $showfeed)){
			if ($conn->connect_error) {
				$output .="Connection Error : ". $conn->connect_error;
			}else{
				$count_if_exsist=mysqli_num_rows(mysqli_query($conn,$showfeed));
				if($count_if_exsist>0){
					$result=mysqli_query($conn,$showfeed);
					$output .='<br>';
					$row=mysqli_fetch_array($result);
					echo $row["email"].','.$row["subject"].','.$row["name"].','.$row["id"];
				}
			}
		}
	}

	function sendmsg(){
		global $conn;
		$subject = mysqli_real_escape_string($conn, $_POST["sendersubject"]);
		$msg = mysqli_real_escape_string($conn, $_POST["replymsg"]);
		$reciever = mysqli_real_escape_string($conn, $_POST["senderemail"]);
		$username = mysqli_real_escape_string($conn, $_POST["sendername"]);
		$msgid = mysqli_real_escape_string($conn, $_POST["msgid"]);
		// echo $subject.$msg.$reciever;
		require 'PHPMailer/PHPMailerAutoload.php';
		$mail = new PHPMailer;

		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'vivekhrd330@gmail.com';
		$mail->Password = '';
		$mail->SMTPSecure = 'tls';

		$mail->From = 'vivekhrd330@gmail.com';
		$mail->FromName = 'Vivek Kumar Gupta';
		$mail->addAddress($reciever,$username );

		$mail->addReplyTo('vivekhrd330@gmail.com', 'Vivek');

		$mail->WordWrap = 50;
		$mail->isHTML(true);

		$mail->Subject = $subject;
		$mail->Body    = $msg;

		if(!$mail->send()) {
		   echo 'Message could not be sent.';
		   echo 'Mailer Error: ' . $mail->ErrorInfo;
		   exit;
		}else{
			$deletemsg = " DELETE FROM feedback
						  WHERE id= '$msgid' ";
			if ($conn->query($deletemsg) === TRUE) {
			    echo '<p class="text-success">Your response to query is mailed, Thank You!</p>';
			} else {
			    echo "Error deleting record: " . $conn->error;
			}
		}
	}

?>