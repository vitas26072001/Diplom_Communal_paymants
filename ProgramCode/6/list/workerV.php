<?php 
	$cities_db = mysqli_connect ("localhost","root","","db4");
	mysqli_query($cities_db,"SET NAMES 'utf8'");
	$result = mysqli_query($cities_db, "SELECT `Код_сотрудн`, `ФИО`, `Наименование_должн`
    FROM `сп_сотрудники`
    INNER JOIN `сп_должности` ON `сп_сотрудники`.`Код_должность`=`сп_должности`.`Код_должность`
    ORDER BY `ФИО` ASC");
	while ($row = mysqli_fetch_assoc($result)) 
	{
		$id = $row['Код_сотрудн'];
        $name = $row['ФИО'];
        $post = $row['Наименование_должн'];
		
		echo "<option value='$id'>$id - $name - $post</option>";
   
	}

?>