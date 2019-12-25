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


    <div class="forgot-container">
        <div class="forgot-body">
			<?php if(isset($_POST['submit'])): ?>
				<?php $email = $_POST['email']; ?>
                <div class="left-side">
                    <img id="forgot-img" src="image/send-email-successfully.gif" alt="">
                </div>
                <div class="right-side-success">
                    <div class="message">
                        <div style="text-align: center;"><img src="./image/successful.png" style="width: 60px; height: 60px;"></div><br>
                        <div class="message">
                            <h3>
                                Đã gửi email khôi phục!
                            </h3>
                        </div>
                    </div>
                    <div class="another-options">
                        <div class="links">
                            <a class="option-link" id="login-link" href="login.php">Đăng nhập</a>
                            <a class="option-link"  href="register.php">Đăng ký</a>
                        </div>
                    </div>
                </div>
				<?php
				if(kiemTraTonTaiEmail($email))
				{
					$user = findUserByEmail($email);
					$secret = createResetPassword($user['id']);
					$baseUrl = explode("forgot-password.php",getBaseUrl())[0];
					sentEmail($user['email'],$user['username'],'Xac nhan doi mat khau','Xin chào <strong>'.$user['username'].'</strong>! Bạn đã yêu cầu khôi phục mật khẩu.<br> Vui lòng click <a href="' . $baseUrl . 'reset-password.php?secret=' . $secret . '">vào đây</a> để đổi mật khẩu!');
				}

				 ?>
				<?php else: ?>
            <div class="left-side">
                <img id="forgot-img" src="image/forgot-pasword-page.png" alt="">
            </div>
            <div class="right-side">
                <h2 style="text-align: center;">KHÔI PHỤC MẬT KHẨU</h2>

                <div class="forgot-form">
                    <form method="POST">
                        <div class="form-group">
                            <label style="font-weight: bold; font-size: 20px;" for="email">Email khôi phục</label>
                            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Nhập email" Required autocomplete="off">
                        </div>
                        <div class="button-reset">
                            <button type="submit"  class="btn btn-dark btn-reset" name="submit">Khôi phục</button>
                        </div>
                    </form>
                </div>
                <div class="another-options">
                    <div class="links">
                        <a class="option-link" id="login-link" href="login.php">Đăng nhập</a>
                        <a class="option-link"  href="register.php">Đăng ký</a>
                    </div>
                </div>
            </div>
                <?php endif ?>

			</div>
		</div>	
	<?php include 'footer.php'; ?>