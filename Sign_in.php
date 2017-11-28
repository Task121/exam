<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="Question.css">
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
<div class="side_bar"></div>  
<div class="content contain container">
	<?php
		session_start(); 
		$_SESSION['is_loged_in']=false;
	?>

	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
		<h1>Sign in</h1>
		Enter your Id : <input type="text"  class=" input_choice form-control" id="focusedInput" name="admin_id"><br><br><!-- checked if is this a number -->
		<input type="submit" class="btn btn-primary" onclick="return validate_sign_in()" name="submit_written_question"><br><br><br>
	</form>


	<?php

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$_SESSION['signIn']= $_POST["admin_id"];
			//echo $_SESSION['signIn'];
			checkSignIn();
		}
		
		function checkSignIn(){
			$db = "db_exam";
			$conn = new mysqli('localhost', 'root', '', $db);
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 
			//echo "<br>Connected successfully";
			
			//echo "<br><br>";
			if (!is_null($_SESSION['signIn'])) {
				$sql = "SELECT user_id FROM user WHERE user_id = 1 ";
				//$sql = 'SELECT user_id FROM user WHERE user_id == $_SESSION["signIn"]';
				//echo "<br>".$sql."<br>";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					 while($row = $result->fetch_assoc()) {
					 	$id = $row["user_id"];
					 	if ($id == $_SESSION['signIn']){
					 		header("Location: http://localhost/exam/CreateQuestion.php");
					 	}
				        /*echo "id: " . $row["user_id"]. "<br><br>THis is <br><br>";*/
				    }
				}
			}
			$conn->close();
		}
		


		?>
	<!-- <form action="" method="">
		<h2>Radio Button Question</h2><br><br>
		Question text: <input type="text" class=" input_question form-control" id="focusedInput" name="radio_question"><br>
		Question Choice 1: <input type="text" class="input_choice form-control" id="focusedInput" name="choice_1">
		Question Choice 2: <input type="text" class=" input_choice form-control" id="focusedInput" name="choice_2">
		Question Choice 3: <input type="text" class="input_choice form-control" id="focusedInput" name="choice_3">
		Question Choice 4: <input type="text" class=" input_choice form-control" id="focusedInput" name="choice_4"><br>
		Question Answer: <input type="text" class="input_question form-control" id="focusedInput" name="answer"><div id="check_answer" class="check_answer">This fields must be like just one of the Choicse option</div><br>
		<input type="submit" class="btn btn-primary" name="submit_radio_question"><br><br><br>
		<h2>Wriiten Question</h2><br><br>
		Enter the written question: <input type="text" class=" input_question form-control" id="focusedInput" name="question_text"><br>
		Enter the answer: <input type="text" class=" input_question form-control" id="focusedInput" name="question_text_answer"><br>
		<input type="submit" class="btn btn-primary" name="submit_written_question"><br><br><br>
	</form> -->
 <!--  <?php
	$db = "db_exam";
	$conn = new mysqli('localhost', 'root', '', $db);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	echo "Connected successfully";
	
	echo "<br><br>";
	
	$sql = "SELECT * FROM question";
	$result = $conn -> query($sql);
	$result2 = $conn -> query($sql);
	$count = 0;
	echo "<form>";
	if ($result->num_rows > 0) {
	    // output data of each row
	    //here we have two way based on DB
	    //the first one is to make afixed question "radio + written " without order
	    //second way is to make them separated by making two while loop
	    //while the data will not more than 100 "while exam dont have enough time to solve it "
	    //then the time will accept if it was O(n^2) while we have a small data
	    while($row = $result->fetch_assoc()) {
	    	
	    	if(!is_null($row['question_choice'])){
	    		$count++;
	    		 $arr = explode(".", $row['question_choice']);
	    		 echo  $count . ": ".$row["question_content"]."<br> <br>". "<input type='radio' name=$count value = $arr[0] >" .  $arr[0] ."<br>". "<input type='radio' name=$count value = $arr[1] >" .  $arr[1] ."<br>". "<input type='radio' name=$count value = $arr[2] >" .  $arr[2] ."<br>". "<input type='radio' name=$count value = $arr[3] >" .  $arr[3] ."<br> <br> <br>";
	    	}
	    }
	   	$count =0;
	    while($row = $result2->fetch_assoc()) {
	    	if(is_null($row['question_choice'])){
	    		$count++;
	    		 echo  $count . ": ".$row["question_content"]."<br>". "<textarea cols='50' rows='5'></textarea>". "<br> <br> <br>";
	    	}
	    }
	} else {
	    echo "0 results";
	}
	
	echo "</form>";

	$conn->close();
	?> -->
	<br><br>
</div>

</body>
</html>
