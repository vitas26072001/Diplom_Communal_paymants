<?php
include 'inc/header.php';
Session::CheckSession();
$sId =  Session::get('roleid');
if ($sId === '1' || $sId === '3') { ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['IndicationAdd'])) {

  $indicationAdd = $users->addNewIndicationByAdmin($_POST);
}

if (isset($indicationAdd)) {
  echo $indicationAdd;
}

 ?>

 <div class="card ">
   <div class="card-header">
          <h3 class='text-center'>Добавить показания</h3>
        </div>
        <div class="cad-body">



            <div style="width:600px; margin:0px auto">

            <form class="" action="" method="post">

            <?php if ($sId === '1') { ?>  ?>
            
            <div class="form-group pt-3">
                  <label for="address">Адрес обслуживания</label> <br>
                  <select name="address" id="" name="address">
                  
                              <?php
                                 // $users->City();
                                 include('list/addressV.php')
                               ?>
                   </select>
                </div>    
<?php  } ?>
<?php if ($sId === '3') { ?> 
  <?php            
  $userid = Session::get('id');
    if (isset($userid)) {
              echo "Ваш ID пользователя: №".$userid;
            }     ?>       
            <div class="form-group pt-3">
                  <label for="address">Мой адрес</label> <br>
                  <?php
                               // $users->City($userid);
                               // include('list/addressVU.php')
                               //echo $users;
                               ?>
                  
                  <select name="address" id="" name="address">
                  
                              <?php
                                //$users->City($userid);
                                include('list/addressV.php')
                               
                               ?>
                   </select>
                </div>    
<?php  } ?>

            <div class="form-group pt-3">
            <form method="POST">
                  <label for="service">Наименование услуги</label> <br>
                  <select name="service" id="" name="service">
                  
                              <?php
                                 // $users->City();
                                 include('list/serviceV.php')
                               ?>
                   </select>                 

            </div>            
                
                <div class="form-group pt-3">
                   
                     <label for="nom">Показание счетчика</label>                  
                     <input type="text" name="nom"  class="form-control"><br>
                    <!-- <div class="form-group">
                          <button type="submit" name="button_id" class="btn btn-success">Расчитать сумму</button>
                     </div>-->
                     

                     <?php
                          
                          /*   # Если кнопка нажата
                           if(isset( $_POST['button_id']))
                              {  
                             $a = $_POST['nom'];
                             $b = $_POST['service'];
                             $c =$a*$b;
                            // $c = $_POST['service2'];
                             echo $c."\n=\n";
                             echo $a."*";
                             echo $b."\n";
                            
                              }*/
                      ?>
                    
                </div>
                
                <div class="form-group pt-3">
                     <label for="nom">Итого сумма</label>                  
                     <input type="text" name="summ"  class="form-control"><br>   
                </div>


               
               <!-- <div class="form-group pt-3">
                  <label for="oplat">Итого к оплате</label> <br>
                  <select name="oplat" id="" name="oplat">
                  
                              <?php
                                 // $users->City();
                               //  include('list/oplat.php')
                               ?>
                   </select>
            </div>    --> 



                <div class="form-group">
                  <button type="submit" name="IndicationAdd" class="btn btn-success">Добавить</button>
                  <a href="service.php" class="btn btn-primary">Назад</a>
                </div>


            
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