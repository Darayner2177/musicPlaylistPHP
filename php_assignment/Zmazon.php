<!--
Zmazon.php

This php file stores the songs to the Zmazon store each time the user buys a song it is added to MySongs
relies on two files for functionality. Handles post and encodde.
-->


<?php include_once('SongHelper.php'); include_once('MyHeader.php'); ?>

	<form action = "<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method = "POST">
		<div>
			<h1>ZMAZON SONGS</h1>

		<ul id="playlist" class = "Ztunes">
       	 	<li>Everyday Is The Day ($1.99)<button type = "submit" name = "music"  value = "Everyday Is The Day">BUY</button></li>
        	<li>Awesome Time ($1.99)<button type = "submit" name = "music"  value = "Awesome Time" >BUY</button></li>
        	<li>You said what? ($1.99)<button type = "submit" name = "music"  value = "You said what?">BUY</button></li>
        	<li>Time is alright ($1.99)<button type = "submit" name = "music"  value = "Time is alright">BUY</button></li>
		</ul>

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