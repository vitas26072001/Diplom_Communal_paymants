<?php
include 'inc/header.php';
Session::CheckSession();
$sId =  Session::get('roleid');
if ($sId === '1') { ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ServiceAdd'])) {

  $indicationAdd = $users->addNewServiceByAdmin($_POST);
}

if (isset($indicationAdd)) {
  echo $indicationAdd;
}


 ?>


 <div class="card ">
   <div class="card-header">
          <h3 class='text-center'>Добавить услугу</h3>
        </div>
        <div class="cad-body">



            <div style="width:600px; margin:0px auto">

            <form class="" action="" method="post">

                <div class="form-group pt-3">
                  <label for="service">Наименование услуги</label>
                  <input type="text" name="service"  class="form-control">
                </div>      
                              
                <div class="form-group pt-3">
                  <label for="ed">Единица хранения</label> <br>
                  <select name="ed" id="" name="ed">
                  
                              <?php
                                 // $users->City();
                                 include('list/unitV.php')
                               ?>
                   </select>
                </div>
                
                <div class="form-group pt-3">
                  <label for="tariff">Тариф </label>
                  <input type="text" name="tariff"  class="form-control">
                </div>

                <div class="form-group">
                  <button type="submit" name="ServiceAdd" class="btn btn-success">Добавить</button>
                  <a href="service.php" class="btn btn-primary">Назад</a>
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