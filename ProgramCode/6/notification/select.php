<?php

$cities_db = mysqli_connect ("localhost","root","","db4");
mysqli_query($cities_db,"SET NAMES 'utf8'");
$worker = mysqli_query($cities_db, 
"SELECT `Наименование_должн`, `ФИО`, `Код_извещения`, `Дата_сост`,
DATE(`Дата_сост`) AS 'Дата_сост1'
FROM `оп_извещение`
INNER JOIN `сп_сотрудники` ON `оп_извещение`.`Код_сотрудн`=`сп_сотрудники`.`Код_сотрудн`
INNER JOIN `сп_должности` ON `сп_сотрудники`.`Код_должность`=`сп_должности`.`Код_должность`
WHERE `оп_извещение`.`Код_извещения`=1");

$row1 = mysqli_fetch_assoc($worker);
$post = $row1['Наименование_должн'];
$worker = $row1['ФИО'];
$nom = $row1['Код_извещения'];
$data = $row1['Дата_сост'];
$data1 = $row1['Дата_сост1'];

$details = mysqli_query($cities_db, 
"SELECT `Название_орган`, `УНП_орган`, `Адр_орган`
FROM `оп_извещение`
INNER JOIN `сп_реквизиты` ON `оп_извещение`.`Код_реквизиты`=`сп_реквизиты`.`Код_реквизиты`
WHERE `оп_извещение`.`Код_извещения`=1");

$row2 = mysqli_fetch_assoc($details);
$details1 = $row2['Название_орган'];
$details2 = $row2['УНП_орган'];
$details3 = $row2['Адр_орган'];

$detailss = mysqli_query($cities_db, 
"SELECT 
SUM(`сп_показания`.`Итого_сумма`) AS sumtabl
FROM `таб_часть_извещение` 
INNER JOIN `сп_показания` ON `Таб_часть_извещение`.`Код_показания`=`сп_показания`.`Код_показания`
INNER JOIN `сп_адреса_обслуживания` ON `сп_показания`.`Код_адрес_обслуж`=`сп_адреса_обслуживания`.`Код_адрес_обслуж`
INNER JOIN `сп_услуги` ON `сп_показания`.`Код_услуги`=`сп_услуги`.`Код_услуги`
INNER JOIN `оп_извещение` ON `Таб_часть_извещение`.`Код_извещения`=`оп_извещение`.`Код_извещения`
INNER JOIN `сп_единицы_хранения` ON `сп_услуги`.`Код_ед_хран`=`сп_единицы_хранения`.`Код_ед_хран`
WHERE (`таб_часть_извещение`.`Код_извещения`=1) AND (`сп_показания`.`Дата` BETWEEN '2023-05-01' AND '2023-05-31')
/*(`сп_показания`.`Дата`>2023-05-01) AND (`сп_показания`.`Дата`<=2023-05-31)*/
ORDER BY `Код_таб_часть_извещение` ASC");

$row10 = mysqli_fetch_assoc($detailss);
$details4 = $row10['sumtabl'];



$address = mysqli_query($cities_db, 
"SELECT `Адрес_обслуж`, `ФИО_потреб`, `Лицевой_счет`
FROM `оп_извещение`
INNER JOIN `сп_адреса_обслуживания` ON `оп_извещение`.`Код_адрес_обслуж`=`сп_адреса_обслуживания`.`Код_адрес_обслуж`
INNER JOIN `сп_потребители` ON `сп_адреса_обслуживания`.`Код_потреб`=`сп_потребители`.`Код_потреб`
WHERE `оп_извещение`.`Код_извещения`=1");

$row3 = mysqli_fetch_assoc($address);
$address1 = $row3['Адрес_обслуж'];
$client1 = $row3['ФИО_потреб'];
$client2 = $row3['Лицевой_счет'];



$dbh = new PDO('mysql:dbname=db4;host=localhost', 'root', '');
$sth = $dbh->prepare("SELECT 
`таб_часть_извещение`.`Код_таб_часть_извещение`,
`таб_часть_извещение`.`Код_извещения`,
`сп_адреса_обслуживания`.`Адрес_обслуж`,
`сп_показания`.`Дата`,
`сп_показания`.`Количество`,
`сп_показания`.`Итого_сумма`,
`сп_услуги`.`Наим_услуги`,
`сп_услуги`.`Тариф`,
`сп_единицы_хранения`.`Наименование_ед_хран`
/*SUM(`сп_показания`.`Итого_сумма`) */
FROM `таб_часть_извещение` 
INNER JOIN `сп_показания` ON `Таб_часть_извещение`.`Код_показания`=`сп_показания`.`Код_показания`
INNER JOIN `сп_адреса_обслуживания` ON `сп_показания`.`Код_адрес_обслуж`=`сп_адреса_обслуживания`.`Код_адрес_обслуж`
INNER JOIN `сп_услуги` ON `сп_показания`.`Код_услуги`=`сп_услуги`.`Код_услуги`
INNER JOIN `оп_извещение` ON `Таб_часть_извещение`.`Код_извещения`=`оп_извещение`.`Код_извещения`
INNER JOIN `сп_единицы_хранения` ON `сп_услуги`.`Код_ед_хран`=`сп_единицы_хранения`.`Код_ед_хран`
WHERE (`таб_часть_извещение`.`Код_извещения`=1) AND (`сп_показания`.`Дата` BETWEEN '2023-05-01' AND '2023-05-31')
/*(`сп_показания`.`Дата`>2023-05-01) AND (`сп_показания`.`Дата`<=2023-05-31)*/
ORDER BY `Код_таб_часть_извещение` ASC");
$sth->execute();
$list = $sth->fetchAll(PDO::FETCH_ASSOC);

$a = "<img src='logo2.png' width='100' height='100'>";


require_once('index.html');
?>

