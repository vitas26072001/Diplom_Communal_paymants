<?php 
	$cities_db = mysqli_connect ("localhost","root","","db4");
	mysqli_query($cities_db,"SET NAMES 'utf8'");
	$result = mysqli_query($cities_db, "SELECT `Код_потреб`, `ФИО_потреб`, `Лицевой_счет`  FROM `сп_потребители`");
	while ($row = mysqli_fetch_assoc($result)) 
	{
		$id = $row['Код_потреб'];
        $name = $row['ФИО_потреб'];
		$nom = $row['Лицевой_счет']; 
		echo "<option value='$id'>$id - $name - $nom </option>";
	}

?>