<?php
include 'inc/header.php';
Session::CheckSession();
$sId =  Session::get('roleid');
if ($sId === '1') { ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ContractAdd'])) {

  $indicationAdd = $users->addNewContractByAdmin($_POST);
}

if (isset($indicationAdd)) {
  echo $indicationAdd;
}


 ?>


 <div class="card ">
   <div class="card-header">
          <h3 class='text-center'>Добавить договор на поставку</h3>
        </div>
        <div class="cad-body">



            <div style="width:600px; margin:0px auto">

            <form class="" action="" method="post">

                                       
                <div class="form-group pt-3">
                  <label for="address">Адрес обслуживания</label> <br>
                  <select name="address" id="" name="address">
                  
                              <?php
                                 // $users->City();
                                 include('list/addressV.php')
                               ?>
                   </select>
                </div>
                <div class="form-group pt-3">
                  <label for="details">Реквизиты организации</label> <br>
                  <select name="details" id="" name="details">
                  
                              <?php
                                 // $users->City();
                                 include('list/detailsV.php')
                               ?>
                   </select>
                </div>
                <div class="form-group pt-3">
                  <label for="worker">Оформляющий сотруник</label> <br>
                  <select name="worker" id="" name="worker">
                  
                              <?php
                                 // $users->City();
                                 include('list/workerV.php')
                               ?>
                   </select>
                </div>
                
                

                <div class="form-group">
                  <button type="submit" name="ContractAdd" class="btn btn-success">Добавить</button>
                  <a href="contract.php" class="btn btn-primary">Назад</a>
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