<html lang="en" class="no-js"> <!--<![endif]-->
    <?php
        session_start();
        include ('src/DataBase.php');
        include ('src/registerNewUser.php');
        include ("src/SendMail.php");
        $db = new DataBase();
        $db1 = $db->NefosDB();
        if ($_SERVER['REQUEST_METHOD'] == "POST")  {
            $username = mysqli_real_escape_string($db1, $_POST['username']);
            $name = mysqli_real_escape_string($db1, $_POST['name']);
            $surname = mysqli_real_escape_string($db1, $_POST['surname']);
            $email = mysqli_real_escape_string($db1, $_POST['email']);
            $pass1 = mysqli_real_escape_string($db1, $_POST['pass1']);
            $pass2 = mysqli_real_escape_string($db1, $_POST['pass2']);
            $_SESSION['email'] = $email;
            
            $filter = "/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/";
            //check password:
            if (strlen($pass1) < 8 || preg_match($filter, $pass1)) {
                    header("Location: register.php");
                    return;
            }

            $user = new registerNewUser($username, $name, $surname, $email, $pass1, $pass2);
            $register = $user->InsertToDB($db1);
            if($register){ 
                MailTo($email, $username, $db1);
                header("Location: home.php");
            }

        }
    ?>
    <head>
        <script>
            function checkPass(){
                //Store the password field objects into variables ...
                var pass1 = document.getElementById('pass1');
                var pass2 = document.getElementById('pass2');
                //Set the colors we will be using ...
                var goodColor = "#66cc66";
                var badColor = "#ff6666";
                //Compare the values in the password field 
                //and the confirmation field
                if(pass1.value == pass2.value){
                    //The passwords match. 
                    //Set the color to the good color and inform
                    //the user that they have entered the correct password 
                    pass2.style.backgroundColor = goodColor;
                }else{
                    //The passwords do not match.
                    //Set the color to the bad color and
                    //notify the user.
                    pass2.style.backgroundColor = badColor;
                }
            }

            function SubmitValidation(){
                 var pass1 = document.getElementById('pass1');
                 var pass2 = document.getElementById('pass2');
                 var checkPass = ValidatePassword(pass1.value);
                 if(checkPass == true && pass1.value == pass2.value && pass1.value != "" && mail1.value != ""){
                     return true;
                 }
		 return false;
            }
            
            
            function ValidatePassword(pass1){
                var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{8,}$/;
                if (!regex.test(pass1)) {
                    alert("Minimum 8 characters at least 1 Uppercase Alphabet, 1 Lowercase Alphabet, 1 Number and 1 Special");
                    pass1.focus;
                    return false;
                } else {
                    return true;
                }
            }
        </script>
        <title>UotA Albums</title>
        <link rel="icon" href="images/logo.png">
		<meta charset="UTF-8" />
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/animate-custom.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </head>
	
	<body>
        <div class="container">
            <!-- Codrops top bar -->
            <div class="codrops-top">

                <div class="clr"></div>
            </div><!--/ Codrops top bar -->
            <header>
            <h1>University of the Aegean <span>Photo Albums</span></h1>
                        <a href="index.php"><img id="logo" class="center-block"  src = "Images/logo.png"></a>
                        <h1>Log <span>in</span></h1> 
        </header>
            <form action="register.php" method="POST">
                <label for="name" class="sr-only">Give your name</label>
                <input name="name" id="mail2" type="name" class="form-control" placeholder="Give your name" required>
                <label for="surname" class="sr-only">Give your surname</label>
                <input name="surname" id="mail2" type="surname" class="form-control" placeholder="Give your surname" required>
                <label for="username" class="sr-only">Username</label>
                <input name="username" id="username" type="username" class="form-control" placeholder="username" required autofocus>
                <label for="inputEmail" class="sr-only">Email address</label>
                <input name="email" id="mail1" type="email" class="form-control" placeholder="Email address">
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" name="pass1" id="pass1" class="form-control" placeholder="Password" required>
                <label for="inputPassword" class="sr-only">Confirm your password</label>
                <input type="password" name="pass2"id="pass2" onkeyup="checkPass(); return false;" class="form-control" placeholder="Confirm your password" required>
                <div class="row">
                    </br>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                            <button type="submit" class="btn btn-lg btn-primary btn-block" value="change Location" onclick="SubmitValidation()">Sign Up</button>
                    </div>
                </div>
            </form>
        </div>
	</body>
	
	
</html>