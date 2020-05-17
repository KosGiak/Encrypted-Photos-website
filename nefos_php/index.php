    <html lang="en">
        <?php
		session_start();
		include ('src/DataBase.php');
                include ('src/registeredUser.php');
                $db = new DataBase();
                $db1 = $db->NefosDB();
		if ($_SERVER['REQUEST_METHOD'] == "POST" && (isset($_POST['register'])) ) {
			header("Location: register.php");
		}
		if ($_SERVER['REQUEST_METHOD'] == "POST" && (isset($_POST['policy'])) ) {
			header("Location: policy.html");
		}
		if ($_SERVER['REQUEST_METHOD'] == "POST" && (isset($_POST['login']))) {
			$email = $_POST['email'];
			$pass = $_POST['password'];
                        $user = new registeredUser();
                        $user->Constructor_Mail_Pass($email, $pass);
                        $login = $user->Login();
                        echo '</br></br>Login() @index: ', $login;
                        if($login){
                            $_SESSION['email'] = $email;
                            header("Location: home.php");
                        }
                        else{
                            header("Location: index.php");
                        }
		}
		
	?>
    <script>
        function ValidateEmail(mail1){
          var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

          if (!filter.test(mail1)) {
              alert('Please provide a valid email address');
              mail1.focus;
              return false;
          }
          return true;
        }  
        function SumbitValidation(){
          var password = document.getElementById('password');
          var email = document.getElementById('email');
          var mailCheck = ValidateEmail(email.value);
          if(mailCheck != true && email.value && password.value == ""){
            alert("give your email address and your password.")
          }
        }
    </script>
  <head>
      
    <title>UotA Albums</title>
    <link rel="icon" href="Images/logo.png">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
	  <link rel="stylesheet" type="text/css" href="css/demo.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
	
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  	<!--Background img: -->
  	<link href="css/demo.css" rel="stylesheet">
  </head>

  <body>
    <div class="container">
        <header>
            <h1>University of the Aegean <span>Photo Albums</span></h1>
                        <a href="index.php"><img id="logo" class="center-block"  src = "Images/logo.png"></a>
                        <h1>Log <span>in</span></h1> 
        </header>
        <form action="index.php" method="POST">
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Email address" autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
            </br>
            <div class="row">
                <div class="col-sm-4">
                    <button name="login"class="btn btn-lg btn-primary btn-block" value="login" type="submit">Sign in</button>
                </div>
                <div class="col-sm-4">
                    <button name="register"class="btn btn-lg btn-primary btn-block" value="register" type="submit">Sign Up</button></a>
                </div>

                <div class="col-sm-4">
                  <button name="policy"class="btn btn-lg btn-primary btn-block" value="policy" type="submit">Policy</button></a>
                </div>
            </div> 
        </form>
    </div> <!-- /container -->
  </body>
</html>
