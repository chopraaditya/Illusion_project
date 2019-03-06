
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
         	header('location: home.php');
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
<body onload="man()">
	<form method="post" name="inbox" action="" id="">
<aside id="sidebar" class="nano">
  <div class="nano-content">
    <div class="logo-container"><span class="logo glyphicon glyphicon-envelope"></span>Illusion</div>
    <a class="compose-button" id="compose" href="compose.php">Compose</a>
    <menu class="menu-segment">
      <ul>
        <li class="active"><a href="home.php">Inbox</a></li>
        <li><a href="sent.php">Sent</a></li>
        <li><a href="#">Trash</a></li>
      </ul>
    </menu>
    <div class="separator"></div>
    <button id="play" type="button">Play Demo</button>
    <label hidden="hidden"><input type="radio" name="recognition-type" value="interim" checked="checked"/> Interim</label>
    <form action="test.php" method="POST">
      <input type="text" name="task" id="task"><br>
      <input type="text" name="sendname" id="read"><br>
      <input type="submit" name="readmssg" id="readmssg">
    </form> 
  </div>
</aside>
<main id="main">
  <div class="overlay"></div>
  <header class="header">
    <div class="search-box">
      <!-- <input placeholder="Search..."><span class="icon glyphicon glyphicon-search"></span> -->
        <?php if (isset($_SESSION["fname"])):?>
          <p>Welcome <strong><?php echo $_SESSION['fname'];?> </strong></p>
          <a href="Login.php?logout='1'" style="color:red;">Logout</a>
        <?php endif?>
    </div>
    <h1 class="page-title"><a class="sidebar-toggle-btn trigger-toggle-sidebar"><span class="line"></span><span class="line"></span><span class="line"></span><span class="line line-angle1"></span><span class="line line-angle2"></span></a>Inbox<a><span class="icon glyphicon glyphicon-chevron-down"></span></a></h1>
  </header>

  <div class="action-bar">
    <ul>
      <!-- <li><a class="icon circle-icon glyphicon glyphicon-chevron-down"></a></li> -->
      <li><a class="icon circle-icon glyphicon glyphicon-refresh" href="home.php"></a></li>
      <li><a class="icon circle-icon glyphicon glyphicon-share-alt"></a></li>
      <li><a class="icon circle-icon red glyphicon glyphicon-remove" id="a" name="delete" onclick="window.getElementById('action').value='delete';window.inbox.submit();"></a></li>
      <input type="hidden" value="" name="action" id="action">
      
      	<!-- <li><input type="submit" class="icon circle-icon red glyphicon glyphicon-remove" name="delete" value="X"></li> -->
      
      <!-- <li><a class="icon circle-icon red glyphicon glyphicon-flag"></a></li> -->
    </ul>
  </div>

  <div id="main-nano-wrapper" class="nano">
    <div class="nano-content">
      <ul class="message-list">
			<?php
			$sql = "SELECT * FROM mails where Recepient = '".$_SESSION['recepient']."'  order by (id) DESC";
			$result = $conn->query($sql);
			while ($row = mysqli_fetch_array($result)) {  
				   ?>	
				   		<li class='unread'  value='<?php echo $row['id']; ?>'>
          				<div class='col col-1' id="mainarea"><span class='dot'></span>
            			  <div class='checkbox-wrapper'>
              		    <input type='checkbox' name='check_list[]' value='<?php echo $row['id']; ?>' id='<?php echo $row['id']; ?>'>
              			  <label for='<?php echo $row['id']; ?>' class='toggle'></label>
            			  </div> 
            			  <p class='title'><?php echo $row['SentFrom']; ?></p>
          </div>
          <div class='col col-2'>
            <div class='subject'><?php echo $row['Subject']; ?></div>
            <div class='date'><?php echo $row['Samay']; ?></div>
          </div>
        </li>    
 <?php } ?>
   </ul>
    </div>
   </div>
  </main>
<div id="message">
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script type="text/javascript">
      $('#main .message-list li').on('click', function(e) {
         // alert($(this).attr('id'));
        var id = $(this).val();
        // alert(id);
       $.ajax({
               type: "post",
               url: "/Illusion/message_popup.php",
               data: {'id':id },
               // dataType: "json",
               success: function(response){
                  // alert(response);
                  $('#message').html(response);
                }
            });
       });


    function speak(text, callback) {
      var u = new SpeechSynthesisUtterance();
      u.text = text;
      u.lang = 'en-US';
   
      u.onend = function () {
          if (callback) {
              callback();
          }
      };
   
      u.onerror = function (e) {
          if (callback) {
              callback(e);
          }
      };
   
      speechSynthesis.speak(u);
    }
    function man(){
        <?php if (isset($_SESSION["fname"])):?>
          var myName = "<?php echo($_SESSION['fname']); ?>"
          speak("Welcome"+myName);
          speak("What would you like to do?");
          speak("Create an email?");
          speak("Read an email?");
          speak("Or Delete an email");
        <?php endif?>
    }

    //speech to text
    window.SpeechRecognition = window.SpeechRecognition       ||
                               window.webkitSpeechRecognition ||
                               null;
     var str="";  



    if (window.SpeechRecognition === null) {
      document.getElementById('ws-unsupported').classList.remove('hidden');
      document.getElementById('button-play-ws').setAttribute('disabled', 'disabled');
      document.getElementById('button-stop-ws').setAttribute('disabled', 'disabled');
    } else {
      var recognizer = new window.SpeechRecognition();
      var task = document.getElementById('task');
      var read = document.getElementById('read');
      // Recogniser doesn't stop listening even if the user pauses
      recognizer.continuous = true;

      // Start recognising
      recognizer.onresult = function(event) {
        task.textContent = '';


        for (var i = event.resultIndex; i < event.results.length; i++) {
          if (event.results[i].isFinal) {
            str = event.results[i][0].transcript;
          // fname.value = event.results[i][0].transcript;

          if(task.value == ""){
            var str1 = event.results[i][0].transcript;
            str1 = str1.replace(/ /g,'');
            str1 = str1.toLowerCase();
            if(str1.includes("yes")){
              task.value=str1;
            }else{
              read.value  = str1;

            }
            if(str1.includes("create")||str1.includes("Create")){
              speak("To whom do you want to send an email");
              window.location.href = "compose.php";
            }
            if(str1.includes("read") && str1.includes("sentmails")){
              window.location.href = "sent.php";
            }
            if(str1.includes("Yes") || str1.includes("yes")){
              document.getElementById('readmssg').click();
            }
            if(str1.includes("read")){
              speak("Whose mail do you want to read?");
            }
          }
          } else {
            task.textContent += event.results[i][0].transcript;
          }
        }
      };


      // Listen for errors
      recognizer.onerror = function(event) {
        // log.innerHTML = 'Recognition error: ' + event.message + '<br />' + log.innerHTML;
      };
      document.getElementById('play').addEventListener('click', function() {
        // Set if we need interim results
        recognizer.interimResults = document.querySelector('input[name="recognition-type"][value="interim"]').checked;

        try {
          recognizer.start();
          // log.innerHTML = 'Recognition started' + '<br />' + log.innerHTML;
        } catch(ex) {
          // log.innerHTML = 'Recognition error: ' + ex.message + '<br />' + log.innerHTML;
        }
      });
    }

    
  </script>
  <script src="mail.js"></script>
</body>
</html>