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
          <h3><i class="fas fa-users mr-2"></i>Потребители <span class="float-right">Welcome! <strong>
                  <span class="badge badge-lg badge-secondary text-white">
                  
                  
<?php
$username = Session::get('username');
if (isset($username)) {
  echo $username;
}
 ?>
 
</span>

<?php
if ( Session::get("roleid") == '1') { ?>
  <a class="nav-link" href="clientAdd.php"><i class="fas fa-user-plus mr-2"></i>Добавить потребителя </span></a>
  <?php } ?>


        </strong></span></h3>
        </div>
        <div class="card-body pr-2 pl-2">

          <table id="example" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th  class="text-center">ID</th> 
                      <th  class="text-center">Потребитель</th>
                      <th  class="text-center">Лицевой счет</th>
                      <th  class="text-center">Адрес</th>                                     
                      <!--<th  class="text-center">Roleid</th>
                      <th  class="text-center">Created</th>-->
                      <th  width='25%' class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                     if ( Session::get("roleid") == '1') {
                      $allUser = $users->selectAllClient();

                      if ($allUser) {
                        $i = 0;
                        foreach ($allUser as  $value) {
                          $i++;

                     ?>

                      <tr class="text-center"
                     
                     <?php if (Session::get("id") == $value->id) {
                        echo "style='background:#d9edf7' ";
                      } ?>
                      >
                        <!-- Заполнение таблицы -->
                        <td><?php echo $i; ?></td>
                        <td><?php echo $value->ФИО_потреб; ?></td>
                        <td><?php echo $value->id; ?></td>
                        <td><?php echo $value->Лицевой_счет; ?></td>
                        <td><?php echo $value->Адрес_обслуж; ?></td>
                                            

                      
                        <td>

                          <?php if ( Session::get("roleid") == '1') {?>
                            <a class="btn btn-success btn-sm
                            " href="profile.php?id=<?php echo $value->id;?>">View</a>
                            <a class="btn btn-info btn-sm " href="profile.php?id=<?php echo $value->id;?>">Edit</a>
                            
                            <a onclick="return confirm('Are you sure To Delete ?')" class="btn btn-danger
                    <?php if (Session::get("id") == $value->id) {
                      echo "disabled";
                    } ?>
                             btn-sm " href="?remove=<?php echo $value->id;?>">Remove</a>

                             

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
                    <?php }} ?>




                    <?php
                     if ( Session::get("roleid") == '3') {
                      $userid = Session::get('id');
                      if (isset($userid)) {
                        echo "Ваш ID пользователя: №".$userid;
                      }
                     
                      $allUser = $users->selectAllClient();

                      if ($allUser) {
                        $i = 0;
                        foreach ($allUser as  $value) {
                          $i++;

                     ?>

                      <tr class="text-center"
                     
                     <?php if (Session::get("id") == $value->id) {
                        echo "style='background:#d9edf7' ";
                       ?>
                      >
                        <!-- Заполнение таблицы -->
                        <td><?php echo $i; ?></td>
                        <td><?php echo $value->ФИО_потреб; ?></td>
                       <!-- <td><?php echo $value->id; ?></td> -->
                        <td><?php echo $value->Лицевой_счет; ?></td>
                        <td><?php echo $value->Адрес_обслуж; ?></td>
                                            

                      
                        <td>

                          <!-- Если роль 3 -->
                        <?php if(Session::get("id") == $value->id  && Session::get("roleid") == '3'){ ?>
                          <a class="btn btn-success btn-sm " href="profile.php?id=<?php echo $value->id;?>">View</a>
                          <a class="btn btn-info btn-sm " href="profile.php?id=<?php echo $value->id;?>">Edit</a>
                        <?php }else{ ?>
                          <a class="btn btn-success btn-sm" href="profile.php?id=<?php echo $value->id;?>">View&</a>
                          <a class="btn btn-info btn-sm " href="profile.php?id=<?php echo $value->id;?>">Edit&</a>
                                                
                        <?php } ?>

                        </td>
                      </tr>
                    <?php }}}else{ ?>
                      <tr class="text-center">
                      <td>No user availabe now !</td>
                    </tr>
                    <?php }} ?>


                  </tbody>

              </table>
        </div>
      </div>



  <?php
  include 'inc/footer.php';

  ?>
