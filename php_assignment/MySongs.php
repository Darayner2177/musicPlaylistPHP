
<!-- 
MySongs.php

This php file displays the songs that were purchased it also validates a post sent by the user 
to remove a song. This file relies on two other php files for functions. 
-->


<?php include_once('SongHelper.php'); include_once('MyHeader.php');

/*
validate user request to remove a song if input is invalid add to 
errors array otherwise handle input with remove any characters and encode using htmlentities
*/

$errors = array();
$userInput = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(empty($_POST['remove'])){
		$errors[] = "Please enter song!";
	}
	else{
		global $userInput;
		$userInput = handle_input($_POST['remove']);
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

	<div>
		<h1>MY SONGS</h1>
		<ul class = "mySongs">
			<?php display_songs('txt_files/mySongs.txt'); ?>
		</ul>
		<br/>
	</div>
		<form action = "<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method = "POST">
			<div>
				<p>Remove Song by Name:<input type = "text" name = "remove"> <button type = "submit">REMOVE</button></button></p><br/>
				<p>
				<?php 

					/*if user input contains errors print them out otherwise remove the song (user input)*/
					if(!empty($errors)){
						foreach($errors as $error){
							echo "<p>Error: $error</p>";
						}
					}
					else if(!empty($userInput)){
						remove_song($userInput, 'txt_files/mySongs.txt');
					}
				?>
			</p>
		</div>
	</form>
</body>
</html>