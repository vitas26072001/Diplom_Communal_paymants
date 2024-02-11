<?php
include 'inc/header.php';
Session::CheckSession();
$sId =  Session::get('roleid');
if ($sId === '1') { ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ClientAdd'])) {

  $indicationAdd = $users->addNewClientByAdmin($_POST);
}

if (isset($indicationAdd)) {
  echo $indicationAdd;
}


 ?>


 <div class="card ">
   <div class="card-header">
          <h3 class='text-center'>Добавить потребителя</h3>
        </div>
        <div class="cad-body">



            <div style="width:600px; margin:0px auto">

            <form class="" action="" method="post">

                <div class="form-group pt-3">
                  <label for="client">ФИО потребителя</label>
                  <input type="text" name="client"  class="form-control">
                </div>               
                <div class="form-group">
                  <label for="nom">Лицевой счет</label>
                  <input type="text" name="nom"  class="form-control">
                </div>
                                
                <div class="form-group">
                  <button type="submit" name="ClientAdd" class="btn btn-success">Добавить</button>
                  <a href="client.php" class="btn btn-primary">Назад</a>
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