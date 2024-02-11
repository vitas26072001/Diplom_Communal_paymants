<?php

include 'lib/Database.php';
include_once 'lib/Session.php';


class Users{


  // Db Property
  private $db;

  // Db __construct Method
  public function __construct(){
    $this->db = new Database();
  }

  // Date formate Method
   public function formatDate($date){
     // date_default_timezone_set('Asia/Dhaka');
      $strtime = strtotime($date);
    return date('Y-m-d H:i:s', $strtime);
   }



   // Get Single User Information By Id Method
   public function select(){
    $sql = "SELECT 
    `таб_часть_извещение`.`Код_извещения`,
    `сп_адреса_обслуживания`.`Адрес_обслуж`,
    `сп_показания`.`Дата`,
    `сп_показания`.`Количество`,
    `сп_показания`.`Итого_сумма`,
    `сп_услуги`.`Наим_услуги`,
    `сп_услуги`.`Тариф`,
    `сп_единицы_хранения`.`Наименование_ед_хран`
    FROM `таб_часть_извещение` 
    INNER JOIN `сп_показания` ON `Таб_часть_извещение`.`Код_показания`=`сп_показания`.`Код_показания`
    INNER JOIN `сп_адреса_обслуживания` ON `сп_показания`.`Код_адрес_обслуж`=`сп_адреса_обслуживания`.`Код_адрес_обслуж`
    INNER JOIN `сп_услуги` ON `сп_показания`.`Код_услуги`=`сп_услуги`.`Код_услуги`
    INNER JOIN `оп_извещение` ON `Таб_часть_извещение`.`Код_извещения`=`оп_извещение`.`Код_извещения`
    INNER JOIN `сп_единицы_хранения` ON `сп_услуги`.`Код_ед_хран`=`сп_единицы_хранения`.`Код_ед_хран`
    WHERE (`таб_часть_извещение`.`Код_извещения`=1) AND (`сп_показания`.`Дата`>2023-05-01) /*AND (`сп_показания`.`Дата`<=2023-05-31)*/
    ORDER BY `Код_таб_часть_извещение` ASC";
    $stmt = $this->db->pdo->prepare($sql);
      $stmt->execute();
    $list = $stmt->fetchAll(PDO::FETCH_OBJ);
    
  }
  
  
  
   // Check Exist Email Address Method
  public function checkExistEmail($email){
    $sql = "SELECT email from  tbl_users WHERE email = :email";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
     $stmt->execute();
    if ($stmt->rowCount()> 0) {
      return true;
    }else{
      return false;
    }
  }



  // User Registration Method
  public function userRegistration($data){
    $name = $data['name'];
    $username = $data['username'];
    $email = $data['email'];
    $mobile = $data['mobile'];
    $roleid = $data['roleid'];
    $password = $data['password'];

    $checkEmail = $this->checkExistEmail($email);

    if ($name == "" || $username == "" || $email == "" || $mobile == "" || $password == "") {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Please, User Registration field must not be Empty !</div>';
        return $msg;
    }elseif (strlen($username) < 3) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
        return $msg;
    }elseif (filter_var($mobile,FILTER_SANITIZE_NUMBER_INT) == FALSE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Enter only Number Characters for Mobile number field !</div>';
        return $msg;

    }elseif(strlen($password) < 5) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Password at least 6 Characters !</div>';
        return $msg;
    }elseif(!preg_match("#[0-9]+#",$password)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Your Password Must Contain At Least 1 Number !</div>';
        return $msg;
    }elseif(!preg_match("#[a-z]+#",$password)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Your Password Must Contain At Least 1 Number !</div>';
        return $msg;
    }/*elseif (filter_var($email, FILTER_VALIDATE_EMAIL === FALSE)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Invalid email address !</div>';
        return $msg;
    }*/elseif ($checkEmail == TRUE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Email already Exists, please try another Email... !</div>';
        return $msg;
    }else{

      $sql = "INSERT INTO tbl_users(name, username, email, password, mobile, roleid) VALUES(:name, :username, :email, :password, :mobile, :roleid)";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':name', $name);
      $stmt->bindValue(':username', $username);
      $stmt->bindValue(':email', $email);
      $stmt->bindValue(':password', SHA1($password));
      $stmt->bindValue(':mobile', $mobile);
      $stmt->bindValue(':roleid', $roleid);
      $result = $stmt->execute();
      if ($result) {
        $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success !</strong> Wow, you have Registered Successfully !</div>';
          return $msg;
      }else{
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Something went Wrong !</div>';
          return $msg;
      }

    }

  }

  // Add New Client By Admin
  public function addNewClientByAdmin($data){
    $ФИО_потреб = $data['client'];
    $Лицевой_счет = $data['nom'];
    
    if ($ФИО_потреб == "" || $Лицевой_счет == "" ) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Input fields must not be Empty !</div>';
        return $msg;
    }elseif (strlen($ФИО_потреб) < 3) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
        return $msg;
    }elseif(strlen($Лицевой_счет) < 4) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Password at least 6 Characters !</div>';
        return $msg;
    }else{

      $sql = "INSERT INTO сп_потребители (ФИО_потреб, Лицевой_счет) 
              VALUES(:client, :nom)";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':client', $ФИО_потреб);
      $stmt->bindValue(':nom', $Лицевой_счет);
      $result = $stmt->execute();
      if ($result) {
        $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success !</strong> Ура, вы зарегистрировали нового потребителя ! </div>';
          return $msg;
      }else{
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Something went Wrong !</div>';
          return $msg;
      }
    }
  }


  // Add New Address By Admin
  public function addNewAddressByAdmin($data){
    $Адрес_обслуж = $data['address'];
    $Код_потреб = $data['client'];
    
    if ($Адрес_обслуж == "" || $Код_потреб == "" ) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Input fields must not be Empty !</div>';
        return $msg;
    }elseif (strlen($Адрес_обслуж) < 3) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
        return $msg;
    }elseif(strlen($Код_потреб) < 1) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Password at least 6 Characters !</div>';
        return $msg;
    }else{

      $sql = "INSERT INTO сп_адреса_обслуживания (Адрес_обслуж, Код_потреб) 
              VALUES(:address, :client)";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':address', $Адрес_обслуж);
      $stmt->bindValue(':client', $Код_потреб);
      $result = $stmt->execute();
      if ($result) {
        $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success !</strong> Ура, вы зарегистрировали новый адрес обслуживания ! </div>';
          return $msg;
      }else{
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Something went Wrong !</div>';
          return $msg;
      }
    }
  }

 // Add New Service By Admin
 public function addNewServiceByAdmin($data){
  $Наим_услуги = $data['service'];
  $Код_ед_хран = $data['ed'];
  $Тариф = $data['tariff'];
  
  if ($Наим_услуги == "" || $Код_ед_хран == "" || $Тариф == "" ) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Input fields must not be Empty !</div>';
      return $msg;
  }elseif (strlen($Наим_услуги) < 3) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
      return $msg;
  }elseif (strlen($Код_ед_хран) < 0) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
      return $msg;
  }elseif(strlen($Тариф) < 1) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Password at least 6 Characters !</div>';
      return $msg;
  }else{

    $sql = "INSERT INTO сп_услуги (Наим_услуги, Код_ед_хран, Тариф) 
            VALUES(:service, :ed, :tariff)";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':service', $Наим_услуги);
    $stmt->bindValue(':ed', $Код_ед_хран);
    $stmt->bindValue(':tariff', $Тариф);
    $result = $stmt->execute();
    if ($result) {
      $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> Ура, вы зарегистрировали новую услугу ! </div>';
        return $msg;
    }else{
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Something went Wrong !</div>';
        return $msg;
    }
  }
}

// Add New Indication By Admin
public function addNewIndicationByAdmin($data){
  $Код_адрес_обслуж = $data['address'];
  $Код_услуги = $data['service'];
  $Количество = $data['nom'];
  $Итого_сумма = $data['summ']; 
  
  if ($Код_адрес_обслуж == "" || $Код_услуги == "" || $Количество == "" || $Итого_сумма == "" ) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Input fields must not be Empty !</div>';
      return $msg;
  }elseif (strlen($Код_адрес_обслуж) < 0) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
      return $msg;
  }elseif (strlen($Код_услуги) < 0) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
      return $msg;
  }elseif(strlen($Количество) < 1) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Password at least 6 Characters !</div>';
      return $msg;
  }elseif(strlen($Итого_сумма) < 1) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Password at least 6 Characters !</div>';
      return $msg;
  }else{

      
    $sql = "INSERT INTO сп_показания (Код_адрес_обслуж, Код_услуги, Количество, Итого_сумма) 
            VALUES(:address, :service, :nom, :summ)";
       
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':address', $Код_адрес_обслуж);
    $stmt->bindValue(':service', $Код_услуги);
    $stmt->bindValue(':nom', $Количество);
    $stmt->bindValue(':summ', $Итого_сумма);
    $result = $stmt->execute();
   if ($result) {
      $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> Ура, вы зарегистрировали новое показание ! </div>';
        return $msg;
    }else{
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Something went Wrong !</div>';
        return $msg;           
    }
  }
}

// Add New Details By Admin
public function addNewDetailsByAdmin($data){
  $Название_орган = $data['firm'];
  $УНП_орган = $data['unp'];
  $Адр_орган = $data['address'];
  
  if ($Название_орган == "" || $УНП_орган == "" || $Адр_орган == "" ) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Input fields must not be Empty !</div>';
      return $msg;
  }elseif (strlen($Название_орган) < 3) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
      return $msg;
  }elseif (strlen($УНП_орган) < 9) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Ошибка! УНП меньше 9 знаков !</div>';
      return $msg;
  }elseif (strlen($УНП_орган) > 9) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Ошибка! УНП больше 9 знаков !</div>';
      return $msg;
  } elseif(strlen($Адр_орган) < 5) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Password at least 6 Characters !</div>';
      return $msg;
  }else{

    $sql = "INSERT INTO сп_реквизиты (Название_орган, УНП_орган, Адр_орган) 
            VALUES(:firm, :unp, :address)";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':firm', $Название_орган);
    $stmt->bindValue(':unp', $УНП_орган);
    $stmt->bindValue(':address', $Адр_орган);
    $result = $stmt->execute();
    if ($result) {
      $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> Ура, вы зарегистрировали новые реквезиты ! </div>';
        return $msg;
    }else{
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Something went Wrong !</div>';
        return $msg;
    }
  }
}


// Add New Worker By Admin
public function addNewWorkerByAdmin($data){
  $ФИО = $data['worker'];
  $Код_должность = $data['post'];
    
  if ($ФИО == "" || $Код_должность == "" ) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Input fields must not be Empty !</div>';
      return $msg;
  }elseif (strlen($ФИО) < 3) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
      return $msg;
  }elseif (strlen($Код_должность) < 0) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
      return $msg;
  }else{

    $sql = "INSERT INTO сп_сотрудники (ФИО, Код_должность) 
            VALUES(:worker, :post)";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':worker', $ФИО);
    $stmt->bindValue(':post', $Код_должность);
    $result = $stmt->execute();
    if ($result) {
      $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> Ура, вы зарегистрировали нового сотрудника ! </div>';
        return $msg;
    }else{
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Something went Wrong !</div>';
        return $msg;
    }
  }
}


public function addNewContractByAdmin($data){
  $Код_адрес_обслуж = $data['address'];
  $Код_реквизиты = $data['details'];
  $Код_сотрудн = $data['worker'];
    
  if ($Код_адрес_обслуж == "" || $Код_реквизиты == "" || $Код_сотрудн == "" ) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Input fields must not be Empty !</div>';
      return $msg;
  }elseif (strlen($Код_адрес_обслуж) < 0) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
      return $msg;
  }elseif (strlen($Код_реквизиты) < 0) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
      return $msg;
  }elseif (strlen($Код_сотрудн) < 0) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
      return $msg;
  }else{

    $sql = "INSERT INTO оп_договор_на_пост (Код_адрес_обслуж, Код_реквизиты, Код_сотрудн) 
            VALUES(:address, :details, :worker)";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':address', $Код_адрес_обслуж);
    $stmt->bindValue(':details', $Код_реквизиты);
    $stmt->bindValue(':worker', $Код_сотрудн);
    $result = $stmt->execute();
    if ($result) {
      $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> Ура, вы зарегистрировали нового договор на поставку услуг ! </div>';
        return $msg;
    }else{
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Something went Wrong !</div>';
        return $msg;
    }
  }
}

public function addNewNotificationByAdmin($data){
  $Код_адрес_обслуж = $data['address'];
  $Код_реквизиты = $data['details'];
  $Код_сотрудн = $data['worker'];
    
  if ($Код_адрес_обслуж == "" || $Код_реквизиты == "" || $Код_сотрудн == "" ) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Input fields must not be Empty !</div>';
      return $msg;
  }elseif (strlen($Код_адрес_обслуж) < 0) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
      return $msg;
  }elseif (strlen($Код_реквизиты) < 0) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
      return $msg;
  }elseif (strlen($Код_сотрудн) < 0) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
      return $msg;
  }else{

    $sql = "INSERT INTO оп_извещение (Код_адрес_обслуж, Код_реквизиты, Код_сотрудн) 
            VALUES(:address, :details, :worker)";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':address', $Код_адрес_обслуж);
    $stmt->bindValue(':details', $Код_реквизиты);
    $stmt->bindValue(':worker', $Код_сотрудн);
    $result = $stmt->execute();
    if ($result) {
      $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> Ура, вы сформировали новое извещение ! </div>';
        return $msg;
    }else{
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Something went Wrong !</div>';
        return $msg;
    }
  }
}

  // Add New Unit By Admin
  public function addNewUnitByAdmin($data){
    $Наименование_ед_хран = $data['ed'];
   
    
    if ($Наименование_ед_хран == "") {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Input fields must not be Empty !</div>';
        return $msg;
    }elseif (strlen($Наименование_ед_хран) < 3) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
        return $msg;
    }else{

      $sql = "INSERT INTO сп_единицы_хранения (Наименование_ед_хран) 
              VALUES(:ed)";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':ed', $Наименование_ед_хран);
      $result = $stmt->execute();
      if ($result) {
        $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success !</strong> Ура, вы зарегистрировали новую единицу хранения ! </div>';
          return $msg;
      }else{
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Something went Wrong !</div>';
          return $msg;
      }
    }
  }

  // Add New Post By Admin
  public function addNewPostByAdmin($data){
    $Наименование_должн = $data['post'];
   
    
    if ($Наименование_должн == "") {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Input fields must not be Empty !</div>';
        return $msg;
    }elseif (strlen($Наименование_должн) < 3) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
        return $msg;
    }else{

      $sql = "INSERT INTO сп_должности (Наименование_должн) 
              VALUES(:post)";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':post', $Наименование_должн);
      $result = $stmt->execute();
      if ($result) {
        $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success !</strong> Ура, вы зарегистрировали новую должность ! </div>';
          return $msg;
      }else{
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Something went Wrong !</div>';
          return $msg;
      }
    }
  }

  // Add New User By Admin
  public function addNewUserByAdmin($data){
    $name = $data['name'];
    $username = $data['username'];
    $email = $data['email'];
    $mobile = $data['mobile'];
    $roleid = $data['roleid'];
    $password = $data['password'];

    $checkEmail = $this->checkExistEmail($email);

    if ($name == "" || $username == "" || $email == "" || $mobile == "" || $password == "") {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Input fields must not be Empty !</div>';
        return $msg;
    }elseif (strlen($username) < 3) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
        return $msg;
    }elseif (filter_var($mobile,FILTER_SANITIZE_NUMBER_INT) == FALSE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Enter only Number Characters for Mobile number field !</div>';
        return $msg;

    }elseif(strlen($password) < 5) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Password at least 6 Characters !</div>';
        return $msg;
    }elseif(!preg_match("#[0-9]+#",$password)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Your Password Must Contain At Least 1 Number !</div>';
        return $msg;
    }elseif(!preg_match("#[a-z]+#",$password)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Your Password Must Contain At Least 1 Number !</div>';
        return $msg;
    }/*elseif (filter_var($email, FILTER_VALIDATE_EMAIL === FALSE)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Invalid email address !</div>';
        return $msg;
    }*/elseif ($checkEmail == TRUE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Email already Exists, please try another Email... !</div>';
        return $msg;
    }else{

      $sql = "INSERT INTO tbl_users(name, username, email, password, mobile, roleid) 
              VALUES(:name, :username, :email, :password, :mobile, :roleid)";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':name', $name);
      $stmt->bindValue(':username', $username);
      $stmt->bindValue(':email', $email);
      $stmt->bindValue(':password', SHA1($password));
      $stmt->bindValue(':mobile', $mobile);
      $stmt->bindValue(':roleid', $roleid);
      $result = $stmt->execute();
      if ($result) {
        $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success !</strong> Wow, you have Registered Successfully !</div>';
          return $msg;
      }else{
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Something went Wrong !</div>';
          return $msg;
      }
    }
  }



  

public function checkNameClientInIndication($client){
    $sql = "SELECT id FROM tbl_users WHERE name IN (:client)";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':client', $client);
     $stmt->execute();
     
    if ($stmt->rowCount()> 0) {
      return true;
    }else{
      return false;
    }
  } 

 /* public function checkExistEmail($email){
    $sql = "SELECT email from  tbl_users WHERE email = :email";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
     $stmt->execute();
    if ($stmt->rowCount()> 0) {
      return true;
    }else{
      return false;
    }
  }*/

/**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ 
  /*public function City(){
    
    $cities_db = mysqli_connect ("localhost","root","","db3");
    mysqli_query($cities_db,"SET NAMES 'utf8'");
    $result = mysqli_query($cities_db,
     
      "SELECT `id`, `name`  FROM `tbl_users`");
    
    while ($row = mysqli_fetch_assoc($result)) 
    {
      $client = $row['id'];
          $name = $row['name']; 
      echo "<option value='$client'>$client - $name</option>";
    }         
  }
/**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ /**/ 

  // Add Indication By Admin ***
public function addNewIndication2ByAdmin($data){
  $client = $data['client'];
  $username = $data['username'];
  $address = $data['address'];
  $mobile = $data['mobile'];
  $roleid = $data['roleid'];
  
  $checkEmail = $this->checkNameClientInIndication2($client);



  
  if ($client == "" || $username == "" || $address == "" || $mobile == "") {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Input fields must not be Empty !</div>';
      return $msg;
  }elseif (strlen($username) < 1) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Username is too short, at least 1 Characters !</div>';
      return $msg;
  }elseif (filter_var($mobile,FILTER_SANITIZE_NUMBER_INT) == FALSE) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Enter only Number Characters for Mobile number field !</div>';
      return $msg;
  }  
  else{

    $sql = "INSERT INTO tbl_indication(client, username, address, mobile, roleid) VALUES(:client, :username, :address, :mobile, :roleid)";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':client', $client);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':address', $address);
    $stmt->bindValue(':mobile', $mobile);
    $stmt->bindValue(':roleid', $roleid);
    $result = $stmt->execute();
    if ($result) {
      $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Success !</strong> Wow, you have Registered Successfully !</div>';
        return $msg;
    }else{
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<strong>Error !</strong> Something went Wrong !</div>';
        return $msg;
    }
  }
}







  // Select All User Method
  public function selectAllUserData(){
    
    $sql = "SELECT * FROM tbl_users ORDER BY id DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  
  
  public function selectAllClient(){
    
    $sql = "SELECT 
    `сп_потребители`.`Код_потреб`,
    `сп_потребители`.`ФИО_потреб`,
    `tbl_users`.`id`,
    `сп_потребители`.`Лицевой_счет`,
    `сп_адреса_обслуживания`.`Адрес_обслуж`
    FROM `сп_потребители` 
    INNER JOIN `сп_адреса_обслуживания` ON `сп_адреса_обслуживания`.`Код_потреб`=`сп_потребители`.`Код_потреб`
    INNER JOIN `tbl_users` ON `сп_потребители`.`id`=`tbl_users`.`id`
    ORDER BY `Код_потреб` ASC;";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function selectAllService(){
    
    $sql = "SELECT 
    `сп_услуги`.`Код_услуги`,
    `сп_услуги`.`Наим_услуги`,
    `сп_единицы_хранения`.`Наименование_ед_хран`,
    `сп_услуги`.`Тариф`
    FROM `сп_услуги` 
    INNER JOIN `сп_единицы_хранения` ON `сп_услуги`.`Код_ед_хран`=`сп_единицы_хранения`.`Код_ед_хран`
    ORDER BY `Код_услуги` ASC;";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function selectAllWorker(){
    
    $sql = "SELECT 
    `сп_сотрудники`.`Код_сотрудн`,
    `сп_сотрудники`.`ФИО`,
    `сп_должности`.`Наименование_должн`
    FROM `сп_сотрудники` 
    INNER JOIN `сп_должности` ON `сп_сотрудники`.`Код_должность`=`сп_должности`.`Код_должность`
    ORDER BY `Код_сотрудн` ASC;";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function selectAllDetails(){
    
    $sql = "SELECT * FROM `сп_реквизиты` 
    ORDER BY `Код_реквизиты` ASC;";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function selectAllAddress(){
    
    $sql = "SELECT 
    `сп_адреса_обслуживания`.`Код_адрес_обслуж`,
    `сп_адреса_обслуживания`.`Адрес_обслуж`,
    `сп_потребители`.`ФИО_потреб`,
    `сп_потребители`.`Лицевой_счет`,
    `tbl_users`.`id`
    FROM `сп_адреса_обслуживания` 
    INNER JOIN `сп_потребители` ON `сп_адреса_обслуживания`.`Код_потреб`=`сп_потребители`.`Код_потреб`
    INNER JOIN `tbl_users` ON `сп_потребители`.`id`=`tbl_users`.`id`
    ORDER BY `Код_адрес_обслуж` ASC;";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function selectAllUnit(){
    
    $sql = "SELECT * FROM `сп_единицы_хранения` 
    ORDER BY `Код_ед_хран` ASC;";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function selectAllPost(){
    
    $sql = "SELECT * FROM `сп_должности` 
    ORDER BY `Код_должность` ASC;";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  public function selectAllContract(){
    
    $sql = "SELECT 
    `оп_договор_на_пост`.`Номер_договора`,
    `оп_договор_на_пост`.`Дата_сост`,
    `сп_адреса_обслуживания`.`Адрес_обслуж`,
    `сп_реквизиты`.`Название_орган`,
    `сп_сотрудники`.`ФИО`, 
    `сп_потребители`.`ФИО_потреб`,
    `сп_потребители`.`Лицевой_счет`,
    `tbl_users`.`id`
    FROM `оп_договор_на_пост` 
    INNER JOIN `сп_адреса_обслуживания` ON `оп_договор_на_пост`.`Код_адрес_обслуж`=`сп_адреса_обслуживания`.`Код_адрес_обслуж`
    INNER JOIN `сп_реквизиты` ON `оп_договор_на_пост`.`Код_реквизиты`=`сп_реквизиты`.`Код_реквизиты`
    INNER JOIN `сп_сотрудники` ON `оп_договор_на_пост`.`Код_сотрудн`=`сп_сотрудники`.`Код_сотрудн`
    INNER JOIN `сп_потребители` ON `сп_адреса_обслуживания`.`Код_потреб`=`сп_потребители`.`Код_потреб`
    INNER JOIN `tbl_users` ON `сп_потребители`.`id`=`tbl_users`.`id`
    ORDER BY `Номер_договора` ASC;";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  /*public function selectAllNotification(){
    
    $sql = "SELECT 
    `таб_часть_извещение`.`Код_извещения`,
    `сп_адреса_обслуживания`.`Адрес_обслуж`,
    `сп_потребители`.`ФИО_потреб`,
    `сп_потребители`.`Лицевой_счет`,
    `оп_извещение`.`Дата_сост`,
    `сп_сотрудники`.`ФИО`,
    `сп_реквизиты`.`Название_орган`    
    FROM `таб_часть_извещение` 
    INNER JOIN `сп_показания` ON `Таб_часть_извещение`.`Код_показания`=`сп_показания`.`Код_показания`
    INNER JOIN `сп_адреса_обслуживания` ON `сп_показания`.`Код_адрес_обслуж`=`сп_адреса_обслуживания`.`Код_адрес_обслуж`
    INNER JOIN `сп_потребители` ON `сп_адреса_обслуживания`.`Код_потреб`=`сп_потребители`.`Код_потреб`
    INNER JOIN `оп_извещение` ON `Таб_часть_извещение`.`Код_извещения`=`оп_извещение`.`Код_извещения`
    INNER JOIN `сп_сотрудники` ON `оп_извещение`.`Код_сотрудн`=`сп_сотрудники`.`Код_сотрудн`
    INNER JOIN `сп_реквизиты` ON `оп_извещение`.`Код_реквизиты`=`сп_реквизиты`.`Код_реквизиты`

    ORDER BY `Код_таб_часть_извещение` ASC;";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }*/

  public function selectAllNotification(){
    
    $sql = "SELECT 
    `оп_извещение`.`Код_извещения`,
    `оп_извещение`.`Дата_сост`,
    `сп_адреса_обслуживания`.`Адрес_обслуж`,
    `сп_потребители`.`ФИО_потреб`,
    `сп_потребители`.`Лицевой_счет`,
    `сп_сотрудники`.`ФИО`,
    `сп_реквизиты`.`Название_орган`
    FROM `оп_извещение` 
   INNER JOIN `сп_адреса_обслуживания` ON `оп_извещение`.`Код_адрес_обслуж`=`сп_адреса_обслуживания`.`Код_адрес_обслуж`
   INNER JOIN `сп_потребители` ON `сп_адреса_обслуживания`.`Код_потреб`=`сп_потребители`.`Код_потреб`
   INNER JOIN `сп_сотрудники` ON `оп_извещение`.`Код_сотрудн`=`сп_сотрудники`.`Код_сотрудн`
   INNER JOIN `сп_реквизиты` ON `оп_извещение`.`Код_реквизиты`=`сп_реквизиты`.`Код_реквизиты`

    ORDER BY `Код_извещения` ASC;";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

//Выборка из таблицы индикэйшен показаний
  public function selectAllIndication(){
    
    $sql = "SELECT 
    `сп_показания`.`Код_показания`,
    `tbl_users`.`id`,
    `сп_потребители`.`ФИО_потреб`,
    `сп_потребители`.`Лицевой_счет`,
    `сп_адреса_обслуживания`.`адрес_обслуж`,
    `сп_показания`.`Дата`, 
    `сп_услуги`.`Наим_услуги`,
    `сп_единицы_хранения`.`Наименование_ед_хран`,
    `сп_услуги`.`Тариф`,
    `сп_показания`.`Количество`,
    `сп_показания`.`Итого_сумма`
    FROM `сп_показания` 
    INNER JOIN `сп_услуги` ON `сп_показания`.`Код_услуги`=`сп_услуги`.`Код_услуги`
    INNER JOIN `сп_адреса_обслуживания` ON `сп_показания`.`Код_адрес_обслуж`=`сп_адреса_обслуживания`.`Код_адрес_обслуж`
    INNER JOIN `сп_потребители` ON `сп_адреса_обслуживания`.`Код_потреб`=`сп_потребители`.`Код_потреб`
    INNER JOIN `tbl_users` ON `сп_потребители`.`id`=`tbl_users`.`id`
    INNER JOIN `сп_единицы_хранения` ON `сп_услуги`.`Код_ед_хран`=`сп_единицы_хранения`.`Код_ед_хран`
    ORDER BY Код_показания ASC;";



     /*$sql = " SELECT `tbl_indication`.`id`, `tbl_users`.`name`,`tbl_indication`.`username`, `tbl_indication`.`address`,
`tbl_indication`.`mobile`, `tbl_indication`.`roleid`, `tbl_indication`.`created_at`,`tbl_indication`.`updated_at`
FROM `tbl_indication` INNER JOIN `tbl_users` ON `tbl_indication`.`client`=`tbl_users`.`id` ORDER BY id DESC";*/

    /*$sql = "SELECT * FROM tbl_indication ORDER BY id DESC";*/
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  
  // User login Autho Method
  public function userLoginAutho($email, $password){
    $password = SHA1($password);
    $sql = "SELECT * FROM tbl_users WHERE email = :email and password = :password LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }
  // Check User Account Satatus
  public function CheckActiveUser($email){
    $sql = "SELECT * FROM tbl_users WHERE email = :email and isActive = :isActive LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':isActive', 1);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }




    // User Login Authotication Method
    public function userLoginAuthotication($data){
      $email = $data['email'];
      $password = $data['password'];


      $checkEmail = $this->checkExistEmail($email);

      if ($email == "" || $password == "" ) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Email or Password not be Empty !</div>';
          return $msg;

      }elseif (filter_var($email, FILTER_VALIDATE_EMAIL === FALSE)) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Invalid email address !</div>';
          return $msg;
      }elseif ($checkEmail == FALSE) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Email did not Found, use Register email or password please !</div>';
          return $msg;
      }else{


        $logResult = $this->userLoginAutho($email, $password);
        $chkActive = $this->CheckActiveUser($email);

        if ($chkActive == TRUE) {
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Sorry, Your account is Diactivated, Contact with Admin !</div>';
            return $msg;
        }elseif ($logResult) {

          Session::init();
          Session::set('login', TRUE);
          Session::set('id', $logResult->id);
          Session::set('roleid', $logResult->roleid);
          Session::set('name', $logResult->name);
          Session::set('email', $logResult->email);
          Session::set('username', $logResult->username);
          Session::set('logMsg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !</strong> You are Logged In Successfully !</div>');

          echo "<script>location.href='index.php';</script>";

        }
        else
        {
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Email or Password did not Matched !</div>';
            return $msg;
        }

      }


    }

    public function City($userid){
      $sql = "SELECT `Код_адрес_обслуж`, `Адрес_обслуж`, `ФИО_потреб`,  `tbl_users`.`id`  
      FROM `сп_адреса_обслуживания`
      INNER JOIN `сп_потребители` ON `сп_адреса_обслуживания`.`Код_потреб`=`сп_потребители`.`Код_потреб`
       INNER JOIN `tbl_users` ON `сп_потребители`.`id`=`tbl_users`.`id`
       WHERE `tbl_users`.`id`= :id
      ORDER BY `Адрес_обслуж` ASC";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $userid);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_OBJ);
      if ($result) {
        return $result;
      }else{
        return false;
      }
    }

    // Get Single User Information By Id Method
    public function getUserInfoById($userid){
      $sql = "SELECT * FROM tbl_users WHERE id = :id LIMIT 1";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $userid);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_OBJ);
      if ($result) {
        return $result;
      }else{
        return false;
      }
    }
    
////////////////////////////////////////*/*/*//**/ */
    public function getIndicationInfoById($userid){
     
      $sql = "SELECT 
      `сп_показания`.`Код_показания`,
      `tbl_users`.`id`,
      `сп_потребители`.`ФИО_потреб`,
      `сп_потребители`.`Лицевой_счет`,
      `сп_адреса_обслуживания`.`адрес_обслуж`,
      `сп_показания`.`Дата`, 
      `сп_услуги`.`Наим_услуги`,
      `сп_единицы_хранения`.`Наименование_ед_хран`,
      `сп_услуги`.`Тариф`,
      `сп_показания`.`Количество`,
      `сп_показания`.`Итого_сумма`
      FROM `сп_показания`
      INNER JOIN `сп_услуги` ON `сп_показания`.`Код_услуги`=`сп_услуги`.`Код_услуги`
      INNER JOIN `сп_адреса_обслуживания` ON `сп_показания`.`Код_адрес_обслуж`=`сп_адреса_обслуживания`.`Код_адрес_обслуж`
      INNER JOIN `сп_потребители` ON `сп_адреса_обслуживания`.`Код_потреб`=`сп_потребители`.`Код_потреб`
      INNER JOIN `tbl_users` ON `сп_потребители`.`id`=`tbl_users`.`id`
      INNER JOIN `сп_единицы_хранения` ON `сп_услуги`.`Код_ед_хран`=`сп_единицы_хранения`.`Код_ед_хран`
      /*WHERE `сп_показания`.`Код_показания` = 1 LIMIT 1*/
        WHERE `tbl_users`.`id` = :id LIMIT 1";

      /* $sql = "SELECT 
      `сп_показания`.`Код_показания`,
      `сп_потребители`.`ФИО_потреб`,
      `сп_потребители`.`Лицевой_счет`,
      `сп_адреса_обслуживания`.`адрес_обслуж`,
      `сп_показания`.`Дата`, 
      `сп_услуги`.`Наим_услуги`,
      `сп_единицы_хранения`.`Наименование_ед_хран`,
      `сп_услуги`.`Тариф`,
      `сп_показания`.`Количество`,
      `сп_показания`.`Итого_сумма`
      FROM `сп_показания`
      INNER JOIN `сп_услуги` ON `сп_показания`.`Код_услуги`=`сп_услуги`.`Код_услуги`
      INNER JOIN `сп_адреса_обслуживания` ON `сп_показания`.`Код_адрес_обслуж`=`сп_адреса_обслуживания`.`Код_адрес_обслуж`
      INNER JOIN `сп_потребители` ON `сп_адреса_обслуживания`.`Код_потреб`=`сп_потребители`.`Код_потреб`
      INNER JOIN `сп_единицы_хранения` ON `сп_услуги`.`Код_ед_хран`=`сп_единицы_хранения`.`Код_ед_хран`
      WHERE `сп_показания`.`Код_показания` = :id LIMIT 1";*/
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $userid);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_OBJ);
      if ($result) {
        return $result;
      }else{
        return false;
      }
    }

//Выборка из таблицы индикэйшен показаний
public function selectUserIndication($userid){
  //echo $userid;
  $sql = "SELECT 
  `сп_показания`.`Код_показания`,
  `tbl_users`.`id`,
  `сп_потребители`.`ФИО_потреб`,
  `сп_потребители`.`Лицевой_счет`,
  `сп_адреса_обслуживания`.`адрес_обслуж`,
  `сп_показания`.`Дата`, 
  `сп_услуги`.`Наим_услуги`,
  `сп_единицы_хранения`.`Наименование_ед_хран`,
  `сп_услуги`.`Тариф`,
  `сп_показания`.`Количество`,
  `сп_показания`.`Итого_сумма`
  FROM `сп_показания` 
  INNER JOIN `сп_услуги` ON `сп_показания`.`Код_услуги`=`сп_услуги`.`Код_услуги`
  INNER JOIN `сп_адреса_обслуживания` ON `сп_показания`.`Код_адрес_обслуж`=`сп_адреса_обслуживания`.`Код_адрес_обслуж`
  INNER JOIN `сп_потребители` ON `сп_адреса_обслуживания`.`Код_потреб`=`сп_потребители`.`Код_потреб`
  INNER JOIN `tbl_users` ON `сп_потребители`.`id`=`tbl_users`.`id`
  INNER JOIN `сп_единицы_хранения` ON `сп_услуги`.`Код_ед_хран`=`сп_единицы_хранения`.`Код_ед_хран`
  WHERE `tbl_users`.`id` = 34";
  /*WHERE `tbl_users`.`id`=34
  ORDER BY Код_показания ASC;";*/

  $stmt = $this->db->pdo->prepare($sql);
  //$stmt->bindValue(':id', $userid);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_OBJ);
  if ($result) {
    return $result;
  }else{
    return false;
    echo $userid;
  }
 

  

}


public function selectSERNotification(){
  
  $sql = "SELECT
  `таб_часть_извещение`.`Код_таб_часть_извещение`, 
  `таб_часть_извещение`.`Код_показания`, 
  `оп_извещение`.`Код_извещения`, 
  `сп_адреса_обслуживания`.`Код_адрес_обслуж`,
  `сп_показания`.`Дата`,
  `сп_услуги`.`Наим_услуги`, 
  `сп_единицы_хранения`.`Наименование_ед_хран`,
  `сп_услуги`.`Тариф`, 
  `сп_показания`.`Количество`,
  `сп_показания`.`Итого_сумма`,
  `tbl_users`.`id` 

    FROM `таб_часть_извещение` 
    
    INNER JOIN `сп_показания` ON `таб_часть_извещение`.`Код_показания`=`сп_показания`.`Код_показания`
    INNER JOIN `сп_адреса_обслуживания` ON `сп_показания`.`Код_адрес_обслуж`=`сп_адреса_обслуживания`.`Код_адрес_обслуж`
    INNER JOIN `сп_услуги` ON `сп_показания`.`Код_услуги`=`сп_услуги`.`Код_услуги`
    INNER JOIN `сп_единицы_хранения` ON `сп_услуги`.`Код_ед_хран`=`сп_единицы_хранения`.`Код_ед_хран`
    INNER JOIN `оп_извещение` ON `таб_часть_извещение`.`Код_извещения`=`оп_извещение`.`Код_извещения`
    INNER JOIN `сп_потребители` ON `сп_адреса_обслуживания`.`Код_потреб`=`сп_потребители`.`Код_потреб`
    INNER JOIN `tbl_users` ON `сп_потребители`.`id`=`tbl_users`.`id`
    WHERE `оп_извещение`.`Код_адрес_обслуж`= `сп_адреса_обслуживания`.`Код_адрес_обслуж`
    AND (`оп_извещение`.`Код_извещения`=1) AND (`сп_показания`.`Дата` BETWEEN '2023-05-01' AND '2023-05-31')";
  $stmt = $this->db->pdo->prepare($sql);
  //$stmt->bindValue(':id', $Номер_договора);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_OBJ);
  
}



public function selectSERContract(){
  
  $sql = "SELECT
  `таб_часть_договор_на_пост`.`Код_таб_часть_дог_на_пост`, 
  `сп_услуги`.`Наим_услуги`, 
  `таб_часть_договор_на_пост`.`Номер_договора` , 
  `tbl_users`.`id`
    FROM `таб_часть_договор_на_пост` 
    INNER JOIN `сп_услуги` ON `таб_часть_договор_на_пост`.`Код_услуги`=`сп_услуги`.`Код_услуги`
     INNER JOIN `оп_договор_на_пост` ON `таб_часть_договор_на_пост`.`Номер_договора`=`оп_договор_на_пост`.`Номер_договора`
     INNER JOIN `сп_адреса_обслуживания` ON `оп_договор_на_пост`.`Код_адрес_обслуж`=`сп_адреса_обслуживания`.`Код_адрес_обслуж`
     INNER JOIN `сп_потребители` ON `сп_адреса_обслуживания`.`Код_потреб`=`сп_потребители`.`Код_потреб`
     INNER JOIN `tbl_users` ON `сп_потребители`.`id`=`tbl_users`.`id`
    WHERE `оп_договор_на_пост`.`Номер_договора` = 1";
  $stmt = $this->db->pdo->prepare($sql);
  //$stmt->bindValue(':id', $Номер_договора);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_OBJ);
  /*if ($stmt->rowCount() > 0) {
    return true;
  }else{
    return false;
  }*/
}


  //
  //   Get Single User Information By Id Method
    public function updateUserByIdInfo($userid, $data){
      $name = $data['name'];
      $username = $data['username'];
      $email = $data['email'];
      $mobile = $data['mobile'];
      $roleid = $data['roleid'];



      if ($name == "" || $username == ""|| $email == "" || $mobile == ""  ) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Input Fields must not be Empty !</div>';
          return $msg;
        }elseif (strlen($username) < 3) {
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
            return $msg;
        }elseif (filter_var($mobile,FILTER_SANITIZE_NUMBER_INT) == FALSE) {
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Enter only Number Characters for Mobile number field !</div>';
            return $msg;


      }elseif (filter_var($email, FILTER_VALIDATE_EMAIL === FALSE)) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Invalid email address !</div>';
          return $msg;
      }else{

        $sql = "UPDATE tbl_users SET
          name = :name,
          username = :username,
          email = :email,
          mobile = :mobile,
          roleid = :roleid
          WHERE id = :id";
          $stmt= $this->db->pdo->prepare($sql);
          $stmt->bindValue(':name', $name);
          $stmt->bindValue(':username', $username);
          $stmt->bindValue(':email', $email);
          $stmt->bindValue(':mobile', $mobile);
          $stmt->bindValue(':roleid', $roleid);
          $stmt->bindValue(':id', $userid);
        $result =   $stmt->execute();

        if ($result) {
          echo "<script>location.href='indexOne.php';</script>";
          Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong> Wow, Your Information updated Successfully !</div>');



        }else{
          echo "<script>location.href='indexOne.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not inserted !</div>');

        }
      }
    }

public function updateIndicationByIdInfo($userid, $data){
      $Код_показания = $data['1'];
      $ФИО_потреб = $data['2'];
      $Лицевой_счет = $data['3'];
      $адрес_обслуж = $data['4'];
      $Дата = $data['5'];
      $Наим_услуги = $data['6'];
      $Наименование_ед_хран = $data['7'];
      $Тариф = $data['8'];
      $Количество = $data['9'];
      $Итого_сумма = $data['10'];

      if ($Код_показания == "" || $ФИО_потреб == ""|| $Лицевой_счет == "" || $адрес_обслуж == "" 
      || $Дата == "" || $Наим_услуги == "" || $Наименование_ед_хран == "" || $Тариф == "" || $Количество == "" 
      || $Итого_сумма == "" ) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Input Fields must not be Empty !</div>';
          return $msg;
        }/*elseif (strlen($username) < 3) {
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
            return $msg;
        }elseif (filter_var($mobile,FILTER_SANITIZE_NUMBER_INT) == FALSE) {
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Enter only Number Characters for Mobile number field !</div>';
            return $msg;


      }elseif (filter_var($email, FILTER_VALIDATE_EMAIL === FALSE)) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Invalid email address !</div>';
          return $msg;
      }*/else{



        $sql = "UPDATE tbl_users SET
          ФИО_потреб = :2,
          Лицевой_счет = :3,
          адрес_обслуж = :4,
          Дата = :5,
          Наим_услуги = :6,
          Наименование_ед_хран = :7,
          Тариф = :8,
          Количество = :9,
          Итого_сумма = :10
          WHERE Код_показания = :1";
          $stmt= $this->db->pdo->prepare($sql);
          $stmt->bindValue(':1', $Код_показания);
          $stmt->bindValue(':2', $ФИО_потреб);
          $stmt->bindValue(':3', $Лицевой_счет);
          $stmt->bindValue(':4', $адрес_обслуж);
          $stmt->bindValue(':5', $Дата);
          $stmt->bindValue(':6', $Наим_услуги);
          $stmt->bindValue(':7', $Наименование_ед_хран);
          $stmt->bindValue(':8', $Тариф);
          $stmt->bindValue(':9', $Количество);
          $stmt->bindValue(':10', $Итого_сумма);
        $result =   $stmt->execute();

        if ($result) {
          echo "<script>location.href='indexOne.php';</script>";
          Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong> Wow, Your Information updated Successfully !</div>');



        }else{
          echo "<script>location.href='indexOne.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not inserted !</div>');
    
        }
      }
    }


    

    // Delete User by Id Method
    public function deleteUserById($remove){
      $sql = "DELETE FROM tbl_users WHERE id = :id ";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $remove);
        $result =$stmt->execute();
        if ($result) {
          $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !</strong> User account Deleted Successfully !</div>';
            return $msg;
        }else{
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not Deleted !</div>';
            return $msg;
        }
    }

    // User Deactivated By Admin
    public function userDeactiveByAdmin($deactive){
      $sql = "UPDATE tbl_users SET

       isActive=:isActive
       WHERE id = :id";

       $stmt = $this->db->pdo->prepare($sql);
       $stmt->bindValue(':isActive', 1);
       $stmt->bindValue(':id', $deactive);
       $result =   $stmt->execute();
        if ($result) {
          echo "<script>location.href='indexOne.php';</script>";
          Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong> User account Diactivated Successfully !</div>');

        }else{
          echo "<script>location.href='indexOne.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not Diactivated !</div>');

            return $msg;
        }
    }


    // User Deactivated By Admin
    public function userActiveByAdmin($active){
      $sql = "UPDATE tbl_users SET
       isActive=:isActive
       WHERE id = :id";

       $stmt = $this->db->pdo->prepare($sql);
       $stmt->bindValue(':isActive', 0);
       $stmt->bindValue(':id', $active);
       $result =   $stmt->execute();
        if ($result) {
          echo "<script>location.href='indexOne.php';</script>";
          Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong> User account activated Successfully !</div>');
        }else{
          echo "<script>location.href='indexOne.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not activated !</div>');
        }
    }




    // Check Old password method
    public function CheckOldPassword($userid, $old_pass){
      $old_pass = SHA1($old_pass);
      $sql = "SELECT password FROM tbl_users WHERE password = :password AND id =:id";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':password', $old_pass);
      $stmt->bindValue(':id', $userid);
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
        return true;
      }else{
        return false;
      }
    }



    // Change User pass By Id
    public  function changePasswordBysingelUserId($userid, $data){

      $old_pass = $data['old_password'];
      $new_pass = $data['new_password'];


      if ($old_pass == "" || $new_pass == "" ) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Password field must not be Empty !</div>';
          return $msg;
      }elseif (strlen($new_pass) < 6) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> New password must be at least 6 character !</div>';
          return $msg;
       }

         $oldPass = $this->CheckOldPassword($userid, $old_pass);
         if ($oldPass == FALSE) {
           $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     <strong>Error !</strong> Old password did not Matched !</div>';
             return $msg;
         }else{
           $new_pass = SHA1($new_pass);
           $sql = "UPDATE tbl_users SET

            password=:password
            WHERE id = :id";

            $stmt = $this->db->pdo->prepare($sql);
            $stmt->bindValue(':password', $new_pass);
            $stmt->bindValue(':id', $userid);
            $result =   $stmt->execute();

          if ($result) {
            echo "<script>location.href='indexOne.php';</script>";
            Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success !</strong> Great news, Password Changed successfully !</div>');

          }else{
            $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Error !</strong> Password did not changed !</div>';
              return $msg;
          }
         }
    }







    





}
