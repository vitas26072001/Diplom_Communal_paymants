<?php
include 'inc/header.php';
Session::CheckSession();

 ?>

<?php

if (isset($_GET['id'])) {
  $userid = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['id']);

}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
  $updateUser = $users->updateIndicationByIdInfo($userid, $_POST);

}
if (isset($updateUser)) {
  echo $updateUser;
}

?>

 <div class="card ">
   <div class="card-header">
          <h3>Профиль показаний <span class="float-right"> <a href="indexOne.php" class="btn btn-primary">Back</a> </h3>
        </div>
        <div class="card-body">

    <?php
    $getUinfo = $users->getIndicationInfoById($userid);
    if ($getUinfo) {


     ?>
          <div style="width:600px; margin:0px auto">

                        
          <form class="" action="" method="POST">
              <div class="form-group">
                <label for="text">Код показания </label>
                <input type="text" name="1" value="<?php echo $getUinfo->id; ?>" class="form-control">
              </div>
              <div class="form-group">
                <label for="text">ФИО потребителя </label>
                <input type="text" name="2" value="<?php echo $getUinfo->ФИО_потреб; ?>" class="form-control">
              </div>
              <div class="form-group">
                <label for="text">Лицевой счет </label>
                <input type="text" name="3" value="<?php echo $getUinfo->Лицевой_счет; ?>" class="form-control">
              </div>
              <div class="form-group">
                <label for="text">Адрес обслуживания </label>
                <input type="text" name="4" value="<?php echo $getUinfo->адрес_обслуж; ?>" class="form-control">
              </div>
              <div class="form-group">
                <label for="text">Дата извещения </label>
                <input type="text" name="5" value="<?php echo $getUinfo->Дата; ?>" class="form-control">
              </div>
              <div class="form-group">
                <label for="text">Услуга </label>
                <input type="text" name="6" value="<?php echo $getUinfo->Наим_услуги; ?>" class="form-control">
              </div>
              <div class="form-group">
                <label for="text">Наименование единицы хранения </label>
                <input type="text" name="7" value="<?php echo $getUinfo->Наименование_ед_хран; ?>" class="form-control">
              </div>
              <div class="form-group">
                <label for="text">Тариф </label>
                <input type="text" name="8" value="<?php echo $getUinfo->Тариф; ?>" class="form-control">
              </div>
              <div class="form-group">
                <label for="text">Количество </label>
                <input type="text" name="9" value="<?php echo $getUinfo->Количество; ?>" class="form-control">
              </div>
              <div class="form-group">
                <label for="text">Итого сумма </label>
                <input type="text" name="10" value="<?php echo $getUinfo->Итого_сумма; ?>" class="form-control">
              </div>

              <?php if (Session::get("roleid") == '1') { ?>

              <div class="form-group
              <?php if (Session::get("roleid") == '1' && Session::get("id") == $getUinfo->id) {
                echo "d-none";
              } ?>
              ">
 <!--               <div class="form-group">
                  <label for="sel1">Select user Role</label>
                  <select class="form-control" name="roleid" id="roleid">
            -->
<!--               
               <?php

                if($getUinfo->roleid == '1'){?>
                  <option value="1" selected='selected'>Admin</option>
                  <option value="2">Editor</option>
                  <option value="3">User only</option>
                <?php }elseif($getUinfo->roleid == '2'){?>
                  <option value="1">Admin</option>
                  <option value="2" selected='selected'>Editor</option>
                  <option value="3">User only</option>
                <?php }elseif($getUinfo->roleid == '3'){?>
                  <option value="1">Admin</option>
                  <option value="2">Editor</option>
                  <option value="3" selected='selected'>User only</option>


                <?php } ?>
-->

                  </select>
                </div>
              </div>

          <?php }else{?>
            <input type="hidden" name="roleid" value="<?php echo $getUinfo->roleid; ?>">
          <?php } ?>

              <?php if (Session::get("id") == $getUinfo->id) {?>


              <div class="form-group">
                <button type="submit" name="update" class="btn btn-success">Update</button>
                <a class="btn btn-primary" href="changepass.php?id=<?php echo $getUinfo->id;?>">Password change</a>
              </div>
            <?php } elseif(Session::get("roleid") == '1') {?>


              <div class="form-group">
                <button type="submit" name="update" class="btn btn-success">Update</button>
                <a class="btn btn-primary" href="changepass.php?id=<?php echo $getUinfo->id;?>">Password change</a>
              </div>
            <?php } elseif(Session::get("roleid") == '2') {?>


              <div class="form-group">
                <button type="submit" name="update" class="btn btn-success">Update</button>

              </div>

              <?php   }else{ ?>
                  <div class="form-group">

                    <a class="btn btn-primary" href="indexOne.php">Ok</a>
                  </div>
                <?php } ?>


          </form>
        </div>

      <?php }else{

        header('Location:indexOne.php');
      } ?>



      </div>
    </div>


  <?php
  include 'inc/footer.php';

  ?>
