
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
          <h3><i class="fas fa-users mr-2"></i>Извещение <span class="float-right">Welcome! <strong>
                  <span class="badge badge-lg badge-secondary text-white">
                  
                  
<?php
$username = Session::get('username');
if (isset($username)) {
  echo $username;
}
 ?>
 
</span>


  <a class="nav-link" href="notificationAdd.php"><i class="fas fa-user-plus mr-2"></i>Сформировать новое извещение </span></a>



        </strong></span></h3>
        </div>
        <div class="card-body pr-2 pl-2">

          <table id="example" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th  class="text-center">ID</th>
                      <th  class="text-center">Номер извещения</th> 
                      <th  class="text-center">Дата составления</th>
                      <th  class="text-center">Потребитель</th>
                      <th  class="text-center">Лицевой_счет</th>
                      <th  class="text-center">Адрес осбслуживания</th>
                      <th  class="text-center">Организация</th>
                      <th  class="text-center">Оформил</th>
                                            
                      <!--<th  class="text-center">Roleid</th>
                      <th  class="text-center">Created</th>-->
                      <th  width='25%' class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                      $allUser = $users->selectAllNotification();

                      if ($allUser) {
                        $i = 0;
                        foreach ($allUser as  $value) {
                          $i++;

                     ?>

                      <tr class="text-center"
                     
                     <?php if (Session::get("id") == $value->Код_извещения) {
                        echo "style='background:#d9edf7' ";
                      } ?>
                      >
                        <!-- Заполнение таблицы -->
                        <td><?php echo $i; ?></td>
                        <td><?php echo $value->Код_извещения; ?></td>
                        <td><?php echo $value->Дата_сост; ?></td>
                        <td><?php echo $value->ФИО_потреб; ?></td>
                        <td><?php echo $value->Лицевой_счет; ?></td>
                        <td><?php echo $value->Адрес_обслуж; ?></td>
                        <td><?php echo $value->Название_орган; ?></td>
                        <td><?php echo $value->ФИО; ?></td>

                        <td>

                          <?php if ( Session::get("roleid") == '1') {?>
                            <a class="btn btn-success btn-sm " href="notificationSER.php?Код_извещения=<?php echo $value->Код_извещения;?>">Показания</a>
                            <a class="btn btn-info btn-sm " href="notification/select2.php?Код_извещения=<?php echo $value->Код_извещения;?>">PDF file</a>
                  
                            <a onclick="return confirm('Are you sure To Delete ?')" class="btn btn-danger
                    <?php if (Session::get("id") == $value->Код_извещения) {
                      echo "disabled";
                    } ?>
                             btn-sm " href="?remove=<?php echo $value->Код_извещения;?>">Remove</a>

                             

<!-- вывод если не админ а юзер -->
                        <?php  }
                        else if(Session::get("id") == $value->id  && Session::get("roleid") == '2'){ ?>
                          <a class="btn btn-success btn-sm " href="profile.php?id=<?php echo $value->id;?>">View</a>
                          <a class="btn btn-info btn-sm " href="profile.php?id=<?php echo $value->id;?>">Edit</a>
                        <?php  }
                        else if( Session::get("roleid") == '2'){ ?>
                          <a class="btn btn-success btn-sm
                          <?php if ($value->roleid == '1') {
                            echo "disabled";
                          } ?>
                          " href="profile.php?id=<?php echo $value->id;?>">View</a>
                          <a class="btn btn-info btn-sm
                          <?php if ($value->roleid == '1') {
                            echo "disabled";
                          } ?>
                          " href="profile.php?id=<?php echo $value->id;?>">Edit</a>


                          <!-- Если роль 3 -->
                        <?php }elseif(Session::get("id") == $value->id  && Session::get("roleid") == '3'){ ?>
                          <a class="btn btn-success btn-sm " href="profile.php?id=<?php echo $value->id;?>">View</a>
                          <a class="btn btn-info btn-sm " href="profile.php?id=<?php echo $value->id;?>">Edit</a>
                        <?php }else{ ?>
                          <a class="btn btn-success btn-sm
                          <?php if ($value->roleid == '1') {
                            echo "disabled";
                          } ?>
                          " href="profile.php?id=<?php echo $value->id;?>">View</a>

                        <?php } ?>

                        </td>
                      </tr>
                    <?php }}else{ ?>
                      <tr class="text-center">
                      <td>No user availabe now !</td>
                    </tr>
                    <?php } ?>

                  </tbody>

              </table>









        </div>
      </div>



  <?php
  include 'inc/footer.php';

  ?>
