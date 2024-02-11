<?php 
	$cities_db = mysqli_connect ("localhost","root","","db4");
	mysqli_query($cities_db,"SET NAMES 'utf8'");
	$result = mysqli_query($cities_db, "SELECT `Код_услуги`, `Наим_услуги`, `Наименование_ед_хран`, `Тариф`  
    FROM `сп_услуги`
    INNER JOIN `сп_единицы_хранения` ON `сп_услуги`.`Код_ед_хран`=`сп_единицы_хранения`.`Код_ед_хран`
    ORDER BY `Наим_услуги` ASC");
	while ($row = mysqli_fetch_assoc($result)) 
	{
		$id = $row['Код_услуги'];
        $service = $row['Наим_услуги'];
		$unit = $row['Наименование_ед_хран']; 
        $tariff = $row['Тариф']; 
		echo "<option value='$id'>$id - $service - $unit - $tariff </option>";
   
	}

?>