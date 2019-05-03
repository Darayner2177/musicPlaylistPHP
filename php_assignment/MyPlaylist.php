<!--
	MyPlaylist.php
	
	This file will handle post via user input depending on which post was sent 
	the process will check create input and view input fields. Errors are diplayed if input is invalid.
	Otherwise handle input. Relies on other files for functionality.
	Displays Current user Playlist.
-->

<?php include_once('SongHelper.php'); include_once('MyHeader.php'); include_once('PlaylistHelper.php');

/*
validate user request to add a song to playlist or to remove a song from playlist.
if input is invalid add to errors array otherwise handle input, remove any invlalid characters and encode using htmlentities
*/

$errors = array();
$userInput = '';
$addSong = false;
$removeSong = false;
$playlist = current_playlist();
$annotate = false;
$userInputTo = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(key($_POST) == 'add'){
		$addSong = true;
		if(empty($_POST['add'])){
			$errors[] = "Please enter song to add!";
		}
		else{
			$userInput = handle_input($_POST['add']);
		}
	}
	if(key($_POST) == 'remove'){
		$removeSong = true;
		if(empty($_POST['remove'])){
			$errors[] = "Please enter song to remove!";
		}
		else{
			$userInput = handle_input($_POST['remove']);
		}
	}
	if(key($_POST) == 'song' || key($_POST) == 'annotate'){
		$annotate = true;
		if(empty($_POST['song']) || empty($_POST['annotate'])){
			$errors[] = "Please enter valid Input!";
		}
		else{
			$userInput = handle_input($_POST['song']);
			$userInputTo = handle_input($_POST['annotate']);
		}
	}
}

function handle_input($input){
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlentities($input);

	return $input;
}
?>

	<div>
		<h1><?php echo strtoupper(trim($playlist,"txt_files/")). "<br/>";?>PLAYLIST</h1>
		<ul class = "mySongs">
			<?php display_songs($playlist); ?>
		</ul>
		<br/>
	</div>
		<form action = "<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method = "POST">
			<div>
				<p>Add By Song Name:<input type = "text" name = "add"> <button type = "submit">ADD</button></button></p><br/>
				<?php 
				/*if no errors and addSong post was called then add the song*/
				if($addSong){
					if(!empty($errors)){
						foreach($errors as $error){
							echo "<p>Error: $error</p>";
						}
					}
					else if(!empty($userInput)){
						add_song($userInput,'txt_files/mySongs.txt', $playlist);
					}
				}
				?>
		</form>

		<form action = "<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method = "POST">
			<p>Remove by Song Name:<input type = "text" name = "remove"> <button type = "submit">REMOVE</button></button></p><br/>
				<?php 
				/*if no errors and $removeSongs post was called then remove the song*/
				if($removeSong){
					if(!empty($errors)){
						foreach($errors as $error){
							echo "<p>Error: $error</p>";
						}
					}
					else if(!empty($userInput)){
						remove_song($userInput, $playlist);
					}
				}
				?>
		</form>
		<form action = "<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method = "POST">
			<p>Annotate Song:<input type = "text" name = "song">With:<input type = "text" name = "annotate"><button type = "submit">ANNOTATE</button></button></p><br/>
				<?php 
				/*if no errors and $annotate post was called to annotate a song*/
				if($annotate){
					if(!empty($errors)){
						foreach($errors as $error){
							echo "<p>Error: $error</p>";
						}
					}
					else if(!empty($userInput) && !empty($userInputTo)){
						annotate_song($userInput, $userInputTo, $playlist);
					}
				}
				?>
		</form>
</body>
</html>