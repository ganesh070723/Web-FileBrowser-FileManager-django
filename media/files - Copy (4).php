<?php 
session_start();
ob_start();
include 'conn.php';
$row = 1;
$ad =[];
$filename = $_SESSION['ufile'];
if (($handle = fopen("uploads/files/$filename", "r")) !== FALSE) {
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      $num = count($data);
      if($row == 1)
      { 
        $row++; continue; 
      }
      else {
        $row++;
      }
        $flag = 0;
        for($i = 0; $i < count($ad); $i++)
        {
          if($ad[$i] === $data[1]) {
            $flag = 1;
            break;
          }
          else {
            $flag = 0;
          }
        }
        if($flag == 0)
        {
          $address = explode("/",$data[1]);
          array_push($ad, $address[0]);
        }
  }
  fclose($handle);
}

$count_data = 0;
$count_err = 0;
for($i=0; $i < count($ad); $i++) {
  $flag = 0;
  $query = mysqli_query($conn, "SELECT * FROM clients");
  if(mysqli_num_rows($query) > 0)
  {
  while($row = mysqli_fetch_assoc($query)) {
    $address = explode("/",$row['address']);
    if(($ad[$i] === $address[0])) {
      $index = array_search($ad[$i],$ad);
      array_splice($ad, $index, 1);
      $flag = 1;
      break;
    }
  }
}
if($flag == 0)
  {
    $count_data++;
    if (($handle = fopen("uploads/files/$filename", "r")) !== FALSE) {
      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        $process = explode("/",$data[1]);
        if($ad[$i] === $process[0]) {
          $query = mysqli_query($conn,"SELECT * FROM clients");
          $check = 0;
          while($row = mysqli_fetch_assoc($query))
          {
            $address = explode("/", $row['address']);
            if($address[0]==$process[0]) {
              $check = 1;
              break;
            }
          }
          if($check == 0)
          {
          mysqli_query($conn, 'INSERT INTO clients (name, address, phone, email, city, image, assign) VALUES ("$data[0]","$data[1]","$data[4]","$data[3]","$data[2]" ,"client.svg", "0")');  
        }
        }
      }
      fclose($handle);
    }
  }
  else {
    $count_err++;
    $flag = 0;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Finished</title>
  <style>
    body
{
    margin:0; 
    padding:0;
    background: #202124;
    /* background: white; */
    font-family: Arial, Helvetica, sans-serif;
}

.container
{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
}

.loader-wrapper {
    width: 150px;
    height: 100px;
    float: left !important;
}
.align-items-center {
    align-items: center !important;
}
.justify-content-center {
    justify-content: center !important;
}
.d-flex {
    display: flex !important;
}
h2 
{
    color: white;
    text-align: center;
}
svg {
  width: 100px;
  display: block;
  margin: 40px auto 0;
}
.path {
  stroke-dasharray: 1000;
  stroke-dashoffset: 0;
}
.path.circle {
  -webkit-animation: dash 1s ease-in-out;
  animation: dash 1s ease-in-out;
}
.path.line {
  stroke-dashoffset: 1000;
  -webkit-animation: dash .5s .5s ease-in-out forwards;
  animation: dash .5s .5s ease-in-out forwards;
}
.path.check {
  stroke-dashoffset: -100;
  -webkit-animation: dash-check .5s .5s ease-in-out forwards;
  animation: dash-check .5s .5s ease-in-out forwards;
}
p {
  text-align: center;
  margin: 20px 0 60px;
  font-size: 1.25em;
}

@-webkit-keyframes dash {
  0% {
    stroke-dashoffset: 1000;
  }
  100% {
    stroke-dashoffset: 0;
  }
}
@keyframes dash {
  0% {
    stroke-dashoffset: 1000;
  }
  100% {
    stroke-dashoffset: 0;
  }
}
@-webkit-keyframes dash-check {
  0% {
    stroke-dashoffset: -100;
  }
  100% {
    stroke-dashoffset: 900;
  }
}
@keyframes dash-check {
  0% {
    stroke-dashoffset: -100;
  }
  100% {
    stroke-dashoffset: 900;
  }
}
.abc 
{
  position: absolute;
  left: 50%;
  top: 50%;
  -webkit-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  color: white;
  display: none;
}
h1
{
  text-align: center;
  font-family: sans-serif;
}
  </style>
</head>
<body>
<div class="abc">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
            <circle class="path circle" fill="none" stroke="#00E236" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
            <polyline class="path check" fill="none" stroke="#00E236" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
        </svg>
        <h1>Data has been appended successfully!!!</h1>
    </div>
</body>
<script>
  document.getElementsByClassName('abc')[0].style.display="block";
  setTimeout(()=>{window.location.href="upload.php"},1000);
</script>
</html>