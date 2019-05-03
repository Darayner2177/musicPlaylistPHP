
<!--
	Playlists.php
	
	This file will handle post via user input depending on which post was sent 
	the process will check create input and view input fields. Errors are diplayed if input is invalid.
	Otherwise handle input. Relies on other files for functionality.
	Displays all user playlists.
-->


<?php include_once('SongHelper.php'); include_once('MyHeader.php'); include_once('PlaylistHelper.php');

/*
validate user request to create a playlist or to view a playlist
if input is invalid add to errors array otherwise handle input remove any invalid characters and encode using htmlentities
*/

$errors = array();
$userInput = '';
$createPlaylist = false;
$viewPlaylist = false;
$rename = false;
$uerInputTo = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(key($_POST) == 'create'){
		$createPlaylist = true;
		if(empty($_POST['create'])){
			$errors[] = "Please enter playlist to create!";
		}
		else{
			$userInput = handle_input($_POST['create']);
		}
	}
	if(key($_POST) == 'view'){
		$viewPlaylist = true;
		if(empty($_POST['view'])){
			$errors[] = "Please enter playlist to view!";
		}
		else{
			$userInput = handle_input($_POST['view']);
		}
	}
	if(key($_POST) == 'from' || key($_POST) == 'to'){
		$rename = true;
		if(empty($_POST['from']) || empty($_POST['to'])){
			$errors[] = "Please enter valid Input!";
		}
		else{
			$userInput = handle_input($_POST['from']);
			$userInputTo = handle_input($_POST['to']);
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

	<div>
		<h1>MY PLAYLISTS</h1>
		<ul class = "mySongs">
			<?php  display_playlists('txt_files/myPlaylists.txt'); ?>
		</ul>
		<br/>
	</div>

	<div>
		<form action = "<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method = "POST">
			<p>Create Playlist:<input type = "text" name = "create"> <button type = "submit">CREATE</button></button></p><br/>
			<?php 
			/*if no errors and createPlaylist post was called then create the playlist*/
				if($createPlaylist){
					if(!empty($errors)){
						foreach($errors as $error){
							echo "<p>Error: $error</p>";
						}
					}
					else if(!empty($userInput)){
						create_playlist($userInput);
					}
				}
			?>
		</form>

		<form action = "<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method = "POST">
			<p>View Playlist by Name:<input type = "text" name = "view"> <button type = "submit">VIEW</button></button></p><br/>
				<?php 
				/*If no errors and $viewPlaylist post was called then view the playlist*/
				if($viewPlaylist){
					if(!empty($errors)){
						foreach($errors as $error){
							echo "<p>Error: $error</p>";
						}
					}
					else if(!empty($userInput)){
						view_playlist($userInput);
					}
				}
			?>
		</form>

		<form action = "<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method = "POST">
			<p>Rename Playlist From:<input type = "text" name = "from">To:<input type = "text" name = "to"><button type = "submit">RENAME</button></button></p><br/>
				<?php 
				/*if no errors and $remame post was called then rename the playlist*/
				if($rename){
					if(!empty($errors)){
						foreach($errors as $error){
							echo "<p>Error: $error</p>";
						}
					}
					else if(!empty($userInput) && !empty($userInputTo)){
						rename_playlist($userInput, $userInputTo);
					}
				}
				?>
		</form>
	</div>
</body>
</html>