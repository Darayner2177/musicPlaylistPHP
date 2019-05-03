<!--
ZTunes.php

This php file stores the songs to the ZTunes store each time the user buys a song it is added to MySongs
relies on two files for functionality. Handles post and encodes.
-->


<?php include_once('SongHelper.php'); include_once('MyHeader.php'); ?>

	<form action = "<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method = "POST">
		<div>
			<h1>ZTUNES SONGS</h1>

		<ul id="playlist" class = "Ztunes">
       	 	<li>Good Day ($1.99)<button type = "submit" name = "music"  value = "Good Day">BUY</button></li>
        	<li>Cool Story ($1.99)<button type = "submit" name = "music"  value = "Cool Story" >BUY</button></li>
        	<li>Sky Is Blue ($1.99)<button type = "submit" name = "music"  value = "Sky Is Blue">BUY</button></li>
        	<li>Thank You ($1.99)<button type = "submit" name = "music"  value = "Thank You">BUY</button></li>
		</ul><br/>

		<?php
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if(isset($_POST['music'])){
					buy_song($_POST['music'], 'txt_files/mySongs.txt');
				}
			}
		?>

		</div>
	</form>
	</body>
</html>