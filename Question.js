function check_question_validation(num1 , num2){
	var x = document.forms["answer_the_question"]["20"].value;
	alert(x);
	return error;
}
function check_question_validate(num1 , num2){
	alert("hello");
	var x1 = document.getElementsByName("1");
	for (var i = 0; i < x1.length ; i++) {
		alert(x[i].value);
	}
}
function validate_sign_in(){
	if (document.getElementById("focusedInput").value == "") {
		alert("u need to fill the text");
		return false;
	}
	if (document.getElementById("focusedInput").value == parseInt(document.getElementById("focusedInput").value,10)) {
	}
	else{
		alert("u need to insert int");
	}
}
function check_question_validation(num1 , num2){
	document.getElementById('fun').innerHTML = "Helllllllllllllo";
	for (var i =1 ; i <= num1 ; i++) {
		var index = i+"";
		var check_radio = document.getElementsByName(index);
		if(!check_radio[0].checked && !check_radio[1].checked  && !check_radio[2].checked  && !check_radio[3].checked ){
			alert("You need to answer question "+ i);
			return false;
		}
		else{

		}
	}
	for (var i = num1+1; i <= num1+num2; i++) {
		alert(i);
		var index = i;
		var index= index+"";
		var check_textarea = document.getElementById(index);
		if (check_textarea.value == '') {
			alert("You need to answer question " + i );
		}else{
			alert("its is filled " + i);
			return false;
		}
	}
	var x = true;
	return false;
}
