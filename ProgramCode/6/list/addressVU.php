<?php 
	$cities_db = mysqli_connect ("localhost","root","","db4");
	mysqli_query($cities_db,"SET NAMES 'utf8'");
	$result = mysqli_query($cities_db, "SELECT `Код_адрес_обслуж`, `Адрес_обслуж`, `ФИО_потреб`  
    FROM `сп_адреса_обслуживания`
    INNER JOIN `сп_потребители` ON `сп_адреса_обслуживания`.`Код_потреб`=`сп_потребители`.`Код_потреб`
    WHERE  
    ORDER BY `Адрес_обслуж` ASC");
	while ($row = mysqli_fetch_assoc($result)) 
	{
		$id = $row['Код_адрес_обслуж'];
        $address = $row['Адрес_обслуж'];
		$name = $row['ФИО_потреб']; 
		echo "<option value='$id'>$address - $name </option>";
	}

?>