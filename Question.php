<!DOCTYPE html>
<html lang="en">
<head>
  <title>Exam</title>
  <meta charset="utf-8">
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
      <li class="active"><a href="#">Home</a></li>
      <li><a href="Sign_in.php">Sign in</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
    </ul>
  </div>
</nav>
<div class="side_bar"></div>  
<div class="content contain container">
<div id="fun">hey</div>

  <?php
  	session_start();
  	$_SESSION['num_of_radio'] =0;
  	$_SESSION['num_of_written']=0;
  	$_SESSION['num_of_question']=0;
  	$radio_question_id = array();
  	$written_question_id = array();
  	$check_question_answer = array();
	$db = "db_exam";
	$num_of_radio_question = 0;
	$num_of_written_question = 0;

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
	echo "<form  method='POST' name='answer_the_question' onsubmit='return check_question_validation($num_of_radio_question,$num_of_written_question)' >";
	if ($result->num_rows > 0) {
	    // output data of each row
	    //here we have two way based on DB
	    //the first one is to make afixed question "radio + written " without order
	    //second way is to make them separated by making two while loop
	    //while the data will not more than 100 "while exam dont have enough time to solve it "
	    //then the time will accept if it was O(n^2) while we have a small data
	    $radio_id=1;
	    while($row = $result->fetch_assoc()) {
	    	if(!is_null($row['question_choice'])){
	    		$count++;
	    		 $arr = explode(".", $row['question_choice']);
	    		 echo  $count . ": ".$row["question_content"]."<br> <br>". "<input type='radio' name=$count value = $arr[0] >" .  $arr[0] ."<br>". "<input type='radio' name=$count value = $arr[1] >" .  $arr[1] ."<br>". "<input type='radio' name=$count value = $arr[2] >" .  $arr[2] ."<br>". "<input type='radio' name=$count value = $arr[3] >" .  $arr[3] ."<br> <br> <br>";
				array_push($radio_question_id, $radio_id);
	    	}
	    	$radio_id ++;
	    	$num_of_radio_question=$count;
	    	$_SESSION['num_of_radio'] = $num_of_radio_question;
	    }
	    $written_id = 1;
	    while($row = $result2->fetch_assoc()) {
	    	if(is_null($row['question_choice'])){
	    		$count++;
	    		 echo  $count . ": ".$row["question_content"]."<br>". "<textarea cols='50' rows='5' name=$count id=$count></textarea>". "<br> <br> <br>";
	    		 array_push($written_question_id, $written_id);
	    	}
	    	$written_id++;
	    	$num_of_written_question= $count - $num_of_radio_question;
	    	$_SESSION['num_of_written']=$num_of_written_question;
	    	$_SESSION['num_of_question']=$_SESSION['num_of_written']+$_SESSION['num_of_radio'];
	    }
	} else {
	    echo "0 results";
	}
	echo $num_of_radio_question;
	echo "<br>";
	print_r($radio_question_id);
	$_SESSION['radio_question_id'] = implode(',', $radio_question_id);
	$_SESSION['written_question_id'] = implode(",", $written_question_id);
	echo "<br>";
	print_r($written_question_id);
	echo "<br>";
	echo $num_of_written_question;
	echo "<br><br>";
	echo"<input type='submit' onclick='return check_question_validation($num_of_radio_question,$num_of_written_question)' class='btn btn-primary' name='submit_answers'><br><br><br>";
	echo "</form>";
	
	if(isset($_POST['submit_answers'])){
		check_answers();
		get_result();
	}
	function check_answers(){
		for ($i=1; $i <= $_SESSION['num_of_radio'] ; $i++) { 
			$degree = $i."";
			if (!is_null($_POST[$degree])) {
				$answer_id = $i;
				$user_id = 2;
				$question_id = $i;
				$answer = $_POST[$degree];
				$answer_check = 0;
				
			}
			else{
				$message = "U need to answer Question number" . $degree;
				echo "<script type='text/javascript'>alert('$message');</script>";
				return false;
			}
		}
		for ($i=$_SESSION['num_of_radio']+1 ; $i <= $_SESSION['num_of_question'] ; $i++) { 
			$degree = $i."";
			if ($_POST[$degree] != "") {
				
			}
			else{
				$message = "U need to answer Question number" . $degree;
				echo "<script type='text/javascript'>alert('$message');</script>";
				return false;
			}
		}
	}
	function get_result(){
		$conn = mysqli_connect("localhost", "root", "", "db_exam");
		$sql1="SELECT answer_id FROM answer";
		$rowcount =0;
		if ($result=mysqli_query($conn,$sql1)){
				// Return the number of rows in result set
				 $rowcount=mysqli_num_rows($result);
				 //echo $rowcount;
				 // Free result set
				 mysqli_free_result($result);
		}
		//echo "<br><br> This is the rowcount".$rowcount."<br>";
		$count_radio_id=0;
		$count_written_id=0;
		$correct_answer_array = array();
		$wrong_answer_array = array();
		$degree = 0;
		for ($i=$rowcount+1; $i < $rowcount+$_SESSION['num_of_radio'] ; $i++) { 
			//echo "<br><THis is i".$i."<br>";
			$degree = $i."";
			$input_answer = $_POST[$degree.""];
			$answer_id = $i;
			$user_id=2;
			$radio_question_id = explode(",", $_SESSION['radio_question_id']);
			$written_question_id = explode(",", $_SESSION['written_question_id']);
			$answer = "";
			$conn = new mysqli("localhost", "root", "", "db_exam");
			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 
			$sql = "SELECT question_id,question_answer FROM question WHERE question_id=$radio_question_id[$count_radio_id]";
			$count_radio_id++;
			$result = $conn->query($sql);
			/*echo "<br> <br> This is the a session : <br>".$_SESSION['radio_question_id']."<br>";*/
			if ($result->num_rows > 0) {
			    // output data of each row
			    $row = $result->fetch_assoc();
			        //echo "question_id: " . $row["question_id"]. " - question_answer: " . $row["question_answer"]. "<br>";
			    $correct_answer = $row["question_answer"];
			    /*echo "<br>This is Correct :".$correct_answer;
			    echo "<br> This is input :".$input_answer."<br>";*/
			    $correct_answer = strtolower($correct_answer);
			    $correct_answer = str_replace('.','',$correct_answer);
			    $input_answer = strtolower($input_answer);
			    $input_answer = str_replace('.','',$input_answer);
			    

			    if($correct_answer == $input_answer){
			    	$sql = "INSERT INTO answer (answer_id, user_id,question_id,answer_answer,answer_check) VALUES ($answer_id,2,'".$radio_question_id[$count_radio_id]."',$correct_answer ,1)";
			    	array_push($correct_answer_array, $i);
			    }
			    else{
			    	$sql = "INSERT INTO answer (answer_id, user_id,question_id,answer_answer,answer_check) VALUES ($answer_id,2,'".$radio_question_id[$count_radio_id]."',$correct_answer ,0)";
			    	array_push($wrong_answer_array, $i);
			    }

			} else {
			    /*echo "0 results";*/
			}
			$degree++;
			$conn->close();
		}
		$count_written_id = 0;
		$degree++;
		for ($i=$rowcount+$_SESSION['num_of_radio']+1; $i <= $rowcount+$_SESSION['num_of_radio']+$_SESSION['num_of_written'] ; $i++) {
			$input_answer = $_POST[$degree.""];
			$written_question_id = explode(",", $_SESSION['written_question_id']);
			$answer_id = $i;
			$user_id=2;
			$conn = new mysqli("localhost", "root", "", "db_exam");
			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 
			$sql = "SELECT question_id,question_answer FROM question WHERE question_id=$written_question_id[$count_written_id]";
			$count_written_id++;
			$result = $conn->query($sql);
			/*echo "<br> <br> This is the a session : <br>".$_SESSION['radio_question_id']."<br>";*/
			if ($result->num_rows > 0) {
			    // output data of each row
			    $row = $result->fetch_assoc();
			        //echo "question_id: " . $row["question_id"]. " - question_answer: " . $row["question_answer"]. "<br>";
			    $correct_answer = $row["question_answer"];
			    
			    $correct_answer = strtolower($correct_answer);
			    $correct_answer = str_replace('.','',$correct_answer);
			    $input_answer = strtolower($input_answer);
			    $input_answer = str_replace('.','',$input_answer);
			    echo "<br>This is Correct :".$correct_answer;
			    echo "<br> This is input :".$input_answer."<br>";
			    if($correct_answer == $input_answer && !is_null($written_question_id[$count_written_id]) ){
			    	$sql = "INSERT INTO answer (answer_id, user_id,question_id,answer_answer,answer_check) VALUES ($answer_id,2,'".$written_question_id[$count_written_id]."',$correct_answer ,1)";
			    	array_push($correct_answer_array, $i);
			    }
			    else{
			    	$sql = "INSERT INTO answer (answer_id, user_id,question_id,answer_answer,answer_check) VALUES ($answer_id,2,'".$written_question_id[$count_written_id]."',$correct_answer ,0)";
			    	array_push($wrong_answer_array, $i);
			    }

			} else {
			    /*echo "0 results";*/
			}

			$degree++;
			$conn->close();
		 }
		echo "<br> This is the correct answer <br>";
		print_r ($correct_answer_array);
		echo "<br> this is the incorrect answer <br>";
		print_r ($wrong_answer_array);
		$message = "the num of correct answer = ".sizeof($correct_answer_array)."<br> the num of wrong answer = ".sizeof($wrong_answer_array)."<br>" ;
		echo "<script type='text/javascript'>alert('$message');</script>";
		$conn->close();
	}
	
	?>
	<br><br>
</div>

</body>
</html>
