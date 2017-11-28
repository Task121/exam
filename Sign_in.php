<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="Question.css">

 <script src="Question.js">
  </script>
</head>
<body>
	<nav class=" nav_bar navbar navbar-inverse">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="#">WebSiteName</a>
	    </div>
	   <ul class="nav navbar-nav">
	      <li class="active"><a href="Question.php">Home</a></li>
	      <li><a href="Sign_in.php">Sign in</a>
	      </li>
	    </ul>
	    <ul class="nav navbar-nav navbar-right">
	      <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
	      <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
	    </ul>
	  </div>
	</nav>
	<div class="side_bar">
		<p style="color:white; font-size: 25px;">Exam</p>
	</div>  
	<div class="side_bar"></div>  
	<div class="content contain container">
		<?php
			session_start(); 
			$_SESSION['is_loged_in']=false;
		?>

		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
			<h1>Sign in</h1>
			Enter your Id : <input type="text"  class="input_number input_choice form-control" id="focusedInput" name="admin_id"><br><br>
			<input type="submit" class="input_submit btn btn-primary" onclick="return validate_sign_in()" name="submit_written_question"><br><br><br>
		</form>

		<?php
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$_SESSION['signIn']= $_POST["admin_id"];
				checkSignIn();
			}
			function checkSignIn(){
				$db = "db_exam";
				$conn = new mysqli('localhost', 'root', '', $db);
				if ($conn->connect_error) {
				    die("Connection failed: " . $conn->connect_error);
				} 
				if (!is_null($_SESSION['signIn'])) {
					$sql = "SELECT user_id FROM user WHERE user_id = 1 ";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						 while($row = $result->fetch_assoc()) {
						 	$id = $row["user_id"];
						 	if ($id == $_SESSION['signIn']){
						 		header("Location: http://localhost/exam/CreateQuestion.php");
						 	}
					    }
					}
				}
				$conn->close();
			}
			?>
		<br><br>
	</div>

</body>
</html>
