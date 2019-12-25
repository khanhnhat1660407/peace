<?php 
ob_start();
  require_once 'init.php';
	require_once 'functions.php';
	$page = 'register';
  if(empty($currentUser)==false)
  {
	header('Location: index.php');
    exit();
  }
  ob_flush();
?>

<?php include 'header.php'; ?>

<div class="register-container">
    <div class="register-body">
        <div class="left-side">
            <img id="login-img" src="image/register-page.gif" alt="">
        </div>
        <div class="right-side">
            <h1>ĐĂNG KÝ</h1>
            <div class="login-form">
                <form method="POST">
                    <div class="form-group">
                        <input type="user" class="form-control" id="user" name="user"  placeholder="Nhập tên người dùng" autocomplete="off" minlength="4" Required >
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Nhập email" autocomplete="off" Required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" autocomplete="off" minlength="8" Required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="conf-password" placeholder="Nhập lại mật khẩu" minlength="8" autocomplete="off" Required>
                    </div>
                    <div class="register-message">
                        <?php
                        if(isset($_POST['submit']))
                        {
                            $username = $_POST['user'];
                            $email = $_POST['email'];
                            $password = $_POST['password'];
                            $conf_password =$_POST['conf-password'];
                            if($password!=$conf_password)
                            {
                                echo '<p class="message">Mật khẩu xác nhận không đúng!</p>';
                            }
                            else
                            {
                                $check =0;
                                $hashPassword = password_hash($password, PASSWORD_DEFAULT);

                                if(KiemTraTonTaiEmail($email)==true)
                                {
                                    echo '<p class="message">Email này đã có tài khoản!<a href="forgotpassword.php"> Quên mật khẩu<a></p>';
                                }
                                else if (KiemTraTonTaiUser($username)==true)
                                {
                                    echo '<p class="message">Tên người dùng này đã được sử dụng!</p>';
                                }
                                else
                                {
                                    $baseURL = explode("register.php",getBaseUrl())[0];
                                    CreateUserNoVerify($username,$email,$hashPassword);
                                    $createId = findUserByEmail($email);
                                    resizeImage('image/avatar-deafault.jpg', 512, 512, $crop=FALSE,'uploads/'.$createId['id'].'.jpg') ;
                                    $code = randomNumber(6);
                                    $secret= createVerifyEmail($createId['id'],$code);
                                    sentEmail($email,$username,'Xac thuc tai khoan Peace','<p style="font-size: 15px;">Hello,<strong>'.$username.'</strong>!Bạn đã đăng kí tài khoản Peace bằng email này.<br> Vui lòng chọn <a href="' . $baseURL . 'verify-email.php?secret=' . $secret . '&id='.$createId['id'].'">tại đây</a> để hoàn thành quá trình tạo tài khoản<p><br><h3>Mã xác thực: </h3><h2>'.$code.'</h2>');
                                    header('Location: verify-email.php?secret='.$secret.'&id='.$createId['id'].'');
                                }
                            }
                        }
                        ?>
                    </div>
                    <div class="button-register">
                        <button type="submit" id="register-submit" class="btn btn-dark" name="submit">Đăng ký</button>
                    </div>
                </form>
            </div>
            <div class="another-options">
                <div class="links">
                    <a class="option-link" id="login-link" href="login.php">Đăng nhập</a>
                    <a class="option-link" href="forgot-password.php">Quên mật khẩu</a>
                </div>
            </div>
        </div>
    </div>
</div>



<!--<h1 ">ĐĂNG KÝ</h1>-->
<!--<div class="card" style="width: 70%	; margin: 0 auto;">-->
<!--  <div class="card-body">-->
<!--	<form method="POST">-->
<!--	<div class="form-group">-->
<!--		<label style="font-weight: bold; font-size: 20px;" for="user">Tên người dùng</label>-->
<!--	    <input type="user" class="form-control" id="user" name="user"  placeholder="Nhập tên người dùng" autocomplete="off" minlength="4" Required >-->
<!--	</div>-->
<!--  	<div class="form-group"> -->
<!--	    <label style="font-weight: bold; font-size: 20px;" for="email">Email</label>-->
<!--	    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Nhập email" autocomplete="off" Required>-->
<!--	 </div>-->
<!--  <div class="form-group">-->
<!--    <label style="font-weight: bold; font-size: 20px;" for="password">Mật khẩu</label>-->
<!--    <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" autocomplete="off" minlength="8" Required>-->
<!--  </div>-->
<!--  <div class="form-group">-->
<!--    <label style="font-weight: bold; font-size: 20px;" for="password">Nhập lại mật khẩu</label>-->
<!--    <input type="password" class="form-control" id="password" name="conf-password" placeholder="Nhập lại mật khẩu" minlength="8" autocomplete="off" Required>-->
<!--  </div>-->
<!--  -->
<!--		--><?php
//			if(isset($_POST['submit']))
//			{
//				$username = $_POST['user'];
//				$email = $_POST['email'];
//				$password = $_POST['password'];
//				$conf_password =$_POST['conf-password'];
//				if($password!=$conf_password)
//				{
//					echo '<div style="text-align: center;"><p style="color:#f25119;">Mật khẩu xác nhận không đúng!</p></div>';
//				}
//				else
//				{
//					$check =0;
//					$hashPassword = password_hash($password, PASSWORD_DEFAULT);
//
//					if(KiemTraTonTaiEmail($email)==true)
//					{
//						echo '<div style="text-align: center;"><p style="color:#f25119;">Email này đã có tài khoản!<a href="forgotpassword.php"> Quên mật khẩu<a></p></div>';
//					}
//					else if (KiemTraTonTaiUser($username)==true)
//					{
//						echo '<div style="text-align: center;"><p style="color:#f25119;">Tên người dùng này đã được sử dụng! Vui lòng chọn tên khác</p></div>';
//					}
//					else
//					{
//						CreateUserNoVerify($username,$email,$hashPassword);
//						$createId = findUserByEmail($email);
//						resizeImage('image/avatar-navbar.jpg', 512, 512, $crop=FALSE,'uploads/'.$createId['id'].'.jpg') ;
//						$code = randomNumber(6);
//						$secret= createVerifyEmail($createId['id'],$code);
//						sentEmail($email,$username,'Xac thuc tai khoan Peace','<p style="font-size: 15px;">Hello,<strong>'.$username.'</strong>!Bạn đã đăng kí tài khoản Peace bằng email này.<br> Vui lòng chọn <a href="http://localhost:8080/peace/verify-email.php?secret=' . $secret . '&id='.$createId['id'].'">tại đây</a> để hoàn thành quá trình tạo tài khoản<p><br><h3>Mã xác thực: </h3><h2>'.$code.'</h2>');
//						header('Location: verify-email.php?secret='.$secret.'&id='.$createId['id'].'');
//					}
//				}
//			}
//		?>
<!--		<div style="text-align: center;">-->
<!--		<button type="submit" class="btn btn-dark" name="submit">Đăng ký</button>-->
<!--	</div>-->
<!--	</form>-->
<!--	</div>-->
<!--</div>-->
<?php include 'footer.php'; ?>



