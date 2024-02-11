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
        $tariff1 = $row['Тариф']; 
      //  $tariff1 = $tariff * $tarif;
		echo "<option value='$tariff1'>$id - $service - $unit - $tariff1 </option>";
	}













    /*$result1 = mysqli_query($cities_db, "SELECT Тариф
    FROM сп_показания 
    INNER JOIN сп_услуги ON сп_показания.Код_услуги = сп_услуги.Код_услуги
    WHERE сп_показания.Код_услуги=1
    AND сп_показания.Код_адрес_обслуж=1
    ORDER BY Код_показания DESC
    LIMIT 1");
    $stmt1 = mysqli_fetch_assoc($result1);
    $Итого_сумма = $stmt1['Тариф'];
    //echo $Итого_сумма."\n";
    echo "<option value='$Итого_сумма'> $Итого_сумма * 100</option>";

    /*$sql = "INSERT INTO сп_показания (Код_адрес_обслуж, Код_услуги, Количество, Итого_сумма) 
            VALUES(:address, :service, :nom, $Итого_сумма)";
    
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':address', $Код_адрес_обслуж);
    $stmt->bindValue(':service', $Код_услуги);
    $stmt->bindValue(':nom', $Количество);
    //$stmt->bindValue($Итого_сумма);
    $result = $stmt->execute();




    /*$result1 = mysqli_query($cities_db, 
    "SELECT Код_показания, Итого_сумма
    FROM сп_показания WHERE Код_адрес_обслуж=1
    ORDER BY Код_показания DESC
    LIMIT 1, 1");

    $result2 = mysqli_query($cities_db, 
    "SELECT Код_показания, Итого_сумма
    FROM сп_показания WHERE Код_адрес_обслуж=1
    ORDER BY Код_показания DESC
    LIMIT 1");
      
   $row1 = mysqli_fetch_assoc($result1);
   $id1 = $row1['Итого_сумма'];
   //echo $id1."\n"; 

   $row2 = mysqli_fetch_assoc($result2);
   $id2 = $row2['Итого_сумма'];
   //echo $id2."\n"; 

   $id3 = $id2 - $id1;
   echo $id3."\n";
   echo "<option value='$id3'> $id2-$id1=$id3</option>";

        /*while ($row1 = mysqli_fetch_assoc($result1)) 
	{while ($row2 = mysqli_fetch_assoc($result2)){
		$id1 = $row1['Итого_сумма'];  
        $id2 = $row2['Итого_сумма']; 
        
		//echo "<option value='$id1-$id2'> $id1 -  $id1</option>";
	}}
    /*while ($row = mysqli_fetch_assoc($result2)) 
	{
		$id = $row['Количество'];        
		echo "<option value='$id'>$id </option>";
	}*/

?>