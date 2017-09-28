<!doctype html>
<html lang="en">
  <head>
    <title>Instagram assignment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css?v2">
    <link rel="stylesheet" href="./css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="./css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/login.css">
    
  </head>

    <?php
        ////https://ikreativ.com/combine-minify-css-with-php/
        ////https://github.com/matthiasmullie/minify
        
        $pageTypeBool = isset($_GET['page']);
        $pageType = $_GET['page']; 

        $repeatPassword = "<div class=\"form-group\">
                  <input type=\"password\" id=\"repeat_password\" class=\"form-control\" name=\"repeatpassword\" placeholder=\"Repeat Password\" required/>
                </div>";
                
        $forgotpassword = "";

        switch ($pageType) {
          case 'signin':
            $descriptionPage = "Welcome to instagram clone!<br>Create your account below:";
            
            // form actions
            $action = "./welcome?page=signin";
            $dataFormtype = "signin";
            
            
            // this button is at the end of page
            $extraBtLinkTo = "./welcome"; 
            $extraBtText = "Already have account? Login here.";
           
            require_once('signin.php');
            break;
          case 'forgetpassword':
            $descriptionPage = "Please insert the new password - don't worry a confirmation email will be sent to finish the process:";
            
            $action = "./welcome?page=forgetpassword";
            //$dataLocation = "";
            $dataFormtype = "forgetpassword";

            // this button is at the end of page
            $extraBtLinkTo = "./welcome"; 
            $extraBtText = "Remembered your password? Awesome, Login here.";

            break;
          default:
            $descriptionPage = "Welcome to instagram clone!<br>Please insert your data to login:";

            // form actions
            
            //$dataLocation = "posts";
            $dataFormtype = "login";

            $repeatPassword = "";
            $forgotpassword = "<hr><a class=\"btn btn-default\" href=\"?page=forgetpassword\">Forgot password</a>";

            // this button is at the end of page
            $extraBtLinkTo = "?page=signin"; 
            $extraBtText = "Don't have account? Join here.";
            
            require_once('login.php');
            break;
        }

        
    ?>
    <body onload="" class="clearfix">
    <main>
      <div class="container">
        <div class="col-md-9 center-block vertical-align">
          <div class="row">
            <div class="col-md-7 hidden-sm hidden-xs">
              <div class="row">
                <div class="animation ">
                  <img src="./img/login/final-animation.gif" alt="screen animation" class="animation-gif img-responsive"></img>
                  <img src="./img/login/celphone.png" alt="Iphones" class="img-responsive">
                </div>
              </div>
            </div>
            <div class="col-md-5 col-sm-12 col-xs-12">
              <div class="login-container clearfix">
                <a href="/" class="logolink">
                  <img src="./img/logotext.svg" class="logotext" width="150">
                </a>
                <p class="text-center description-page"><?= $descriptionPage ?></p>
                <div class="bg-danger">
                  <p id="error"></p>
                </div>
                
                <form action="<?= $action ?>" method="post" id="form" data-location="<?= $dataLocation ?>">
                  <div class="form-group">
                    <input type="email" class="form-control" id="useremail" name="useremail" placeholder="Email" required>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                  </div>
                  <?=$repeatPassword ?>
                  <input type="submit" name="<?= $dataFormtype ?>" value="Submit" class="btn btn-blue">
                   <!-- <button class="btn btn-blue">Submit</button> -->
                  <?=$forgotpassword ?>
                </form>
              </div>
              <a href="<?= $extraBtLinkTo ?>" class="login-container col-sm-12 col-xs-12 col-md-12 pull-left"><?= $extraBtText ?></a>
            </div>
          </div>
        </div>
      </div>
    </main>
    
    <script src="./js/jquery.min.js"></script>
    <?php
        
       // if($pageType == 'forgetpassword'){
       //     echo  '<script src="./js/forgetpassword.js"></script>';
       // } else {
        //     echo  '<script src="./js/login.js"></script>';
       // }
    ?>
    
  </body>

</html>