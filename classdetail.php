
<!DOCTYPE html>

<html lang="en">
   <head>
      <link rel="stylesheet" href="style.css">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   </head>

   <header>
      <div class="w3-bar w3-white" id="barTop" id="holdTop">

        <ul class="nav justify-content-center">

          <li class="nav-item" id="soc">
            <h4><a class="nav-link" onclick="w3_open()" href="#">☰</a></h4>
          </li>

          <li class="nav-item">
            <h4><a class="nav-link" href="classdetail.php">Stream</a></h4>
          </li>

          <li class="nav-item">
            <h4><a class="nav-link" href="#">Classwork</a></h4>
          </li>

          <li class="nav-item">
            <h4><a class="nav-link" href="#">People</a></h4>
          </li>
          
        </ul>
        
      </div>
    </header>
   <body>

    <div class="w3-sidebar w3-bar-block" style="display:none" id="mySidebar">
      <button onclick="w3_close()" class="w3-bar-item w3-button w3-large">Close &times;</button>
      <a href="home.php" class="w3-bar-item w3-button">Lớp học</a>
      <a href="#" class="w3-bar-item w3-button">Lịch</a>
    </div>



    <div id="big">

      <div ><h1 class="className">Name class</h1></div>
      <span class="className" id="teacher">Teacher</span>
      <span >-</span>
      <span  id="classtime">ClassTime</span>

    </div>

    <div class="detailing">

      <div class="classNew">
        <h3 class="classNew">Thông báo</h3>
      </div>

      <div class="comment">
        <input type="text" id="cmt" name="cmt">
        <input type="submit" value="Nhận xét" id="post">
        
      </div>

    </div>




      
         



  </body>
  <script>
    function w3_open() {
      document.getElementById("mySidebar").style.width = "16%";
      document.getElementById("mySidebar").style.display = "block";
    }

    function w3_close() {
      document.getElementById("mySidebar").style.display = "none";
    }
</script>
</html>