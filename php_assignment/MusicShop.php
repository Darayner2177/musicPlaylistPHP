<!--
MusicShop.php

This php file handles user input and displays it back to the screen.
-->

<?php include_once('MyHeader.php'); 

/*
validate user request check to see if userName input is valid. 
*/

$errors = array();
$userInput = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(empty($_POST['name'])){
		$errors[] = "Please enter username!";
	}
	else{
		global $userInput;
		$userInput = handle_input($_POST['name']);
		if(strlen($userInput) <= 5){
			$errors[] = "Username needs to be longer then ".strlen($userInput)." characters";
		}
	}
}
/*handle input remove characters encode*/
function handle_input($input){
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlentities($input);

	return $input;
}


?>

<form action = "<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method = "POST">
	<div>
		<h1>WELCOME!</h1>

		<p>ENTER USERNAME:<p/><br>
			<input type = "text" name = "name"><button type = "submit">ENTER</button><br/>
			<span style="color: green;">*must be longer than 5 characters</span><br/>

		<p>
		<?php 
			if(!empty($errors)){
				foreach($errors as $error){
					echo "Error: $error";
				}
			}
			else if(!empty($userInput)){
				echo "<p>WHAT UP $userInput!</p>";

			}
		?>
		</p>

	</div>
</form>
	</body>
</html>