<?php
	include('server.php');
	echo $_SESSION['msendname'];
  $var = 1;
	$sql = "SELECT * FROM mails where SentFrom = '".$_SESSION['msendname']."' and Recepient = '".$_SESSION['recepient']."'  order by (id) DESC";
	$result = $conn->query($sql);
	while ($row = mysqli_fetch_array($result)) {  ?>
			<input type="text" value='<?php echo $row['Message'];?>' name=""><br>
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
				var sub = "<?php echo($row['Subject'])?>";
				var mssg = "<?php echo($row['Message'])?>";
        speak("Mail no."+<?php echo($var);?>);
				speak("Subject is "+sub);
				speak("Message is "+mssg);
        <?php $var = $var+1; ?>
			</script>	   

	<?php } ?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<br><br>
	<input type="text" name="" id="task">
	<button id="play" type="button">Play Demo</button>
    <label hidden="hidden"><input type="radio" name="recognition-type" value="interim" checked="checked"/> Interim</label>
	<script type="text/javascript">
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
            task.value = str;
          // fname.value = event.results[i][0].transcript;
          if(str.includes("inbox")){
          	window.location.href = "home.php";
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

</body>
</html>
