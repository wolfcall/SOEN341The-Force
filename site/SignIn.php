<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>The Force - Scheduler</title>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Bootstrap -->
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <!--Custom-->
    <link rel="stylesheet" type="text/css" href="css/custom.css">
<!--    Background animation-->
    <script type="text/javascript" src="js/custom.js"></script>
<!--      Form validation-->
    <script type="text/javascript" src="js/validator.js"></script>  
      
    

    <script>
      <?php
        include 'PHP/functions.php';                           
      ?>
    </script>
            

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/validator.js"></script>  
      <script type="text/javascript" src="js/custom.js"></script>  

      <div id="top-image"></div>
        <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">THE FORCE</a>
        </div>
      </div>
    </nav>
      
      <div class="rowTop">
            <div class="page-header">
            <h1>WELCOME TO THE FORCE</h1>
            <p class="lead">SCHEDULE MAKER</p>
          </div>
      </div>
      
      <div class="rowTabs">
        <div class="col-md-6">
            <div class="contain">
                
                <form id="signin" data-toggle="validator" role="form" action='PHP/signin_up.php' method='post'>
                    <h4 class="form-signin-heading">Sign in</h4>
                  <div class="form-group">
					<input type="hidden" value="signin" name="reason" />
                    <input type="email" class="form-control" name="inputEmail" placeholder="Email" data-error="That email address is invalid." required>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                      <input type="password" data-minlength="6" class="form-control" name="inputPassword" placeholder="Password" required>
                      <span class="help-block">Minimum of 6 characters</span>
                  </div>
                    
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">Sign in</button>
                  </div>
                </form>
                
                
          </div>
        </div>
        <div class="col-md-6">
            <div class="contain"><h4>Create your schedule with The Force.</h4>
                 <ul>
                  <li>Designed specifically for the Software Engineering program.</li>
                  <li>Build your academic record.</li>
                  <li>Select your schedule preferences.</li>
                <li>Create an optimized schdule automatically.</li>
                </ul>
                <a  href="#foo" data-toggle="modal" data-target="#myModal">Don’t have an account? Create one now.</a>
            </div>  
          </div> 
      </div>
      
       
      <!-- Modal code -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Create Account</h4>
                      </div>
                      <div class="modal-body">
                          
                          <form id="signup" data-toggle="validator" role="form" method="post" action="PHP/signin_up.php">
							<input type="hidden" value="signup" name="reason" />
                            <div class="form-group">
                                 <input type="text" class="form-control" name="InputFirstName" placeholder="First Name*" required>
                              </div>
							  <div class="form-group">
                                 <input type="text" class="form-control" name="InputLastName" placeholder="Last Name*" required>
                              </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="InputEmail" placeholder="Email*" data-error="That email address is invalid." required>
                                <div class="help-block with-errors"></div>
                              </div>
                              <div class="form-group">
                                  <input type="password" data-minlength="6" class="form-control" name="InputPassword" placeholder="Password*" required>
                                  <span class="help-block">Minimum of 6 characters</span>
                                </div>
                                <?php
                                  echo loadClasses("finished");
                                ?>
                              <div class="form-group">
                              <button type="submit" class="btnModal btn-primary">Create Account</button>
                              </div>
                          </form>
  
                      </div>
                    </div>
                  </div>
                </div>
      <form action="PHP/geotest.php" method="POST">
		  <input type="submit" value="test" />
	  </form>
      
  </body>
</html>