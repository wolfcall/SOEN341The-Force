<?php
session_start();
include '../functions.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$con = getCon();
$userId = $_SESSION['loginID'];
$queryforclass = "select id from course_Master_List where Course_code = '".$_POST['Course_code']."' and number = ".$_POST['number'];
$queryresult = $con->query($queryforclass);
$result = mysqli_fetch_row($queryresult);

echo $subs." ".$subs1." ".$GLOBALS['Delete']."<br>".$queryforclass."<br>";
var_dump($result);
    $query = "Delete from Enrollment where Sections_course_Master_List_id ='".$result[0]."' and Student_idStudent = '".$userId."'";
	echo $query;
    $con->query($query);
header("Location: /index.php");
closeCon($con);
?>