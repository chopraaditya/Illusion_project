
<?php
  include('server.php');
  // if(isset($_POST['delete'])){
  //   // print_r($_POST['check_list']);
  //   // exit;
  // if(!empty($_POST['check_list'])) {
  // $checked_count = count($_POST['check_list']);
  // echo "You have selected following ".$checked_count." option(s): <br/>";
  // $arrStr = implode(",", $_POST['check_list']);
  // $sql = "DELETE from mails where id IN (".$arrStr.")";
  
  //     if($conn->query($sql) == TRUE){
  //       //echo "hi";
  //         header('location: sent.php');
  //        }
  //foreach($_POST['check_list'] as $selected) {
  //echo "<p>".$selected ."</p>";
  
  // $sql = "DELETE from mails where id=".$selected;
  //     $conn->query($sql);
        // if($conn->query($sql) == TRUE){
        //  echo "deleted id".$selected;
        // }


//}
            

// }

// }


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
<body >
  <form method="post" action="">
<aside id="sidebar" class="nano">
  <div class="nano-content">
    <div class="logo-container"><span class="logo glyphicon glyphicon-envelope"></span>Illusion</div>
    <a class="compose-button" id="compose" >Compose</a>
    <menu class="menu-segment">
      <ul>
        <li><a href="home.php">Inbox</a></li>
        <li class="active"><a href="sent.php">Sent</a></li>
        <li><a href="#">Trash</a></li>
      </ul>
    </menu>
    <div class="separator"></div>

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
    <h1 class="page-title"><a class="sidebar-toggle-btn trigger-toggle-sidebar"><span class="line"></span><span class="line"></span><span class="line"></span><span class="line line-angle1"></span><span class="line line-angle2"></span></a>Compose<a><span class="icon glyphicon glyphicon-chevron-down"></span></a></h1>
  </header>


  <div id="modalcompose" class="modalclass">
      <!-- Modal content -->
      <div class="modal-contents">
          <span class="close">&times;</span>
          <div id="sendbox">
            <form action="" method="POST">
              <input type="text" readonly name="From" placeholder="From"  value="<?php echo $_SESSION['recepient']?>"><br>
              <input type="text" name="To" placeholder="To" id="to"><br>
              <input type="text" name="Subject" placeholder="Subject" id="subject"><br>
              <textarea placeholder="Enter your message" id="from" name="Message"></textarea><br>
              <input type="submit" name="send" id="sendBtn" value="send">  
              <button id="play" type="button">Play Demo</button>
        <label hidden="hidden"><input type="radio" name="recognition-type" value="interim" checked="checked"/> Interim</label>
            </form>
          </div>
        </div>

   </div>

</main>




     <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

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
      var to = document.getElementById('to');
      var subject = document.getElementById('subject');
      var message = document.getElementById('from');

      // Recogniser doesn't stop listening even if the user pauses
      recognizer.continuous = true;

      // Start recognising
      recognizer.onresult = function(event) {
        to.textContent = '';


        for (var i = event.resultIndex; i < event.results.length; i++) {
          if (event.results[i].isFinal) {
            str = event.results[i][0].transcript;
          // fname.value = event.results[i][0].transcript;

          if(to.value == ""){
            var tostr = event.results[i][0].transcript;
            tostr = tostr.replace(/ /g,'');
            tostr = tostr.toLowerCase();
            to.value = tostr;
            speak("Enter the subject");
          }else if(subject.value == ""){
            //alert("hi");
            subject.focus();
            var subjectstr = event.results[i][0].transcript;
            //subjectstr = subjectstr.replace(/ /g,'');
            //subjectstr = subjectstr.toLowerCase();
            subject.value = subjectstr;
            speak("Enter the message");
          } 
          else if(message.value == ""){
            message.focus();
            var messagestr = event.results[i][0].transcript;
            //messagestr = messagestr.replace(/ /g,'');
            //messagestr = messagestr.toLowerCase();
            message.value = messagestr;
            speak("Are you sure you want to send this email?");
          } 
          var confirm = event.results[i][0].transcript;
          if(confirm.includes("yes") || confirm.includes("Yes")){
            document.getElementById('sendBtn').click();
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






