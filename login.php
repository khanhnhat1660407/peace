<?php 
  require_once 'init.php';
	require_once 'functions.php';
	$page = 'login';
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
                        <button type="submit" name="log-submit" id="log-submit" class="btn btn-dark">Đăng nhập</button>
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

<?php include 'footer.php'; ?>