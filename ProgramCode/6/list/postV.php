<?php 
	$cities_db = mysqli_connect ("localhost","root","","db4");
	mysqli_query($cities_db,"SET NAMES 'utf8'");
	$result = mysqli_query($cities_db, "SELECT `Код_должность`, `Наименование_должн` FROM `сп_должности`");
	while ($row = mysqli_fetch_assoc($result)) 
	{
		$id = $row['Код_должность'];
        $name = $row['Наименование_должн'];

		echo "<option value='$id'>$id - $name</option>";
	}

?>