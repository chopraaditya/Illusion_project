<?php include('server.php');

	if(empty($_SESSION['Authuserid'])){
		header('location:Login.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Illusion</title>
	<link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
	<header>
		<div class="header">
			<div class="logoutbutton">
				<?php if (isset($_SESSION["fname"])):?>
					<p>Welcome <strong><?php echo $_SESSION['fname'];?> </strong></p>
					<a href="index.php?logout='1'" style="color:red;">Logout</a>
				<?php endif?>
			</div>
			<h2>Sent Mails</h2>
		</div><hr width="100%">
	</header>
	<!-- Side navigation bar -->
	<aside>
		<div class="sidenav">
	  		<a href="#compose"><button id="compose">Compose</button></a>
	    	<a href="index.php">Inbox</a>
	    	<a href="#sent">Sent Mails</a>
	    	<a href="#trash">Trash</a>
	    </div>
	</aside>
	<!-- Displays emails to user -->
	<center>
		<table class="mails" cellpadding="0" id="myTable" name="table">
			<!-- <tr>
				<td width="30px">
					<input type="checkbox" name="">
				</td>
			 -->	<!-- <td width="200px">
					Moxa
				</td>
				<td>
					Illusion
				</td>
			</tr> -->
			<?php
			$sql = "SELECT * FROM mails where SentFrom = '".$_SESSION['recepient']."'  order by (id) DESC";
			$result = $conn->query($sql);
			//var_dump($sql);exit;
			while ($row = mysqli_fetch_array($result)) {                   
                   echo "<tr>";
                   //echo "<td width="30px"><input type="checkbox" name=""></td>";
                   echo "<td>".$row["Recepient"]."</td>";
                   echo "<td>".$row["Subject"]."</td>";
                   echo "<td>".$row["Message"]."</td>";
                   echo "</tr>";
               }

			?>

		</table>
		<!-- <button onclick="refresh()">Refresh</button> -->
	</center>

	<!-- Defines compose email format -->
		<div id="myModal" class="modal">
		  <!-- Modal content -->
		  <div class="modal-content">
		      <span class="close">&times;</span>
		      <div id="sendbox">
		      	<form action="" method="POST">
		      		<input type="text" name="From" placeholder="From" id="from"><br>
			      	<input type="text" name="To" placeholder="To" id="from"><br>
			      	<input type="text" name="Subject" placeholder="Subject" id="from"><br>
			        <textarea placeholder="Enter your message" id="from" name="Message"></textarea><br>
			        <input type="submit" name="send" value="send">	
		      	</form>
		      </div>
		    </div>
1
 	 </div>

   </body>
</html>


<script type="text/javascript">
  var modal = document.getElementById('myModal');
  var span = document.getElementsByClassName("close")[0];
  var create = document.getElementById("compose");
 //var read = document.querySelector(".read");
  //When the user clicks the button, open the modal 
	create.onclick = function() {
    	modal.style.display = "block";
	}

// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
    	modal.style.display = "none";
	}

	// read.onclick = function(){
	// 	modal.style.display = "block";
	// }

</script>
