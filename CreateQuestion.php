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
<div class="side_bar"></div>  
<div class="content contain container">
	<?php
		session_start(); 
		$_SESSION['admin']=1;
		if($_SESSION['signIn'] != 1 ){
			header("Location: http://localhost/exam/Sign_in.php");
			$_SESSION['admin']=0;
		}
	?>
	<form action="" method="POST">
		<h2>Radio Button Question</h2><br><br>
		Question text: <input type="text" class=" input_question form-control" id="focusedInput" name="radio_question"><br>
		Question Choice 1: <input type="text" class="input_choice form-control" id="focusedInput" name="choice_1">
		Question Choice 2: <input type="text" class=" input_choice form-control" id="focusedInput" name="choice_2">
		Question Choice 3: <input type="text" class="input_choice form-control" id="focusedInput" name="choice_3">
		Question Choice 4: <input type="text" class=" input_choice form-control" id="focusedInput" name="choice_4"><br>
		Question Answer: <input type="text" class="input_question form-control" id="focusedInput" name="answer"><div id="check_answer" class="check_answer">This fields must be like just one of the Choicse option</div><br>
		<h2>Written Question</h2><br><br>
		Enter the written question: <input type="text" class=" input_question form-control" id="focusedInput" name="question_text"><br>
		Enter the answer: <input type="text" class=" input_question form-control" id="focusedInput" name="question_text_answer"><br>
		<input type="submit" class="btn btn-primary" name="submit_question"><br><br><br>
	</form>
	<?php
		$db = "db_exam";
		$conn = new mysqli('localhost', 'root', '', $db);

		// Check connection
		if (!$conn) {
		    die("Connection failed: " . mysqli_connect_error());
		}
		else{
			echo "<br> Correct <br>";
		}
		if(isset($_POST['submit_question'])){
			add_new_data();
		}
		function add_new_data(){
			$link = mysqli_connect("localhost", "root", "", "db_exam");
 
			// Check connection
			if($link === false){
			    die("ERROR: Could not connect. " . mysqli_connect_error());
			}

			if ($_POST['radio_question'] != "") {
				if ($_POST['choice_1'] != "" && $_POST['choice_2'] != "" && $_POST['choice_3'] != "" && $_POST['choice_4'] != "" && $_POST['answer'] != "") {
					echo "<br>This is Play<br>";
					$choice_1 = "a:".$_POST['choice_1'].".";
					$choice_2 = "b:".$_POST['choice_2'].".";
					$choice_3 = "c:".$_POST['choice_3'].".";
					$choice_4 = "d:".$_POST['choice_4'].".";
					$answer = $_POST['answer'];
					if($answer == "$choice_1" || $answer == "$choice_2"|| $answer == "$choice_3"|| $answer == "$choice_4"){
						$question_choice = $choice_1 . $choice_2 . $choice_3 .$choice_4;
						$sql1="SELECT question_id FROM question";
						$rowcount =0;
						if ($result=mysqli_query($link,$sql1)){
			  				// Return the number of rows in result set
			 				 $rowcount=mysqli_num_rows($result);
			 				 echo $rowcount;
			 				 // Free result set
			 				 mysqli_free_result($result);
			 			}
			 			if($rowcount !=0){
			 				$rowcount = $rowcount +1;
			 				$sql = "INSERT INTO question (question_id, question_content,question_choice,question_answer,admin) VALUES ($rowcount,'".$_POST['radio_question']."','".$question_choice."','".$answer."' ,1)";
						if(mysqli_query($link, $sql)){
					   				echo "<h3 style='color:blue;'>Records inserted successfully for radio Button Question.</h3>";
							} else{
					   				echo "<h3 style = 'color:red'> ERROR: Could not able to execute $sql.</h3> " . mysqli_error($link);
							}
							}
			 			}
			 			else{
			 				echo "<h3 style='color:red'>You need to match between answer and one of the choices in the radio button question</h3>";
			 			}	
				}
				else{
					echo "<h3 style='color:red'>You need to fill all choices for radio button question </h3>";
				}
			}
			if ($_POST['question_text'] != "") {
				if ($_POST['question_text_answer']) {
					
					$sql1="SELECT question_id FROM question";
						$rowcount =0;
						if ($result=mysqli_query($link,$sql1)){
			  				// Return the number of rows in result set
			 				 $rowcount=mysqli_num_rows($result);
			 				 echo $rowcount;
			 				 // Free result set
			 				 mysqli_free_result($result);
			 			}
			 			if($rowcount !=0){
			 				$rowcount = $rowcount +1;
			 				$sql = "INSERT INTO question (question_id, question_content,question_choice,question_answer,admin) VALUES ($rowcount,'".$_POST['question_text']."', NULL ,'".$_POST['question_text_answer']."' ,1)";
			 				if(mysqli_query($link, $sql)){
					   		echo "Records inserted successfully to Written question.";
							} else{
					   		echo "<h3 style ='color:red;'>ERROR: Could not able to execute $sql. </h3>" . mysqli_error($link);
							}
			 			}
				}
				else{
					echo "<h3 style='color:red'>You need to fill the answer label for the Written Question</h3>";
				}
			}
			if ($_POST['question_text'] == "" && $_POST['radio_question'] == "") {
					echo "<h3 style = 'color:red;'>You Need To Insert One Of These Question Types</h3>";
			}
			}
		mysqli_close($conn);
	?>
</body>
</html>