<?php 
	$cities_db = mysqli_connect ("localhost","root","","db4");
	mysqli_query($cities_db,"SET NAMES 'utf8'");
	$result = mysqli_query($cities_db, "SELECT `Код_реквизиты`, `Название_орган`,`УНП_орган`,`Адр_орган` 
    FROM `сп_реквизиты`");
	while ($row = mysqli_fetch_assoc($result)) 
	{
		$id = $row['Код_реквизиты'];
        $name = $row['Название_орган'];
        $unp = $row['УНП_орган'];
        $address = $row['Адр_орган'];

		echo "<option value='$id'>$id - $name - $unp - $address</option>";
	}

?>

