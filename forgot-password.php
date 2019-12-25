<?php 
require_once 'init.php';
require_once 'functions.php';
$page = 'forgot-password';
if($currentUser)
{
	header('Location: index.php');
	exit();
}

?>
<?php include 'header.php'; ?>

    <div class="login-container">
        <div class="login-body">
            <div class="left-side">
                <img id="login-img" src="image/login-page.gif" alt="">
            </div>
            <div class="right-side">
                <h1 >Đăng nhập</h1>
                <div class="login-form">
                    <form method="POST" >
                        <div class="form-group">
                            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Nhập email" autocomplete="off" Required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="password" name ="password" placeholder="Nhập mật khẩu" autocomplete="off" >
                        </div>
                        <div class="login-message">
                            <?php

                            if(isset($_POST['email'])&& isset($_POST['password']))
                            {

                                $password = $_POST['password'];
                                $email = $_POST['email'];
                                $user = findUserByEmail($email);
                                if($user)
                                {
                                    if($user['verified']==1)
                                    {
                                        $checkpass = password_verify($password,$user['password']);
                                        if($checkpass)
                                        {
                                            $_SESSION['userId'] = $user['id'];
                                            header('Location: index.php');
                                            exit();
                                        }
                                        else
                                        {
                                            echo '<p class="message">Sai email hoặc mật khẩu</p>';

                                        }
                                    }
                                    else
                                    {
                                        $verify =  findVerifyByUserId($user['id']);
                                        header('Location: verify-email.php?secret='.$verify['secret'].'&id='.$verify['userId'].'');
                                    }
                                }
                                else
                                {
                                    echo '<p class="message">Sai email hoặc mật khẩu</p>';

                                }
                            }

                            ?>
                        </div>
                        <div class="button-login">
                            <button type="submit" name="login-submit" id="log-submit" class="btn btn-dark">Đăng nhập</button>
                        </div>

                    </form>
                </div>
                <div class="another-options">
                    <div class="links">
                        <a class="option-link" id="register-link" href="register.php">Đăng ký</a>
                        <a class="option-link" href="forgot-password.php">Quên mật khẩu</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<h1 style="text-align: center;">KHÔI PHỤC MẬT KHẨU</h1>
	<div class="card" style="width: 70%	; margin: 0 auto;">
		<div class="card-body">
			<?php if(isset($_POST['submit'])): ?>
				
				
				<?php $email = $_POST['email']; ?>
				<div style="text-align: center;"><img src="./image/successful.png" style="width: 60px; height: 60px;"></div><br>
				<div class="alert alert-success" role="alert">
					Đã gửi xác nhận khôi phục mật khẩu đến email của bạn!
				</div>
				<?php 
				if(kiemTraTonTaiEmail($email))
				{
					$user = findUserByEmail($email);
					$secret = createResetPassword($user['id']);
					$baseUrl = explode("forgot-password.php",getBaseUrl())[0];
					echo $baseUrl;
					sentEmail($user['email'],$user['username'],'Xac nhan doi mat khau','Xin chào <strong>'.$user['username'].'</strong>! Bạn đã yêu cầu khôi phục mật khẩu.<br> Vui lòng click <a href="' . $baseUrl . 'reset-password.php?secret=' . $secret . '">vào đây</a> để đổi mật khẩu!');
				}

				 ?>
				<?php else: ?>				
					<form method="POST">
						<div class="form-group">
							<label style="font-weight: bold; font-size: 20px;" for="email">Email khôi phục</label>
							<input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Nhập email" Required autocomplete="off">
						</div>
						<div style="text-align: center;">
							<button type="submit" class="btn btn-dark" name="submit">Khôi phục</button>
						</div>
                    </form>
                <?php endif ?>

			</div>
		</div>	
	<?php include 'footer.php'; ?>