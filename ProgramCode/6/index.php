<?php
include 'inc/header.php';

Session::CheckSession();

$logMsg = Session::get('logMsg');
if (isset($logMsg)) {
  echo $logMsg;
}

$msg = Session::get('msg');
if (isset($msg)) {
  echo $msg;
}

Session::set("msg", NULL);
Session::set("logMsg", NULL);
?>

<?php

if (isset($_GET['remove'])) {
  $remove = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['remove']);
  $removeUser = $users->deleteUserById($remove);
}

if (isset($removeUser)) {
  echo $removeUser;
}

if (isset($_GET['deactive'])) {
  $deactive = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['deactive']);
  $deactiveId = $users->userDeactiveByAdmin($deactive);
}

if (isset($deactiveId)) {
  echo $deactiveId;
}

if (isset($_GET['active'])) {
  $active = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['active']);
  $activeId = $users->userActiveByAdmin($active);
}

if (isset($activeId)) {
  echo $activeId;
}

 ?>
      <div class="card ">
        <div class="card-header">
          <h3><i class="fas fa-users mr-2"></i>Меню <span class="float-right">Welcome! <strong>
            <span class="badge badge-lg badge-secondary text-white">
<?php
$username = Session::get('username');
if (isset($username)) {
  echo $username;
}
 ?>
 

</span>


        </strong></span></h3>
        </div>

        <?php if (Session::get('id') == TRUE) { ?>
            <?php if (Session::get('roleid') == '1') { ?>
        <div class="card-body pr-2 pl-2">

<a class="btn btn-primary btn-lg btn-block" href="indication.php"><i class="fas fa-users mr-2"></i>Показания </span></a>
<a class="btn btn-dark btn-lg btn-block" href="client.php"><i class="fas fa-users mr-2"></i>Потребители</span></a>
<a class="btn btn-success btn-lg btn-block" href="address.php"><i class="fas fa-users mr-2"></i>Адреса обслуживания </span></a>
<a class="btn btn-danger btn-lg btn-block" href="worker.php"><i class="fas fa-users mr-2"></i>Сотрудники </span></a>
<a class="btn btn-warning btn-lg btn-block" href="post.php"><i class="fas fa-users mr-2"></i>Должности </span></a>
<a class="btn btn-info btn-lg btn-block" href="service.php"><i class="fas fa-users mr-2"></i>Услуги </span></a>
<a class="btn btn-dark btn-lg btn-block" href="unit.php"><i class="fas fa-users mr-2"></i>Единицы хранения </span></a>
<a class="btn btn-primary btn-lg btn-block" href="details.php"><i class="fas fa-users mr-2"></i>Реквизиты </span></a>
<a class="btn btn-success btn-lg btn-block" href="notification.php"><i class="fas fa-users mr-2"></i>Извещение </span></a>
<a class="btn btn-danger btn-lg btn-block" href="contract.php"><i class="fas fa-users mr-2"></i>Договор на поставку </span></a>
<a class="btn btn-warning btn-lg btn-block" href="indexOne.php"><i class="fas fa-users mr-2"></i>User lists </span></a>
        </div>

        <?php  } ?>
            <?php if (Session::get('roleid') == '3') { ?>
              <div class="card-body pr-2 pl-2">
              
<a class="btn btn-primary btn-lg btn-block" href="indication.php"><i class="fas fa-users mr-2"></i>Показания </span></a>
<a class="btn btn-dark btn-lg btn-block" href="client.php"><i class="fas fa-users mr-2"></i>Потребители</span></a>
<a class="btn btn-success btn-lg btn-block" href="address.php"><i class="fas fa-users mr-2"></i>Адреса обслуживания </span></a>
<a class="btn btn-danger btn-lg btn-block" href="service.php"><i class="fas fa-users mr-2"></i>Услуги </span></a>
<a class="btn btn-warning btn-lg btn-block" href="contract.php"><i class="fas fa-users mr-2"></i>Договор на поставку </span></a>
</div>

<?php  }} ?>

      </div>



  <?php
  include 'inc/footer.php';

  ?>
