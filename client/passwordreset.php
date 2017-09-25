<!doctype html>
<!--
Group member:
Hoang Huu Tat Dat - 7287975
Sarah Martinelli Benedetti - 7636905
/-->
<html lang="en" ng-app>
<head>
  <title>Instagram assignment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/bootstrap.min.css?v2">
  <link rel="stylesheet" href="./css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="./css/font-awesome.min.css">
  <link rel="stylesheet" href="./css/main.css">
  <link rel="stylesheet" href="./css/login.css">
  
</head>
<body class="clearfix">
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
              <p class="text-center description-page">Please insert the new password - don't worry a confirmation email will be sent to finish the process:</p>
                <div class="bg-danger">
                  <p id="error"></p>
                </div>
              <form action="">
                <div class="form-group">
                  <input type="text" name="email" id="email" class="form-control" placeholder="Email" required autofocus/>
                </div>

                <div class="form-group">
                  <input type="password" name="password" id="password" class="form-control" placeholder="Password" required/>
                </div>

                <div class="form-group">
                  <input type="password" id="repeat_password" class="form-control" placeholder="Repeat Password" required/>
                </div>

                <div class="form-group">
                  <button class="btn btn-blue" onclick="handleResetAttempt()">Reset Password</button>
                </div>
              </form>
            </div>
            <a href="login" class="login-container col-md-12 pull-left">Remembered your password? Awesome, Login here.</a>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="/js/jquery.min.js"></script>
  <script src="/js/forgetpassword.js"></script>
</body>
</html>
