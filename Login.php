<?php include('server.php'); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="NewLogin.css">
</head>
<body onload="man()">

  <div class="loginbox">
    <h1>Illusion</h1>
    <button class="signup" onclick="gotoSignup()" id="signupbtn">Sign Up</button>
    <button class="signin" onclick="gotologin()" id="signinbtn">Sign In</button>
    
    <div class="Login" id="logdiv">
      <form action="Login.php" method="POST">
        <div id="error"><?php include('errors.php'); ?></div>
        <label>E-MAIL</label><br> 
        <input type="text" id="memail" name="Email" placeholder="Your email goes here" required><br>
        <label>PASSWORD</label><br> 
        <input type="password" id="mpass" name="Pass" placeholder="Enter Password" required><br>
        <button type="submit" id="sendBtn" name="login" value="login">Sign In</button>
        <button id="play" type="button">Play Demo</button>
        <label hidden="hidden"><input type="radio" name="recognition-type" value="interim" checked="checked"/> Interim</label>
        <!-- <input type="submit" name="login" value="Sign In"> -->
      </form> 
    </div>
  </div>
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
      speak("Welcome to Illusion. Illusion is the first voice based mailing system that gives assistance to the user. Please login to get started."); 
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
      var memail = document.getElementById('memail');
      var mpass = document.getElementById('mpass');

      // Recogniser doesn't stop listening even if the user pauses
      recognizer.continuous = true;

      // Start recognising
      recognizer.onresult = function(event) {
        memail.textContent = '';


        for (var i = event.resultIndex; i < event.results.length; i++) {
          if (event.results[i].isFinal) {
            str = event.results[i][0].transcript;
          // fname.value = event.results[i][0].transcript;

          if(str.includes("register")){
            window.location.href="register.php";
          }else if(memail.value == ""){
            var email = event.results[i][0].transcript;
            email = email.replace(/ /g,'');
            email = email.toLowerCase();
            memail.value = email;
            speak("Your email ID is "+email);
            speak("If correct enter your password else just say No.");
          } else if (str.includes("no")|| str.includes("No")) {
            memail.value = "";
            mpass.value = "";
          }else if(mpass.value == ""){
            mpass.focus();
            var pass = event.results[i][0].transcript;
            pass = pass.replace(/ /g,'');
            pass = pass.toLowerCase();
            mpass.value = pass;
            speak("Your password is "+pass+" Are you sure you wish to sign in?");
          }else if(str.includes("yes") || str.includes("Yes")){
            document.getElementById('sendBtn').click();
          }       
            //alert(str);
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