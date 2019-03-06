
<?php
	include('server.php');
	if(isset($_POST['action']) && $_POST['action'] == 'delete'){
		
	if(!empty($_POST['check_list'])) {
	$checked_count = count($_POST['check_list']);
	echo "You have selected following ".$checked_count." option(s): <br/>";
	$arrStr = implode(",", $_POST['check_list']);
	$sql = "DELETE from mails where id IN (".$arrStr.")";
	
	    if($conn->query($sql) == TRUE){

         	header('location: home.php');
         }


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
	<form method="post" name="inbox" action="">
<aside id="sidebar" class="nano">
  <div class="nano-content">
    <div class="logo-container"><span class="logo glyphicon glyphicon-envelope"></span>Illusion</div>
    <a class="compose-button" id="compose" href="compose.php">Compose</a>
    <menu class="menu-segment">
      <ul>
        <li class="active"><a href="home.php">Inbox</a></li>
        <li><a href="#">Important</a></li>
        <li><a href="sent.php">Sent</a></li>
        <li><a href="#">Drafts</a></li>
        <li><a href="#">Trash</a></li>
      </ul>
      <button id="play" type="button">Play Demo</button>
      <input type="text" name="task" id="task">
        <label hidden="hidden"><input type="radio" name="recognition-type" value="interim" checked="checked"/> Interim</label>
    </menu>
    <div class="separator"></div>

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
      
      <li><a class="icon circle-icon glyphicon glyphicon-refresh"></a></li>
      <li><a class="icon circle-icon glyphicon glyphicon-share-alt"></a></li>
      <li><a class="icon circle-icon red glyphicon glyphicon-remove" id="a" name="delete" onclick="window.getElementById('action').value='delete';window.inbox.submit();"></a></li>
      <input type="hidden" value="" name="action" id="action">
      
      	
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
          				<div class='col col-1'><span class='dot'></span>
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

    var id = $(this).val();

   $.ajax({
           type: "post",
           url: "/illusion/message_popup.php",
           data: {'id':id },

           success: function(response){
    
              $('#message').html(response);
            }
        });
   });
</script>
 


    <script src="mail.js"></script>



</form>


<script type="text/javascript">
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
      // speak("Welcome to Illusion. Illusion is a voice based email system made by greatest people of all time. Illusion is the first billion dollar company made without any investor. To get started create your account. Please enter your first name");
      <?php if (isset($_SESSION["fname"])):?>
          var myName = "<?php echo($_SESSION['fname']); ?>"
          speak("Hi"+myName);
          //speak("What would you like to do?");
          //speak("Create an email?");
          //speak("Read an email?");
          //speak("Or Delete an email");
        <?php endif?>
    }
      

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
      var mpass = document.getElementById('mpass');

      // Recogniser doesn't stop listening even if the user pauses
      recognizer.continuous = true;

      // Start recognising
      recognizer.onresult = function(event) {
        task.textContent = '';


        for (var i = event.resultIndex; i < event.results.length; i++) {
          if (event.results[i].isFinal) {
            str = event.results[i][0].transcript;
            alert(str);
          if(task.value == "" ||task.value == "subject" || task.value == "read"){
            // var str1 = event.results[i][0].transcript;
            task.value = str;
            // alert(str);
            //task.value = "";
          if(str.includes("read")){
            speak("Do you want to filter emails by username or by subject?");
            //task.value = "";
          } else if(str.includes("subject")){
            speak("Enter the subject of the mail ");
            //task.value="";
            // var str2 = event.results[i][0].transcript;
            //alert(str);
          } else if(str.includes("create")){
            //var str2 = event.results[i][0].transcript;
            speak("created");
            alert(str);
            task.value=str;
          }
        //     for (var i = event.resultIndex; i < event.results.length; i++) {
        //     if (event.results[i].isFinal) {
        //     str = event.results[i][0].transcript;

        //   if(str.includes("username")){
        //     speak("filter using username ");
        //   }

        //   if(str.includes("subject")){
        //     speak("filter using subject");
        //   }


        //   }
        // }
      
    }

          // alert(str);
            //alert(str);
            //speak(str);
            //alert("The site says "+str);
          } else {
            fname.textContent += event.results[i][0].transcript;
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

      document.getElementById('button-stop-ws').addEventListener('click', function() {
        recognizer.stop();
        // log.innerHTML = 'Recognition stopped' + '<br />' + log.innerHTML;
      });

      document.getElementById('clear-all').addEventListener('click', function() {
        transcription.textContent = '';
        // log.textContent = '';
      });
    }

    function gotoSignup(){
      // document.getElementById("regdiv").style.display = "block";
      // document.getElementById("logdiv").style.display = "none";
      // document.getElementById("signupbtn").style.backgroundColor = "#6ee0cb";
      // document.getElementById("signupbtn").style.color = "#fff";
      // document.getElementById("signinbtn").style.backgroundColor = "#4c5d72";
      // document.getElementById("signinbtn").style.color = "#727f90";
      // document.getElementById("error").style.display = "none";
      window.location.href = "register.php";
    }
  </script>
</body>

</html>






