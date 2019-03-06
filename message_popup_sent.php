<?php
include ('server.php');
      $id = $_POST['id'] ;
    
      $sql = "SELECT * FROM mails where id = ".$id;
      $result = $conn->query($sql);
      $row = mysqli_fetch_array($result);
?>

 <div class="header">
    <h1 class="page-title"><a class="icon circle-icon glyphicon glyphicon-chevron-left trigger-message-close"></a>Your Mail...</h1>
    <p>From You to <?php echo $row['Recepient']; ?> , started on <a href="#"><?php echo $row['Tareekh']," ",$row['Samay']; ?></a></p>
  </div>



  <div id="message-nano-wrapper" class="nano">
    <div class="nano-content">
      <ul class="message-container">
        <li class="sent">
          <div class="details">
            <div class="left">You
              <div class="arrow"></div><?php echo $row['Recepient']; ?>
            </div>
            <div class="right"><?php echo $row['Tareekh']," ",$row['Samay']; ?></div>
            <br>
            <p>Subject: <?php echo $row['Subject']; ?></p>
          </div>
          <div class="message">
            <p><?php echo $row['Message']; ?></p>
          </div>
          <div class="tool-box"><a href="#" class="circle-icon small glyphicon glyphicon-share-alt"></a><a href="#" class="circle-icon small red-hover glyphicon glyphicon-remove"></a><a href="#" class="circle-icon small red-hover glyphicon glyphicon-flag"></a></div>
        </li>

        
        <!--   
        </li>
      </ul>
    </div>
  </div> -->