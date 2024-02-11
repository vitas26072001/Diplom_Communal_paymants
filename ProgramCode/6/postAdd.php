<?php
include 'inc/header.php';
Session::CheckSession();
$sId =  Session::get('roleid');
if ($sId === '1') { ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['PostAdd'])) {

  $indicationAdd = $users->addNewPostByAdmin($_POST);
}

if (isset($indicationAdd)) {
  echo $indicationAdd;
}


 ?>


 <div class="card ">
   <div class="card-header">
          <h3 class='text-center'>Добавить должность</h3>
        </div>
        <div class="cad-body">



            <div style="width:600px; margin:0px auto">

            <form class="" action="" method="post">

                <div class="form-group pt-3">
                  <label for="post">Наименование должности</label>
                  <input type="text" name="post"  class="form-control">
                </div>               
                        
                <div class="form-group">
                  <button type="submit" name="PostAdd" class="btn btn-success">Добавить</button>
                  <a href="post.php" class="btn btn-primary">Назад</a>
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