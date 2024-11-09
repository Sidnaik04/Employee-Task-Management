<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login | Task Management System</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">
	<style>
		.login-body{
			background: hsla(249, 100%, 37%, 1);
			background: linear-gradient(135deg, hsla(249, 100%, 37%, 1) 0%, hsla(0, 0%, 0%, 1) 82%);
			background: -moz-linear-gradient(135deg, hsla(249, 100%, 37%, 1) 0%, hsla(0, 0%, 0%, 1) 82%);
			background: -webkit-linear-gradient(135deg, hsla(249, 100%, 37%, 1) 0%, hsla(0, 0%, 0%, 1) 82%);
			filter: progid: DXImageTransform.Microsoft.gradient( startColorstr="#1C00BB", endColorstr="#000000", GradientType=1 );
			min-height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
			color: #fff;

		}
		.login-body form{
			background: rgba(255, 255, 255, 0.31);
			border-radius: 16px;
			box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
			backdrop-filter: blur(14.2px);
			-webkit-backdrop-filter: blur(14.2px);
			/* border: 1px solid rgba(255, 255, 255, 1); */
			padding: 50px;
			width: 100%;
			max-width: 400px;
		}
		.display-4 {
			text-align: center;
			margin-bottom: 20px;
			font-weight: bold;
			color: #333;
		}
		.alert {
			text-align: center;
		}
		.mb-3 label {
			font-weight: bold;
		}
		.form-control {
			font-size: 16px;
		}
		.btn-primary {
			display: block;
			width: 100%;
			font-size: 18px;
			font-weight: bold;
			margin-top: 20px;
		}


	</style>
</head>
<body class="login-body">

      
      <form method="POST" action="app/login.php" class="shadow p-4">

      	  <h3 class="display-4" style="color: #fff;">LOGIN</h3>
      	  <?php if (isset($_GET['error'])) {?>
      	  	<div class="alert alert-danger" role="alert">
			  <?php echo stripcslashes($_GET['error']); ?>
			</div>
      	  <?php } ?>

      	  <?php if (isset($_GET['success'])) {?>
      	  	<div class="alert alert-success" role="alert">
			  <?php echo stripcslashes($_GET['success']); ?>
			</div>
      	  <?php } 

                // $pass = "12345";
                // $pass = password_hash($pass, PASSWORD_DEFAULT);
                // echo $pass;
      
      	  ?>
  
			
		  <div class="mb-3">
		    <label for="exampleInputEmail1" class="form-label">User name</label>
		    <input type="text" class="form-control" name="user_name">
		  </div>
		  <div class="mb-3">
		    <label for="exampleInputPassword1" class="form-label">Password</label>
		    <input type="password" class="form-control" name="password" id="exampleInputPassword1">
		  </div>
		  <button type="submit" class="btn btn-primary">Login</button>
		</form>


      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>