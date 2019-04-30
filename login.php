<?php
session_start();
        include("config.php");
        $Username = $_POST['user'];
        $Password = $_POST['pass'];
        $sql="SELECT * FROM sysuser Where username='".$Username."' and password='".$Password."' ";

        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)==1){

            $row = mysqli_fetch_array($result);

            $_SESSION["UserID"] = $row["sys_id"];
            $_SESSION["User"] = $row["name"];
            $_SESSION["Userlevel"] = $row["type"];

            if($_SESSION["Userlevel"]=="administrators"){

              Header("Location: admin_page.php");

            }

            if ($_SESSION["Userlevel"]=="staff"){

              Header("Location: staff_page.php");

            }

            if ($_SESSION["Userlevel"]=="lecturers"){

              Header("Location: lecturers_page.php");

            }

        }else{
          echo "<script>";
              echo "alert(\" user หรือ  password ไม่ถูกต้อง\");";
              echo "window.history.back()";
          echo "</script>";

        }

?>
