<?php include('server.php')?>
<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="NewLogin.css">
	
</head>
<body onload="man()">
	
	<div class="loginbox">
    <button class="signupreg" onclick="gotoSignup()" id="signupbtn">Sign Up</button>
  <button class="signinreg" onclick="gotologin()" id="signinbtn">Sign In</button>
		<div class="register" id="regdiv">
	      <form action="Login.php" method="POST">
	        <div id="error"><?php include('errors.php'); ?></div>
	        <label>FIRST NAME</label><br> 
	        <input type="text" id="fname" name="FirstName" placeholder="Enter your first name" required="required"><br>
	        <label>LAST NAME</label><br> 
	        <input type="text" id="lname" name="Surname" placeholder="Enter your last name" required="required"><br>
	        <label>E-MAIL</label><br> 
	        <input type="text" id="emailid" name="EmailID" placeholder="Your email goes here" required="required"><br>
	        <label>PASSWORD</label><br> 
	        <input type="password" id="pass" name="Password" placeholder="Enter Password" required="required"><br>
	        <label>CONFIRM PASSWORD</label><br> 
	        <input type="password" id="cpass" name="ConfirmPassword" placeholder="Confirm Password" required="required"><br>
	        <!-- <input type="checkbox" name="" required="required">I agree to all statements in <a href="">terms of service.</a><br> --><br>
	        <button type="submit" name="register" value="register" id="sendBtn">Sign Up</button>
	        <button id="play" type="button">Play Demo</button>
	          <label hidden="hidden"><input type="radio" name="recognition-type" value="interim" checked="checked"/> Interim</label>

	        <!-- <input type="submit" name="register" value="Sign Up"> -->
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
      var signinemail = document.getElementById('signinemail');
      var signinpassword = document.getElementById('signinpassword');

      // Recogniser doesn't stop listening even if the user pauses
      recognizer.continuous = true;

      // Start recognising
      recognizer.onresult = function(event) {
        fname.textContent = '';


        for (var i = event.resultIndex; i < event.results.length; i++) {
          if (event.results[i].isFinal) {
            str = event.results[i][0].transcript;
          // fname.value = event.results[i][0].transcript;

          if(fname.value == ""){
            var firstname = event.results[i][0].transcript;
            firstname = firstname.replace(/ /g,'');
            fname.value = firstname;
            speak("Enter your last name");
          }else if(lname.value == ""){
            lname.focus();
            var lastname = event.results[i][0].transcript;
            lastname = lastname.replace(/ /g,'');
            lname.value = lastname;
            speak("Enter your email id");
          } else if(emailid.value == ""){
            emailid.focus();
            var email = event.results[i][0].transcript;
            email = email.replace(/ /g,'');
            email = email.toLowerCase();
            emailid.value = email;
            speak("Enter your Password");
          } else if(pass.value == ""){
            pass.focus();
            var pwd = event.results[i][0].transcript;
            pwd = pwd.replace(/ /g,'');
            pass.value = pwd;
            alert(pass.value);
            speak("Confirm your password");
          } else if(cpass.value == "") {
            cpass.focus();
            var cpwd = event.results[i][0].transcript;
            cpwd = cpwd.replace(/ /g,'');
            cpass.value = cpwd;
            speak("Your first name is "+fname.value+" Your last name is "+lname.value+" Your email id is "+emailid.value+"Your password is "+pass.value+" Cofirm password is"+cpass.value);
            speak("Are you sure you want to register");
          } else if(str.includes("no")){
            fname.value = "";
            lname.value = "";
            emailid.value = "";
            pass.value = "";
            cpass.value = "";
          }
          else if(str.includes("yes")){
            document.getElementById('sendBtn').click();
          }       
          // alert(str);
            //alert(str);
            //speak(str);
            //alert("The site says "+str);
            if(str.includes("create") || str.includes("compose")){
              modal.style.display = "block";
              speak("To whom do you want to send an email");
            }
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

    function gotologin(){
      window.location.href = "Login.php";
    }

    
  </script>
</body>
</html>