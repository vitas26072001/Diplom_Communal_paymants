<?php 
	$cities_db = mysqli_connect ("localhost","root","","db4");
	mysqli_query($cities_db,"SET NAMES 'utf8'");
	$result = mysqli_query($cities_db, "SELECT `Код_ед_хран`, `Наименование_ед_хран` FROM `сп_единицы_хранения`");
	while ($row = mysqli_fetch_assoc($result)) 
	{
		$id = $row['Код_ед_хран'];
        $name = $row['Наименование_ед_хран'];

		echo "<option value='$id'>$id - $name</option>";
	}

?>