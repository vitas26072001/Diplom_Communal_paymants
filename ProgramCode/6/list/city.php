<?php 
	$cities_db = mysqli_connect ("localhost","root","","db4");
	mysqli_query($cities_db,"SET NAMES 'utf8'");
	$result = mysqli_query($cities_db, "SELECT `id`, `name`  FROM `tbl_users`");
  
	while ($row = mysqli_fetch_assoc($result)) 
	{
		$client = $row['id'];
        $name = $row['name']; 
		echo "<option value='$client'>$client - $name</option>";
	}
?>