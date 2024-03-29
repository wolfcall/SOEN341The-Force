<?php
session_start();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <!-- Files for Bootstrap -->
		<!--meta name="viewport" content="width=device-width, initial-scale=1"-->
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/footer.css">

		<!-- Files for FullCalendar -->
		<link href='css/fullcalendar.css' rel='stylesheet' />
		<link href='css/fullcalendar.print.css' rel='stylesheet' media='print' />
		<script src='js/lib/moment.min.js'></script>
		<script src='js/lib/jquery.min.js'></script>
		<!--script src='js/fullcalendar.min.js'></script-->
		<script src='js/fullcalendar.js'></script>


		<!-- Jquery UI -->
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  		<!-- script for for displaying sections -->
  		<script src='js/displaySections.js'> </script>
		


		<!-- Script for producing the schedule -->
		<!--<script src='js/schedule.js'></script> -->
				
		<script>
			<?php
            
            include "PHP/functions.php";
			// put your code here
			loadSchedule();
			?>
		</script>
        <title></title>
    </head>
    <body>
		<nav class="navbar navbar-default">
		  <div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="index.php">THE FORCE</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

			  <ul class="nav navbar-nav navbar-right">
                  
                  <?php 
                  session_start();
                  if($_SESSION['adminID'] != "")
                      echo "<li><a href = 'AdminAccount.php'>ACCOUNT</a></li>";
                  else
                      echo "<li><a href='Account.php'>ACCOUNT</a></li>";
                  ?>
			<!--	<li><a href="Account.php">ACCOUNT</a></li> -->
				<li><a href="SignIn.php">SIGN OUT</a></li>
				
			  </ul>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>

	<div class="container main-body"> 
        <form id = "semesterForm" name = "semesterForm" action="/PHP/changeSemester.php" method="post">
            <div class="row semester-row">
                <div class="dropdown">
                    <div>Current Semester: <strong><?php echo $_SESSION['semester'];?></strong></div>
                    <select id = "semesters" name = "semesters" onchange="this.form.submit();">
                        <option selected>-- Change Semester --</option>
						<option value="Summer 2016">Summer 2016</option>
                        <option value="Fall 2016">Fall 2016</option>
                        <option value="Winter 2017">Winter 2017</option>
						<option value="Summer 2017">Summer 2017</option>
                        <option value="Fall 2017">Fall 2017</option>
                        <option value="Winter 2018">Winter 2018</option>
						<option value="Summer 2018">Summer 2018</option>
                        <option value="Fall 2018">Fall 2018</option>
                        <option value="Winter 2019">Winter 2019</option>
						<option value="Summer 2019">Summer 2019</option>
                        <option value="Fall 2019">Fall 2019</option>
						<option value="Winter 2020">Winter 2020</option>
						<option value="Summer 2020">Summer 2020</option>
                        <option value="Fall 2020">Fall 2020</option>
                    </select>
                </div>
            </div>
        </form>
            
		<div class="jumbotron">
			<div class="panel-group">
			  <div class="panel panel-default">
			    <div class="panel-heading">
			      <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapse1"><center><h4>MODIFY SCHEDULE</h4></center></a>			   
			      </h4>
			    </div>

			    <form action="/PHP/ScheduleManual.php" method="post">

<!--			    <form id="target" action="ScheduleTimes.php" method="post">-->

			    <div id="collapse1" class="panel-collapse collapse">
			      <div class="panel-body modify-panel">
			      	<div class="col-md-4 checkboxDiv">
			      		<h4> Add Classes</h4>
			      		<!--  <input id="tags" type="text" class="form-control seach-text" placeholder="Ex: COMP 250" name="q">-->
			      		<?php loadClassesIndex("chosen", "sect");?>
			      		<!-- JQUery for autocomplete class list -->
			      		<!--  <script>
						  $(function() {
							  var availableTags = 
						    $( "#tags" ).autocomplete({
						      source: availableTags
						    });
						  });
						  </script>-->
			      	</div>

			      	<div class="col-md-4">
			      		<h4> Add Unavailabilities </h4>
				            <div class="checkbox">
				                              
				                    <label class="checkbox-inline"> 
				                      <input type="checkbox" name="dow[]" id="dow" value=" Mon " name="M"> M
				                    </label>

				                    <label class="checkbox-inline">
				                      <input type="checkbox"  name="dow[]"id="dow" value=" Tues " name="T"> T
				                    </label>

				                    <label class="checkbox-inline">
				                      <input type="checkbox" name="dow[]" id="dow" value=" Wed " name="W"> W
				                    </label>
				                                
				                    <label class="checkbox-inline">
				                      <input type="checkbox" name="dow[]" id="dow" value=" Thur " name="R"> T
				                    </label>

				                    <label class="checkbox-inline">
				                      <input type="checkbox" name="dow[]" id="dow" value=" Fri " name="F"> F
				                    </label>
				                              
				            </div>

				            <input type="time" id="startTime" value="00:00:00">
				            to
				            <input type="time" id="endTime" value="00:00:00">
				            <a onclick="addUnv()">Add</a>
				            <ul id="myList"> </ul>
				
				            
				        <script>
				        //function adds an unavailability to the html list.

				        function addUnv() {
				            var dow = new Array();
				            var lastid = 0;
				            
				            //Use JQuery to retrieve values of checked checkboxes and store them in an array.
				            $.each($("input[name='dow[]']:checked"), function() {
				              dow.push($(this).val());
				            });
							
				            var result = dow.toString();
				            result = result.concat(" from ");
				            var startTime = document.getElementById("startTime").value;
				            var endTime = document.getElementById("endTime").value;
				            result =  result.concat(startTime, " to ", endTime);
                            var generatedID = result + '%' + startTime  + '%' + endTime; 
                            
                            
							//From the line under to the end of the function encapsulate within an if statement if 
                            if (document.getElementById(generatedID) == null){
                                var node = document.createElement("LI");
                                var inputnode = document.createElement("INPUT");
                                inputnode.setAttribute("type", "text");
                                inputnode.setAttribute("value", result);
                                inputnode.setAttribute("name", "unvs[]");
                                inputnode.setAttribute("size", "30");
                                inputnode.readOnly = true;
                                node.appendChild(inputnode);
                                node.setAttribute('id','item'+lastid);
                                var removeButton = document.createElement('a');
                                var icon = document.createElement('span');

                                // add the class to the 'span'

                                icon.className = 'glyphicon glyphicon-remove';
                                removeButton.appendChild(icon);
                                removeButton.className = 'glyphicon glyphicon-remove';
                                removeButton.setAttribute('onClick','removeUnv("'+'item'+lastid+'","'+generatedID+'")');
                                removeButton.setAttribute('class', 'btn btn-link');
                                node.appendChild(removeButton);
                                lastid+=1;
                                document.getElementById("myList").appendChild(node);
                                //Generate ID based on startTime/Endtime
                                $("#unav").append("<input name='"+generatedID+"' type='hidden' value = '" + dow + '%' + startTime + '%' + endTime + "' />");
                            }
                            
				        }
				        
				        //function removes an unavailability from the html list when the remove button is pressed.
				        function removeUnv(itemid, tagid){
				          var item = document.getElementById(itemid);
				          document.getElementById("myList").removeChild(item);
				        }
				        </script>
 
					</div>
                        <div class="col-md-4 checkboxDiv">
                                <div class="compute">
                                      <button type="submit" id="new_worktime" class="btn btn-submit btn-primary recomputeBtn">
                                            <span class="glyphicon glyphicon-refresh"></span> Compute
                                    </button> 
                                      <div class="explainer">*Compute refreshes and optimizes your schedule with manually added classes.</div>
                                </div>
                            <?php /*
                            $Error = $_SESSION['Message'];
                            if (!empty($Error))
                            {
                                print '<script type="text/javascript">';
                                print 'alert('.$Error.')';
                                print '</script>';
                            }*/
                            ?>
                            </form>
                            <form id="target" action="/PHP/ScheduleAuto.php" method="post">
                                <div class="auto">
                                    <div id="unav" ></div>
                                      <button type="submit" id="new_worktime" class="btn btn-submit btn-success recomputeBtn">
                                        <span class="glyphicon glyphicon-calendar"></span> Auto Generate
                                    </button>
                                      <div class="explainer">*Auto Generate intelligently chooses courses based on your unavailabilities and previously passed courses.</div>
                                </div>
                            </form>
                            
                        
                          
                    </div>  
                      
                      
			      </div>
			    </div>
			  </div>
			</div>
		</div>

		<div class="row" class="schedule-content"> 
			<div class="col-md-6 class-table"> 
                                <?php  loadTable()?>
				<table class="table table-bordered class-list" id="class-table">

				</table>
			</div>
			<div class="col-md-6 schedule-container">
				<div id='schedule'> </div>
			</div>
		</div>
	</div>
    
    <div class="site-footer">

        
        <div class="col-xs-6 col-sm-3">
        <center><h3>FRONT END</h3></center><br>
            <center>Julian Ippolito</center>
            <center>Hasan Ahmed</center>
            <center>Jordan Stern</center>
        </div>
        <div class="col-xs-6 col-sm-3">
        <center><h3>BACK END</h3></center><br>
            <center>Georges Mathieu</center>
            <center>Olivier Cameron-Chevrier</center>
            <center>Marc-Andre Dragon</center>
        </div>
        <div class="col-xs-6 col-sm-3">
        <center><h3>DOCUMENTATION</h3></center><br>
            <center>Stefano Pace</center>
            <center>Adam Arcaro</center>
            <center>Joey Tedeschi</center>
        </div>
        <div class="col-xs-6 col-sm-3">
        <center><h3>TESTING</h3></center><br>
            <center>George Theophanous</center>

        </div>
        </div>
    </body>
</html>