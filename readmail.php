<?php include('server.php');
	  include('sentmails.php')

	// if(empty($_SESSION['Authuserid'])){
	// 	header('location:Login.php');
	// }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Read Mails</title>
	<style type="text/css">
		button{
			margin-left:500px;
		}
	</style>
</head>
<body>
	<div><button name="showmail">Show Mail</button></div>
<?php 
	$showmail = $conn->real_escape_string($_POST['showmail']);
	if(isset($_POST['showmail'])){
		echo "hi";
	}




?>
</body>
</html>
