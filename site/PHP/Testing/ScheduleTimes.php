<?php
include "../functions.php";
session_start();
$con = getCon();
$userId = $_SESSION['loginID'];
//$class_ID = array(0=>'COMP 249', 1=>'SOEN 341', 2=>'ENGR 201', 3=>'SOEN 228', 4=>'ENGR 213');
$class_ID = $_REQUEST['chosen'];
$section = array();
$IDs = array();
$Times = array();
$Timesf = array();
$DOW = array();
$TEMP = array();
$NC = array();
$val = 0;
$val2 = 0;
print_r($userId." </br>");
//for if he enrolled in classes before
$sqlEnr = "select Sections_course_Master_List_id from enrollment where Student_idStudent = '".$userId."'";
$queryEnr = $con->query($sqlEnr);
$resultEnr = mysqli_fetch_all($queryEnr);
$enrolled = array();
for ($i = 0; $i < count($resultEnr)+1; $i++)
{
	print_r($resultEnr[$i][0]." </br>");
	$class_ID[] = $resultEnr[$i][0]; 
	//print_r($enrolled[count($class_ID)+$i]);
}

//$class_ID = array_merge($class_ID, $enrolled);
//stores ID of classes to be retrieved later
/*
for ($i = 0; $i < count($class_ID); $i++){
	$subs = substr($class_ID[$i],0,4);
	$subs1 = substr($class_ID[$i],5,3);
	$sql = "select id from course_Master_List where Course_code = '".$subs."' and number = ".$subs1;
	$query = $con->query($sql);
	$result = mysqli_fetch_array($query);
	$IDs[$i] = $result[0];
	var_dump($IDs[$i]." ");
	echo "<br />";
}
*/
//pick a section
//echo "<br />";
$timebool = array();//for all courses, if no conflic, put to true
$index = array();
for ($i = 0; $i < count($class_ID)-1; $i++)
{
	$timebool[] = true;
	$index[$i] = 0;
}
for ($i = 0; $i < count($class_ID)-1; $i++)
{
	//$sql45 = "select Section from Sections where course_Master_List_id = '".$class_ID[$i]."'";
	//$query45 = $con->query($sql45);
	//$resultsec = mysqli_fetch_array($query45);
	$section[$i] = getSection($class_ID[$i],$index[$i]);
	print_r("section :".$section[$i]." </br>");
	//print_r($section[$i]." ");
	//echo "<br />";
}
/*$sqlEnrSec = "select Sections_Section from enrollment where Student_idStudent = '".$userId."'";
$queryEnrSec = $con->query($sqlEnrSec);
$resultEnrSec = mysqli_fetch_array($queryEnrSec);
$enrolledSec = array();
for ($i = 0; $i < count($resultEnrSec); $i++)
{
	$enrolledSec[count($section)+$i] = $resultEnrSec;
}
$section = array_merge($section, $enrolledSec);
*/

do

{
	for ($i = 0; $i < count($class_ID)-1; $i++)
	{
		$timebool[$i] = true;
	}
for ($i=0; $i < count($class_ID)-1; $i++){
	$sqlstart = "select start from Timeslot where Sections_course_Master_List_id = '".$class_ID[$i]."' and Sections_Section = '".$section[$i]."'";
	$query1 = $con->query($sqlstart);
	$result1 = mysqli_fetch_all($query1);
	$Times[$i]=$result1;
	//var_dump($Times[$i][0]." ");
	for($j = 0; $j < 2; $j++)
	{
	$Times[$i][$j] = $Times[$i][$j][0];
	$Times[$i][$j] = str_replace(":","",$Times[$i][$j]);
	}
	//print_r($Times[$i]);
	echo "<br />";
}

//echo "<br />";
for ($i=0; $i < count($class_ID)-1; $i++){
	$sqlend = "select end from Timeslot where Sections_course_Master_List_id = '".$class_ID[$i]."' and Sections_Section = '".$section[$i]."'";
	$query2 = $con->query($sqlend);
	$result2 = mysqli_fetch_all($query2);
	$Timef[$i]=$result2;
	//var_dump($Timef[$i]." ");
	
	for($j = 0; $j < 2; $j++)
	{
	$Timef[$i][$j] = $Timef[$i][$j][0];
	$Timef[$i][$j] = str_replace(":","",$Timef[$i][$j]);
	}
	//print_r($Timef[$i]);
	//echo "<br />";
}
//echo "<br />";

for ($i=0; $i < count($class_ID)-1; $i++){
	$sqlDOW = "select DOW from Timeslot where Sections_course_Master_List_id = '".$class_ID[$i]."' and Sections_Section = '".$section[$i]."'";
	$query3 = $con->query($sqlDOW);
	$result3 = mysqli_fetch_all($query3);
	$TEMP[$i] = $result3;
	//var_dump($TEMP[$i]." ");
	for($j = 0; $j < 2; $j++)
	{
	$TEMP[$i][$j] = $TEMP[$i][$j][0];
	}
	//print_r($TEMP[$i]);
	//echo "<br />";
}


for($i=0; $i<count($TEMP); $i++){
	for($j=0; $j<count($TEMP[$i]); $j++){
		if (strlen($TEMP[$i][j])>1){
			$DOW[$i][$j] = explode("," , $TEMP[$i][$j]);
		}
		else{
			$DOW[$i][$j] = $TEMP[$i][$j];
		}
	}
}



$tempo = "";
for ($j=0; $j<count($class_ID)-1; $j++)
{
	$DOW[$j][2] = $DOW[$j][1];
	
	$tempo = $DOW[$j][0];
	
	$DOW[$j][0] = substr($tempo, 0, strpos($tempo, ','));
	$DOW[$j][1] = substr($tempo, strpos($tempo, ',')+1);
	
	
	//print_r($DOW[$j]);
	//echo "<br />";
}

//Olivier Algorithm section


if (count($class_ID)-1 > 1)
{
	
//will check for the first 4 course
for ($i = 0; $i < count($class_ID)-2; $i++)
{
	//print_r($Times[$i]." </br>");
	for ($j = $i+1; $j < count($class_ID)-1; $j++)
	{
		if ($DOW[$i][0] != $DOW[$j][0] && $DOW[$i][1] != $DOW[$j][0] && $DOW[$i][0] != $DOW[$j][1] && $DOW[$i][1] != $DOW[$j][1])//no common lectures DOW
		{
			if ($DOW[$i][2] != $DOW[$j][2])//no common tutorial DOW
			{
				//if ($DOW[$i][0] != $DOW[$j][2] && $DOW[$i][1] != $DOW[$j][2] && $DOW[$j][0] != $DOW[$i][2] && $DOW[$j][1] != $DOW[$i][2])
				//$timebool[$i] = true;
			}
			else
			{
				
				if ((int)$Times[$j][1] < (int)$Timef[$i][1] && (int)$Times[$j][1] >= (int)$Times[$i][1])//starts in middle of other
				{
					$timebool[$i] = false;
				}
				
			}
		}
		else
		{
			
			if ((int)$Times[$j][0] < (int)$Timef[$i][0] && (int)$Times[$j][0] >= (int)$Times[$i][0])//starts in middle of other
			{
				$timebool[$i] = false;
			}
			

			//Have to check Tutorials again
			if ($DOW[$i][2] != $DOW[$j][2])//no common tutorial DOW
			{
				//don't want to overwrite any previous conflicts
			}
			else
			{
				
				if ((int)$Times[$j][1] < (int)$Timef[$i][1] && (int)$Times[$j][1] >= (int)$Times[$i][1])//starts in middle of other
				{
					$timebool[$i] = false;
				}
				
			}
		}
			if ($DOW[$i][0] == $DOW[$j][2]) // ($DOW[$i][1] == $DOW[$j][2] && $DOW[$j][0] != $DOW[$i][2] && $DOW[$j][1] != $DOW[$i][2])
			{
				if ((int)$Times[$j][1] < (int)$Timef[$i][0] && (int)$Times[$j][1] >= (int)$Times[$i][0])//starts in middle of other
				{
					$timebool[$i] = false;
				}
			}
			if ($DOW[$i][1] == $DOW[$j][2])
			{
				if ((int)$Times[$j][1] < (int)$Timef[$i][0] && (int)$Times[$j][1] >= (int)$Times[$i][0])//starts in middle of other
				{
					$timebool[$i] = false;
				}
			}
			if ($DOW[$j][0] == $DOW[$i][2])
				{
					if ((int)$Times[$j][1] < (int)$Timef[$i][0] && (int)$Times[$j][1] >= (int)$Times[$i][0])//starts in middle of other
					{
						$timebool[$i] = false;
					}
				}
			if ($DOW[$j][1] == $DOW[$i][2])
				{
					if ((int)$Times[$j][1] < (int)$Timef[$i][0] && (int)$Times[$j][1] >= (int)$Times[$i][0])//starts in middle of other
					{
						$timebool[$i] = false;
					}
				}
	}
	if ($timebool[$i] == false)
	{
		print_r("NIGGGA </br>");
		$index[$i] += 1;
		print_r("Index :".$index[$i]." </br>");
		if (($timebool[$i] == false) && (index[$i] == 3))
		{
			print_r("NIGGGA WUT </br>");
				goto more;
				print_r("NIGGGA WHY</br>");
		}
		$section[$i] = getSection($class_ID[$i],$index[$i]);
		print_r("section :".getSection($class_ID[$i],$index[$i])." </br>");
		print_r("NIGGA </br>");
	}
}
//This is specifically for the fifth course
for ($j = 0; $j < count($class_ID)-2; $j++)
{
if ($DOW[count($class_ID)-1][0] != $DOW[$j][0] && $DOW[count($class_ID)-1][1] != $DOW[$j][0] && $DOW[count($class_ID)-1][0] != $DOW[$j][1] && $DOW[count($class_ID)-1][1] != $DOW[$j][1])//no common lectures DOW
		{
			if ($DOW[count($class_ID)-1][2] != $DOW[$j][2])//no common tutorial DOW
			{
				//$timebool[count($class_ID)-1] = true;
			}
			else
			{
				
				if ((int)$Times[$j][2] < (int)$Timef[count($class_ID)-1][2] && (int)$Times[$j][2] >= (int)$Times[count($class_ID)-1][2])//starts in middle of other
				{
					$timebool[$j] = false;
				}
				
			}
		}
		else
		{
			
			if ((int)$Times[$j][0] < (int)$Timef[count($class_ID)-1][0] && (int)$Times[$j][0] >= (int)$Times[count($class_ID)-1][0])//starts in middle of other
			{
				$timebool[$j] = false;
			}
			
			//Have to check Tutorials again
			if ($DOW[count($class_ID)-1][2] != $DOW[$j][2])//no common tutorial DOW
			{
				//don't want to overwrite any previous conflicts
			}
			else
			{
				
				if ((int)$Times[$j][2] < (int)$Timef[count($class_ID)-1][2] && (int)$Times[$j][2] >= (int)$Times[count($class_ID)-1][2])//starts in middle of other
				{
					$timebool[$j] = false;
				}
				
			}
		}
		if ($DOW[count($class_ID)-1][0] == $DOW[$j][2]) // ($DOW[$i][1] == $DOW[$j][2] && $DOW[$j][0] != $DOW[$i][2] && $DOW[$j][1] != $DOW[$i][2])
		{
			if ((int)$Times[$j][1] < (int)$Timef[count($class_ID)-1][0] && (int)$Times[$j][1] >= (int)$Times[count($class_ID)-1][0])//starts in middle of other
			{
				$timebool[$j] = false;
			}
		}
		if ($DOW[count($class_ID)-1][1] == $DOW[$j][2])
		{
			if ((int)$Times[$j][1] < (int)$Timef[count($class_ID)-1][0] && (int)$Times[$j][1] >= (int)$Times[count($class_ID)-1][0])//starts in middle of other
			{
				$timebool[$j] = false;
			}
		}
		if ($DOW[$j][0] == $DOW[count($class_ID)-1][2])
		{
			if ((int)$Times[$j][1] < (int)$Timef[count($class_ID)-1][0] && (int)$Times[$j][1] >= (int)$Times[count($class_ID)-1][0])//starts in middle of other
			{
				$timebool[$j] = false;
			}
		}
		if ($DOW[$j][1] == $DOW[count($class_ID)-1][2])
		{
			if ((int)$Times[$j][1] < (int)$Timef[count($class_ID)-1][0] && (int)$Times[$j][1] >= (int)$Times[count($class_ID)-1][0])//starts in middle of other
			{
				$timebool[$j] = false;
			}
		}
		if ($timebool[$j] == false)
		{
		
			$index[$j] += 1;
			print_r("Index :".$index[$j]." </br>");
			if (($timebool[$j]) == false && (index[$j] == 3))
			{
				print_r("NIGGGA WUT </br>");
				goto more;
				print_r("NIGGGA WHY</br>");
			}
			$section[$j] = getSection($class_ID[$j],$index[$j]);
			print_r("section :".getSection($class_ID[$j],$index[$j])." </br>");
			print_r("NIGGA </br>");
		}
}
}
}
while (in_array(false,$timebool));
more:

$errorStr = "";
print_r($timebool[0]." Boo");
for ($i = 0; $i < count($class_ID)-1; $i++)
{
	
	if ($timebool[$i] == false)
	{
		$qry = "select Course_code, number from course_Master_List where id = '".$class_ID[$i]."'";
		
		$query = $con->query($qry);
		$temp = (mysqli_fetch_row($query));
		$errorStr .= ("Course ".$temp[0]." ".$temp[1]." conflicts with other courses <br />");
		
	}	
	else if ($timebool[$i] == true)
	{
		$sql = "INSERT INTO enrollment (Student_idStudent, Sections_Section, Sections_course_Master_List_id) Values ('".$userId."', '".$section[$i]."', '".$class_ID[$i]."')";
		//"select Course_code, number from course_Master_List where id = '".$class_ID[$i]."'";
		$query222 = $con->query($sql);
		//echo $_REQUEST['chosen'];
		//$temp = (mysqli_fetch_row($query));
	//print_r("Course ".$temp[0]." ".$temp[1]." conflicts with other courses");
	//echo "<br />";
	}
}
if ($errorStr != "")
{
	echo $errorStr;
}

$GLOBALS['Times']=$Times;
$GLOBALS['Timef']=$Timef;
$GLOBALS['DOW']=$DOW;
$GLOBALS['timebool'] = $timebool;

header("Location: /index.php");
closeCon($con);

//insert redirect header
?>