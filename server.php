<?php 
	session_start();
	$servername="localhost";
	$username="root";
	$password="";
	$dbname="illusiondb";
	$fname = "";
	$lname = "";
	$email = "";
	$password1 = "";
	$errors = array();

	//connect to mysql database
	$conn = new mysqli($servername,$username,$password,$dbname);
	date_default_timezone_set('Asia/Kolkata');


// 	if(isset($_SESSION['success'])){
//     	header('location:index.php');
// 	}


// // on all screens requiring login, redirect if NOT logged in
// 	if(!isset($_SESSION['success'])){
//     	header('location:Login.php');
// 	}
	//if the register button is clicked
	if(isset($_POST['register'])){
		$fname = $conn->real_escape_string($_POST['FirstName']);
		$lname = $conn->real_escape_string($_POST['Surname']);
		$email = $conn->real_escape_string($_POST['EmailID']);
		// $gender = $conn->real_escape_string($_POST['gender']);
		$password1 = $conn->real_escape_string($_POST['Password']);
		$cpassword = $conn->real_escape_string($_POST['ConfirmPassword']);
	

		if(empty($fname)){
			array_push($errors, "First Name is required");
		}
		if(empty($lname)){
			array_push($errors, "Surname is required");
		}
		if(empty($email)){
			array_push($errors, "Email ID is required");
		}
		if(empty($password1)){
			array_push($errors, "Password is required");
		}
		if($password1 != $cpassword){
			array_push($errors, "The two passwords do not match");
		}

		//if no errors save user to database
		if(count($errors) == 0){
			$password = $password1;
			$sql = "INSERT INTO Users (FirstName,Surname,EmailID,Password) 
			VALUES ('$fname','$lname','$email','$password')";
			if($conn->query($sql) == TRUE){
				//alert('Registration Successfull');
				$_SESSION['fname'] = $fname;
				$_SESSION['success'] = "";
				$_SESSION['recepient']= $email;
				header('location: home.php');
				exit();
			}
		}	
	}

	if(isset($_POST['login'])){
		$email = $conn->real_escape_string($_POST['Email']);
		$password1 = $conn->real_escape_string($_POST['Pass']);
		if(empty($email)){
			array_push($errors, "Email ID is required");
		}
		if(empty($password1)){
			array_push($errors, "Password is required");
		}
		if(count($errors) == 0){
			$pass = $password1;
			$sql = "SELECT id,FirstName,EmailID FROM Users WHERE EmailID='$email' AND Password ='$pass'";
			$result = $conn->query($sql);
			if($result->num_rows == 1){
				$row = $result->fetch_assoc();
				$_SESSION['Authuserid'] = $row["id"];
				$_SESSION['fname']= $row["FirstName"];
				$_SESSION['recepient']= $row["EmailID"];
				//$_SESSION['sent']=$row["EmailID"];
				header('location:home.php');
				//$_SESSION['success'] = "";
				//echo "hi";exit;
				exit();
			} else {
				array_push($errors, "Email Id/Password is invalid");
			}
		}	


	}

	if(isset($_POST['readmssg'])){
		$var = $_POST['sendname'];
		$_SESSION['msendname']=$var;
		header('location:test.php');
	}

	//Storing emails in the database
	if(isset($_POST['send'])){
		$from = $conn->real_escape_string($_POST['From']);
		$to = $conn->real_escape_string($_POST['To']);
		$subject = $conn->real_escape_string($_POST['Subject']);
		$message = $conn->real_escape_string($_POST['Message']);
		if(empty($to)){
			array_push($errors, "No recepient selected");
		}
		if(empty($subject)){
			array_push($errors, "No subject is selected");
		}
		if(empty($message)){
			array_push($errors, "No message is selected");
		}
		if(count($errors) == 0){
			$date = date("Y/m/d");
			$samay = date("G:i:s");
			$sql = "INSERT INTO Mails (SentFrom,Recepient,Subject,Message,ReadBy,Tareekh,Samay) 
			VALUES ('$from','$to','$subject','$message','No','$date','$samay')";
			$sql1 = "INSERT INTO sentmails (SentFrom,Recepient,Subject,Message,ReadBy,Tareekh,Samay) 
			VALUES ('$from','$to','$subject','$message','No','$date','$samay')";
			
			if($conn->query($sql) == TRUE){
				//alert('Registration Successfull');
				if($conn->query($sql1	) == TRUE){
					header('location: home.php');
					exit();
				}
			}
		}	
	}
	if(isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['fname']);
		header('location: Login.php');
	}
?>