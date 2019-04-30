<?php
session_start();
error_reporting(0);
include("config.php");
if($_SESSION["Userlevel"]!="administrators"){
  Header("Location: index.php");
}
$sql = "SELECT * FROM tb_booking b,tb_room r where b.room_id = r.id order by b.sdate";
$result = $conn->query($sql);

$approve = $_GET['approve'];
if($approve == 'yes'){
  $idroom = $_GET['id'];
  $sqlyes ="UPDATE tb_booking SET approve = 1 WHERE tb_booking.id = '".$idroom."'";
  if ($conn->query($sqlyes) === TRUE) {
    Header("Location: admin_nroom.php");
} else {
    echo "Error updating record: " . $conn->error;
}
}
if($approve == 'no'){
  $idroom = $_GET['id'];
  $sqlno ="UPDATE tb_booking SET approve = 2 WHERE tb_booking.id = '".$idroom."'";
  if ($conn->query($sqlno) === TRUE) {
    Header("Location: admin_nroom.php");
} else {
    echo "Error updating record: " . $conn->error;
}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>รายการจองห้อง</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
<style>
/* Add a black background color to the top navigation */
.topnav {
  background-color: #333;
  overflow: hidden;
}

/* Style the links inside the navigation bar */
.topnav a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

/* Change the color of links on hover */
.topnav a:hover {
  background-color: #ddd;
  color: black;
}

/* Add an active class to highlight the current page */
.active {
  background-color: #4CAF50;
  color: white;
}

/* Hide the link that should open and close the topnav on small screens */
.topnav .icon {
  display: none;
}

</style>
<!-- Latest compiled and minified JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script></head>
<script>
/* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>
<body>
  <div class="container">
  <div class="row">
    <div class="col-md-12">
      <!-- Load an icon library to show a hamburger menu (bars) on small screens -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="topnav" id="myTopnav">
  <a href="admin_page.php">หน้าหลัก</a>
  <a href="admin_listroom.php">รายการห้อง</a>
  <a href="admin_nroom.php" class="active">รายการจองห้อง</a>
  <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>
      <h2 class="text-center">รายการห้องทั้งหมด</h2>
      <table class="table table-bordered">
        <thead>
          <tr>
            <td class="text-center">ชื่อห้อง</td>
            <td class="text-center">วันเวลาที่จอง</td>
            <td class="text-center">การใช้งาน</td>
            <td class="text-center">อนุมัติการใช้งาน</td>
          </tr>
        </thead>
        <tbody>
      <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
          <td><?php echo $row["name"]; ?></td>
          <td><?php echo date("d-m-Y", strtotime($row["sdate"])); ?> : เวลา <?php echo $row["start_time"]; ?> - <?php echo $row["end_time"]; ?></td>
          <td><?php echo $row["title"]; ?></td>
          <td class="text-center">
            <?php if($row["approve"] == 0) {?> <a href="?approve=yes&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success">อนุมัติ</a> <?php } ?>
            <?php if($row["approve"] == 0) {?> <a href="?approve=no&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">ไม่อนุมัติ</a> <?php } ?>
            <?php if($row["approve"] == 1) {?> <span style="color:green;">อนุมัติเรียบร้อยแล้ว</span> <?php } ?>
            <?php if($row["approve"] == 2) {?> <span style="color:red;">ไม่อนุมัติ</span> <?php } ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
      </table>
    </div>
</div>
</div>
</body>
</html>
