<?php   

/*
SongHelper.php

This file is a helper class that provides functions to allow users to 
buy songs to myMusic, add songs to a playlist, remove a song
as well as display songs.
*/


/*
Function takes a string $song and a string $textfile and searches for 
the song in the text file. If file exists and the song is not a duplicate add to file.
The functions unserialize and serialize will help in storing array to text file in array representation.
That way it is easier to retrieve and maniplulate.
Text File: If it exists, 
get_contents->read->add if necessary->put back
*/
function buy_song($song, $textFile){
	if(file_exists($textFile)){
		$mySongsContents = file_get_contents($textFile);
		$unSerializedMySongs = unserialize($mySongsContents);

		if(!empty($unSerializedMySongs)){
			if(in_array($song, $unSerializedMySongs)){
				echo "<p>You have already purchased the song: $song </p>";
			}
			else{
				$unSerializedMySongs[] = $song;
				echo "<p>You have successfully purchased the song: $song </p>";
			}
		}
		else{
			$unSerializedMySongs[] = $song;
			echo "<p>You have successfully purchased the song: $song </p>";
		}
		$serializedMySongs = serialize($unSerializedMySongs);
		file_put_contents($textFile, $serializedMySongs);
	}
}
/*
Function takes a 3 string params ($song-to add, $mySongsFile-songs with purchased songs, $myPlaylistsFile-playlist to add to). 
Check if both files exist. Then retrieve contents as array format. Check to see if song is is in array of bought songs.
Check to see if song exist in playlist. 
Otherwise add song to playlist then put the array back into text file.
*/
function add_song($song, $mySongsFile, $myPlaylistsFile){

	if(file_exists($mySongsFile) && file_exists($myPlaylistsFile)){
		$mySongsContents = file_get_contents($mySongsFile);
		$unSerializedMySongs = unserialize($mySongsContents);
		$myPlaylistContents = file_get_contents($myPlaylistsFile);
		$unSerializedMyPlaylist = unserialize($myPlaylistContents);

		if(!in_array($song, $unSerializedMySongs)){
			echo "<p>You do not own this song<p>";
		}

		else{
			if(!empty($unSerializedMyPlaylist)){
				if(in_array($song, $unSerializedMyPlaylist)){
					echo "<p>You have already added the song: $song </p>";
				}
				else{
					$unSerializedMyPlaylist[] = $song;
					echo "<p>You have successfully added the song: $song </p>";
				}
			}
			else{
				$unSerializedMyPlaylist[] = $song;
				echo "<p>You have successfully added the song: $song </p>";
			}
		}
		$serializedMyPlaylist = serialize($unSerializedMyPlaylist);
		file_put_contents($myPlaylistsFile, $serializedMyPlaylist);

		header('location: MyPlaylist.php');
	}
}
/*
Takes two string parameters $song and $texFile. Check to see file exists. Then check to see if song is in array if so unset that array element (remove). Finally playce updated array content back into text file.
*/
function remove_song($song, $textFile){

	if(file_exists($textFile)){
		$mySongsContents = file_get_contents($textFile);
		$unSerializedMySongs = unserialize($mySongsContents);

		if(!empty($unSerializedMySongs) && in_array($song, $unSerializedMySongs)){
			$index = array_search($song, $unSerializedMySongs);
			unset($unSerializedMySongs[$index]);
		}

		else{
			echo "<p>Invalid Song: $song</p>";
		}

		$serializedMySongs = serialize($unSerializedMySongs);
		file_put_contents($textFile, $serializedMySongs);
	}
}
/*
Function annotates a song. by taking song to annotate an annotation and a testfile.
If song does not exist notify user.
*/

function annotate_song($song, $annotation, $textFile){

	if(file_exists($textFile)){
		$mySongsContents = file_get_contents($textFile);
		$unSerializedMySongs = unserialize($mySongsContents);

		if(!empty($unSerializedMySongs) && in_array($song, $unSerializedMySongs)){
			$index = array_search($song, $unSerializedMySongs);
			$unSerializedMySongs[$annotation] = $unSerializedMySongs[$index];
			unset($unSerializedMySongs[$index]);

			$serializedMySongs = serialize($unSerializedMySongs);
			file_put_contents($textFile, $serializedMySongs);
		}
		else{
			echo "<p>Invalid Song: $song</p>";
		}
	}
}
/*
Takes one parameter $textFile.
Check to see if file exists. If so, Retrieve array in text file check if empty. 
If not, iterate through array print songs
*/
function display_songs($textFile){

	if(file_exists($textFile)){
		$mySongsContents = file_get_contents($textFile);
		$unSerializedMySongs = unserialize($mySongsContents);

		if(empty($unSerializedMySongs)){
			echo "<p>You have no songs to view!</p>";
		}
		else{
			foreach($unSerializedMySongs as $key => $song){
				$temp = 0;
				if(is_int($key)){
					$temp = $key + 1;
				}
				else{
					$temp = $key;
				}
				echo "<li> <i>$temp</i>. <u>$song</u></li>";
			}
		}
	}
} 

?>