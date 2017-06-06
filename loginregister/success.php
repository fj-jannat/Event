<?php
require('includes/config.php');
if(isset($_POST['ok'])){
  header('Location:../');
  exit;
}

$title = 'Successful Registration';
$locationLink = './login.php';
$loginstate = 'fa fa-user';
$state = "User Login";
require('../include/front.php');
?>
<br>
<br>
<div class="container">
  <div class="row">
      <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			     <form role="form" method="post" action="" autocomplete="off">
             <br><br><br><br>
				         <h2>Welcome To <?php echo COMPANY_NAME?></h2>
				             <hr>
                      <?php
                        if(isset($_GET['action']) && $_GET['action'] == 'joined'){
                          echo "<h2 class='bg-success'>Registration successful, please check your email to activate your account.</h2>";
                        }
                      ?>
                      <div class="row">
                        <div class="col-xs-6 col-md-6"><input type="submit" name="ok" value="OK" class="btn btn-primary btn-block btn-lg" tabindex="5"></div>
                      </div>
            </form>
        </div>
    </div>
</div>
<?php
require('../include/footer.php');
 ?>
