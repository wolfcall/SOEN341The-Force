<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
<?php
include "functions.php";
$con = getCon();

//$class_ID=$_POST[class_id];

$class_ID = array('COMP 249', 'SOEN 341', 'ENGR 201', 'SOEN 228', 'ENGR 213');

$IDs = array();
for ($i = 0; $i < sizeOf($class_ID); $i++)
		$IDs[$i] = array($classID[$i],("select id from course_master_list where Course_code = ". substr($array[$i],-4)." and number = ".(int)substr($array[$i],5)));

$sections = array();
for ($i = 0; $i < sizeOf($class_ID); $i++)
{
	for ($j = 0; $j < 3; $j++)
	{
	$sections[$j] = array($classID[$i],("select Section from Sections where course_master_list_id = ".$IDs[$i][1]));
	echo $sections[$i][$j];
	}
}
closeCon($con);
?>
</body>
</html>