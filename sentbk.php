
<?php
	include('server.php');
	if(isset($_POST['delete'])){
		// print_r($_POST['check_list']);
		// exit;
	if(!empty($_POST['check_list'])) {
	$checked_count = count($_POST['check_list']);
	echo "You have selected following ".$checked_count." option(s): <br/>";
	$arrStr = implode(",", $_POST['check_list']);
	$sql = "DELETE from mails where id IN (".$arrStr.")";
	
	    if($conn->query($sql) == TRUE){
	    	//echo "hi";
         	header('location: sent.php');
         }
	//foreach($_POST['check_list'] as $selected) {
	//echo "<p>".$selected ."</p>";
	
	// $sql = "DELETE from mails where id=".$selected;
	//     $conn->query($sql);
        // if($conn->query($sql) == TRUE){
        // 	echo "deleted id".$selected;
        // }


//}
            

}

}


?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Illusion</title>
   <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500" />
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" type="text/css" href="home.css">
  
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

</head>
<body>
	<form method="post" action="">
<aside id="sidebar" class="nano">
  <div class="nano-content">
    <div class="logo-container"><span class="logo glyphicon glyphicon-envelope"></span>Illusion</div>
    <a class="compose-button" id="compose" href="compose.php">Compose</a>
    <menu class="menu-segment">
      <ul>
        <li><a href="home.php">Inbox</a></li>
        <li><a href="#">Important</a></li>
        <li class="active"><a href="sent.php">Sent</a></li>
        <li><a href="#">Drafts</a></li>
        <li><a href="#">Trash</a></li>
      </ul>
    </menu>
    <div class="separator">
      <button id="play" type="button">Play Demo</button>
    <label hidden="hidden"><input type="radio" name="recognition-type" value="interim" checked="checked"/> Interim</label>
    <!-- <form action="test.php" method="GET">
      <input type="text" name="task" id="task"><br>
      <input type="text" name="sendname" id="read"><br>
      <input type="submit" name="readmssg" id="readmssg">
    </form> -->
    </div>

  </div>
</aside>
<main id="main">
  <div class="overlay"></div>
  <header class="header">
    <div class="search-box">
     
        <?php if (isset($_SESSION["fname"])):?>
          <p>Welcome <strong><?php echo $_SESSION['fname'];?> </strong></p>
          <a href="Login.php?logout='1'" style="color:red;">Logout</a>
        <?php endif?>
    </div>
    <h1 class="page-title"><a class="sidebar-toggle-btn trigger-toggle-sidebar"><span class="line"></span><span class="line"></span><span class="line"></span><span class="line line-angle1"></span><span class="line line-angle2"></span></a>Sent<a><span class="icon glyphicon glyphicon-chevron-down"></span></a></h1>
  </header>

  <div class="action-bar">
    <ul>

      <li><a class="icon circle-icon glyphicon glyphicon-refresh"></a></li>
      <li><a class="icon circle-icon glyphicon glyphicon-share-alt"></a></li>
      <li><a class="icon circle-icon red glyphicon glyphicon-remove"></a></li>
      
      	<input type="submit" name="delete" value="Delete">
      

    </ul>
  </div>

  <div id="main-nano-wrapper" class="nano">
    <div class="nano-content">
      <ul class="message-list">


        <!-- <li class="unread">
          <div class="col col-1"><span class="dot"></span>
            <div class="checkbox-wrapper">
              <input type="checkbox" id="chk1">
              <label for="chk1" class="toggle"></label>
            </div>
            <p class="title">Aditya Chopra (via Twitter)</p>
          </div>
          <div class="col col-2">
            <div class="subject">Lucas Kriebel (@LucasKriebel) has sent you a direct message on Twitter! &nbsp;&ndash;&nbsp; <span class="teaser">@LucasKriebel - Very cool :) Nicklas, You have a new direct message.</span></div>
            <div class="date">11:49 am</div>
          </div>
        </li> -->


        
			
			<?php
			// $sql = "SELECT * FROM mails where Recepient = '".$_SESSION['recepient']."'  order by (id) DESC";
			// $result = $conn->query($sql);
			$sql = "SELECT * FROM mails where SentFrom = '".$_SESSION['recepient']."'  order by (id) DESC";
			$result = $conn->query($sql);
			//var_dump($sql);exit;
			while ($row = mysqli_fetch_array($result)) {  
				   ?>
				   		
				   		<li class='unread' value='<?php echo $row['id']; ?>'>
          				<div class='col col-1'><span class='dot'></span>
            			<div class='checkbox-wrapper'>
            			
            			
              		    <input type='checkbox' name='check_list[]' value='<?php echo $row['id']; ?>' id='<?php echo $row['id']; ?>' >
              			<label for='<?php echo $row['id']; ?>' class='toggle'></label>
              		
            			</div> 
            			<p class='title'><?php echo $row['Recepient']; ?></p>
          </div>
          <div class='col col-2'>
            <div class='subject'><?php echo $row['Subject']; ?></div>
            <div class='date'>11:48 am</div>
          </div>
        </li>    


    
                  
 <?php } ?>

			

		


        </ul>
    </div>
  </div>
</main>


<div id="message">
 <!-- content here is in message_popup_sent and the page is bonded with that page inside ajax -->
</div>
 








	






<!-- 
<div id="myModal" class="modal">
 -->      <!-- Modal content -->
     <!--  <div class="modal-content">
          <span class="close">&times;</span>
          <div id="sendbox">
            <form action="" method="POST">
              <input type="text" readonly name="From" placeholder="From" id="from" value="<?php //echo $_SESSION['recepient']?>"><br>
              <input type="text" name="To" placeholder="To" id="from"><br>
              <input type="text" name="Subject" placeholder="Subject" id="from"><br>
              <textarea placeholder="Enter your message" id="from" name="Message"></textarea><br>
              <input type="submit" name="send" value="send">  
            </form>
          </div>
        </div> -->

<!--    </div> -->

     <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script type="text/javascript">
  $('#main .message-list li').on('click', function(e) {
     //alert($(this).attr('id'));
    var id = $(this).val();
    
   $.ajax({
           type: "post",
           url: "/illusion/message_popup_sent.php",
           data: {'id':id },
           //dataType: "json",
           success: function(response){
              //alert(response);
              $('#message').html(response);
            }
        });
   });
</script>
 

 <!--  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script> -->

 


    <script src="mail.js"></script>



</form>

</body>

</html>






