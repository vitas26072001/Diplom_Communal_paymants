<?php
include 'inc/header.php';
Session::CheckSession();
$sId =  Session::get('roleid');
if ($sId === '1') { ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['DetailsAdd'])) {

  $indicationAdd = $users->addNewDetailsByAdmin($_POST);
}

if (isset($indicationAdd)) {
  echo $indicationAdd;
}


 ?>


 <div class="card ">
   <div class="card-header">
          <h3 class='text-center'>Добавить реквезиты</h3>
        </div>
        <div class="cad-body">



            <div style="width:600px; margin:0px auto">

            <form class="" action="" method="post">

                <div class="form-group pt-3">
                  <label for="firm">Наименование организации</label>
                  <input type="text" name="firm"  class="form-control">
                </div>      
                <div class="form-group pt-3">
                  <label for="unp">УНП организации </label>
                  <input type="text" name="unp"  class="form-control">
                </div>
                <div class="form-group pt-3">
                  <label for="address">Адрес организации </label>
                  <input type="text" name="address"  class="form-control">
                </div>

                <div class="form-group">
                  <button type="submit" name="DetailsAdd" class="btn btn-success">Добавить</button>
                  <a href="details.php" class="btn btn-primary">Назад</a>
                </div>


            </form>
          </div>


        </div>
      </div>

<?php
}else{

  header('Location:indexOne.php');



}
 ?>

  <?php
  include 'inc/footer.php';

  ?>