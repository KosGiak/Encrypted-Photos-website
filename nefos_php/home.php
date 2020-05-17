  <head>
    <?php
        session_start();
        include ('src/DataBase.php');
        include ('src/registeredUser.php');
        include ('src/uploadPhoto.php');
        include ('src/viewPhoto.php');
        include ('src/DecryptPhoto.php');
        
        
        if(!isset($_SESSION['email'])){
            header("Location: index.php");
        }
        $db = new DataBase();
        $db1 = $db->NefosDB();
        $email = $_SESSION['email'];
        $client = new registeredUser();
        $client->Constructor_Mail($email);
        $client->FindUser();       
    ?>
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
    <div class="navbar navbar-default navbar-fixed-top" role="navigation" id="slide-nav">

        <div class="container">
         <div class="navbar-header">
          <a class="navbar-toggle"> 
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
           </a>
           <a href="home.php"><img id="logo" class="navbar-brand"  src = "images/logo.png"></a>

         </div>
         <div id="slidemenu">
            <form method="post" enctype="multipart/form-data" method="POST" class="navbar-form navbar-right" role="form">
                <?php
                    if($client->getValidate()==1){
                        ?>
                        <div class='form-group'>
                            <input type="file" name="image" class="btn btn-primary">
                        </div>
                        <input type="submit" value="Upload photo" name="submit" class="btn btn-primary">
                <?php
                    }//end if if($client->getValidate()==1)
                    if ($_SERVER['REQUEST_METHOD'] == "POST"){           
                        if(isset($_POST['submit'])){
                            $check = getimagesize($_FILES["image"]["tmp_name"]);
                            if($check == FALSE){
                                header("Location: home.php");
                            }
                            else{
                                $image = (file_get_contents($_FILES['image']['tmp_name']));
                                $name = addslashes($_FILES['image']['name']);
                                $upload = new uploadPhoto();
                                $upload->Constructor_Email($email);
                                $uploadFlag = $upload->InsertPhotoToDB($image, $name);
                                
                                if($uploadFlag){
                                    echo "<script> alert('Comple') </script>";
                                }
                                else{
                                    echo "<script> alert('Error') </script>";
                                }
                            }
                        }
                        else{
                            echo "<script> alert('Error') </script>";
                        }
                    }
                ?>
              
            </form>

            <ul class="nav navbar-nav">
                <li><a href="home.php">Home</a></li>
                <?php

                    if (isset($_GET['validate'])) {
                        include"src/SendMail.php";
                        MailTo($email, $client->getUsername(), $db1);
                    }
                    if($client->getValidate()==0){
                        echo "<li><a href='home.php?validate=true' >Validate your email</a></li>";
                    }            
                ?>
                <li><a href="src/Logout.php">Logout</a></li>
            </ul>          
         </div>
            
        </div>
        
      </div>
      
      </br> </br> </br>
        <?php
            $photo = new viewPhoto();
            $result = $photo->Display($client->getId());
            $sum=0;
            
            echo "<div class=\"container\">
                      <div class=\"row\">
                            <div class=\"col-lg-12\">
                            <ul class=\"timeline\">";
            while($row = $result->fetch_assoc()){
                $id = $row["id"];
                $name = $row["name"];
                $image = $row["image"];
               
                $de = new DecryptPhoto($client->getId(), $image);
                $image = $de->getImage();
                $image = base64_encode($image);
//                <a href='downloads/$image' download='$image'class='btn btn-primary' >Download</a>
                if($sum%2 == 0){
                    echo "

                            <li>
                              <div class=\"timeline-image\">";
                                    echo '<img height="600" width="800" src="data:image;base64,'.$image.'">';
                                    echo "</a>
                              </div>
                              <div class=\"timeline-panel\">
                                    <div class=\"timeline-heading\">
                                      <h4>".$name."</h4>
                                      <h4 class=\"subheading\"></h4>
                                    </div>
                                    <div class=\"timeline-body\">
                                       
                                      <a href='src/deletePhoto.php?fn=photoID&id=$id'><button name='Delete' id='Delete' type='submit' class='btn btn-primary'>Delete</button></a>
                                      </br></br>
                                    </div>
                              </div>
                            </li>";
            }
            else{
//<a href='src/downloadPhoto.php?fn=photoID&id=$id'><button name='Download' id='Download' type='submit' class='btn btn-primary'>Download</button></a>
                    echo "<li class=\"timeline-inverted\">
                          <div class=\"timeline-image\">";
                                    echo '<img height="600" width="800" src="data:image;base64,'.$image.'">';
                                    echo "</a>
                          </div>
                              <div class=\"timeline-panel\">
                                    <div class=\"timeline-heading\">
                                      <h4>".$name."</h4>
                                      <h4 class=\"subheading\"></h4>
                                    </div>
                                    <div class=\"timeline-body\">
                                      
                                      <a href='src/deletePhoto.php?fn=photoID&id=$id'><button name='Delete' id='Delete' type='submit' class='btn btn-primary'>Delete</button></a>
                                      </br></br>
                                    </div>
                              </div>
                            </li>";
            }
                $sum++;
            }
            
echo    "</ul>
        </div>
        </div>
        </div>		
        ";	

            
        ?>
  </body>
