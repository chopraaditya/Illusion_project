<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="mainPage.css">
    <title>Web Speech API Demo</title>

  </head>
  <body>
    <h1>Illusion</h1><hr width="100%">
    <h3>Speak up to get your things done</h3>

    <div class="sidenav">
  <!-- <a href="#about">About</a> -->
    <a href="#compose"><button id="compose">Compose</button></a>
    <a href="#inbox">Inbox</a>
    <a href="#sent">Sent Mails</a>
    <a href="#thrash">Trash</a>
  </div>

  <div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
      <span class="close">&times;</span>
      <div id="sendbox">
      	<input type="text" name="" placeholder="From"><br>
      	<input type="text" name="" placeholder="To"><br>
      	<input type="text" name="" placeholder="Subject"><br>
        <textarea placeholder="Enter your message"></textarea><br>
        <input type="submit" name="" value="send">
      </div>
    </div>

  </div>


    <textarea id="transcription" readonly="readonly" ></textarea>

    <span>Results:</span>
    <label><input type="radio" name="recognition-type" value="final"/> Final only</label>
    <label><input type="radio" name="recognition-type" value="interim" checked="checked" /> Interim</label>

    <!-- <h3>Log</h3> -->
    <!-- <div id="log"></div> -->

    <div class="buttons-wrapper">
      <button id="button-play-ws" class="button-demo">Play demo</button>
      <button id="button-stop-ws" class="button-demo">Stop demo</button>
      <button id="clear-all" class="button-demo">Clear all</button>
    </div>
    <span id="ws-unsupported" class="hidden">API not supported</span>

    <script>
      
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

      // Test browser support
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
      var transcription = document.getElementById('transcription');
      var log = document.getElementById('log');

      // Recogniser doesn't stop listening even if the user pauses
      recognizer.continuous = true;

      // Start recognising
      recognizer.onresult = function(event) {
        transcription.textContent = '';

        for (var i = event.resultIndex; i < event.results.length; i++) {
          if (event.results[i].isFinal) {
            transcription.textContent = event.results[i][0].transcript;
            str = event.results[i][0].transcript;
            speak(str);
            //speak(str);
            //alert("The site says "+str);
            if(str.includes("create") || str.includes("compose")){
              modal.style.display = "block";
            	speak("To whom do you want to send an email");
            }
          } else {
            transcription.textContent += event.results[i][0].transcript;
          }
        }
      };


      // Listen for errors
      recognizer.onerror = function(event) {
        // log.innerHTML = 'Recognition error: ' + event.message + '<br />' + log.innerHTML;
      };

      document.getElementById('button-play-ws').addEventListener('click', function() {
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
    </script>
    <script type="text/javascript">
      var modal = document.getElementById('myModal');
  var span = document.getElementsByClassName("close")[0];
  var create = document.getElementById("compose");
  //When the user clicks the button, open the modal 
create.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}
    </script>
    <!-- <script type="text/javascript" src = "voiceAPI.js"></script> -->
  </body>
</html>