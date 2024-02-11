<?php
include 'inc/header.php';
Session::CheckSession();
$sId =  Session::get('roleid');
if ($sId === '1') { ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['WorkerAdd'])) {

  $indicationAdd = $users->addNewWorkerByAdmin($_POST);
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
                  <label for="worker">ФИО сотрудника</label>
                  <input type="text" name="worker"  class="form-control">
                </div>      
                              
                <div class="form-group pt-3">
                  <label for="post">Должность</label> <br>
                  <select name="post" id="" name="post">
                  
                              <?php
                                 // $users->City();
                                 include('list/postV.php')
                               ?>
                   </select>
                </div>
                
                <div class="form-group">
                  <button type="submit" name="WorkerAdd" class="btn btn-success">Добавить</button>
                  <a href="worker.php" class="btn btn-primary">Назад</a>
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