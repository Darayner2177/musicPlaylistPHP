
<?php 
/*
PlaylistHelper.php

This file is a helper class that provides functions to allow users to create playlists, display playlists 
as well as view the playlist contents and find the current playlist.
*/


/*
Function takes one string parameter $playlistName that is the name of the playlist.
the playlist will be created as a txt file. The playlist name will be added to the myPlaylists 
txt file to store all playlists. Checks to see if playlist has been created already. If not create the playlist.
*/
function create_playlist($playlistName){
	$playlistTxtFile = "txt_files/$playlistName.txt";
	$myPlaylistsTxt = file_get_contents('txt_files/myPlaylists.txt');
	$unSerializedMyPlaylistsTxt = unserialize($myPlaylistsTxt);

	if(file_exists($playlistTxtFile)){
		echo "<p>This playlist already exists</p>";
	}

	else{
		file_put_contents($playlistTxtFile, "");
		$unSerializedMyPlaylistsTxt[] = $playlistName;
		$unSerializedMyPlaylists = serialize($unSerializedMyPlaylistsTxt);
		file_put_contents('txt_files/myPlaylists.txt', $unSerializedMyPlaylists);
	}
}
/*
Function Renames old playlist name to new playlist name.
validate if old playlist exists. If so the old playlist is renamed.
Then updates the name of the file in the myplaylists text file.
Retrive contents of myPlaylists text file find index of old playlist.
replace indexed name with new name.
*/
function rename_playlist($oldPlaylistName, $newPlaylistName){
	$oldPlaylistTxtFile = "txt_files/$oldPlaylistName.txt";
	$newPlaylistTxtFile = "txt_files/$newPlaylistName.txt";

	if(!file_exists($oldPlaylistTxtFile)){
		echo "<p>This playlist does not exist!</p>";
	}

	else if(rename($oldPlaylistTxtFile, $newPlaylistTxtFile)){
		$myPlaylistsTxt = file_get_contents('txt_files/myPlaylists.txt');
		$unSerializedMyPlaylistsTxt = unserialize($myPlaylistsTxt);

		$index = array_search($oldPlaylistName, $unSerializedMyPlaylistsTxt);
		$unSerializedMyPlaylistsTxt[$index] = $newPlaylistName;

		$unSerializedMyPlaylists = serialize($unSerializedMyPlaylistsTxt);
		file_put_contents('txt_files/myPlaylists.txt', $unSerializedMyPlaylists);

		echo "<p>Playlist $oldPlaylistName has been changed to $newPlaylistName</p>";
	}

	else{
		echo "Playlist with the same name exists!";
	}
}

/*
Function takes one string parameter $textFile that contains all the user inputs 
Check to see if file exists and is not empty get the formatted array print the playlists.
*/
function display_playlists($textFile){

	if(file_exists($textFile)){
		$myPlayListContents = file_get_contents($textFile);
		$unSerializedMyPlaylists = unserialize($myPlayListContents);

		$i = 0;
		if(!empty($unSerializedMyPlaylists)){
			foreach($unSerializedMyPlaylists as $playlist){
				$i++;
				echo "<li>$i. $playlist</li>";
			}
		}
		else{
			echo "<p>You have no playists to view!</p>";
		}
	}

	else{
		echo "<p>You have no playists to view!</p>";
	}
}
/*
Function takes one string parameter $playlistName that contains all the user inputs 
Check to see if file exists if so update the current playlist file. And send off to 
MyPlaylist file so the user can view the playlist
*/
function view_playlist($playlistName){
	$playlistTxtFile = "txt_files/$playlistName.txt";
	
	if(!file_exists($playlistTxtFile)){
		echo "<p>Playlist does not exist</p>";
	}

	else{
		file_put_contents('txt_files/currentPlaylist.txt', $playlistTxtFile);
		header('location: MyPlaylist.php');
	}
}
/*
Function checks to see which playlist is being viewed. Returns that playlist file
*/
function current_playlist(){
	$currentPlaylist = file_get_contents('txt_files/currentPlaylist.txt');

	if(empty($currentPlaylist)){
		$currentPlaylist = 'txt_files/myPlaylist.txt';
	}

	return $currentPlaylist;
}

?>