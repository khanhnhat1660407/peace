<?php
  require_once 'init.php';
  require_once 'functions.php';
  require_once 'like_dislike.php';
  require_once 'comment.php';

  $posts = findAllPostOfFriends($currentUser['id']);
  $page = 'index';
  $privacy="1";

  if(isset($_POST['post']) )
  {
    if(empty($_POST['status'])==false )
    {
      $privacy = $_POST['Privacy-value'];
      switch($privacy)
      {
        case 'Mọi người': $privacyNum = 1;break;
        case 'Bạn bè': $privacyNum = 2;break;
        case 'Chỉ mình tôi': $privacyNum = 3;break;
      }
      $content = $_POST['status'];
      $userId = $currentUser['id'];
      addPost($userId,$content,$privacyNum);
      header('Location: index.php');
      exit();
    }
  }
?>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<?php include 'header.php';?>
<?php if(!$currentUser):?>
<div class="card" style="width: 80% ; margin: 0 auto;">
  <div class="card-body">
             <p style="font-weight:bold; font-size:20px; text-align:center; font-family:sans-serif; color:black;">Chào mừng đến với Peace. Vui lòng đăng nhập để tiếp tục</p>
             <div style="text-align: center;">
                <a class="btn btn-dark" href="login.php" role="button">Đăng nhập</a>
                <a class="btn btn-dark" href="register.php" role="button">Đăng ký</a>
            </div>
  </div>
</div>
<?php else:?>

<div class="container">
<!--    Post area -->
    <div id="card-post-area">

        <div id="post-index">
            <form method="POST" style="margin-bottom: 20px;">
                <div class="form-group" id="post-area">
                    <div id="avatar-container">
                        <div id="user-avatar">
                            <img style="width: 100px;height: 100px; border-radius: 50%;border: #333 solid 2px;" src="uploads/<?php echo $currentUser['id'] ;?>.jpg">
                            <p style="font-weight:bold; font-size:20px; font-family:sans-serif;  color:black;"><?php echo $currentUser['username'];?></p>
                        </div>
                    </div>
                    <div id="input-container">
                        <textarea class="form-control" id="status" name ="status" placeholder="Bạn đang nghĩ gì?" Required></textarea>
                    </div>
                    <textarea style="display:none;" class="getDropdownValue" rows="1" name ="Privacy-value">Mọi người</textarea>
                </div>
                <div style="text-align: right;">
                    <div class="dropdown">
                        <form method="POST">
                            <button type="button" class="btn btn-info" name="post-image" id="post-image">Đăng ảnh</button>
                            <input type="file"  name="upload_image" id="upload_image" multiple style="display: none;">

                            <button class="btn btn-secondary dropdown-toggle" style="min-width: 150px;" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            ><span class="privacy-value">Mọi người</span></button>
                            <button type="submit" class="btn btn-primary" name="post">Đăng</button>
                            <div class="dropdown-menu" id="dropdown-menu-index" type="submit"  aria-labelledby="dropdownMenuButton">
                                <li><a style="cursor: default;" class="dropdown-item">Mọi người</a></li>
                                <li><a style="cursor: default;" class="dropdown-item">Bạn bè</a></li>
                                <li><a style="cursor: default;" class="dropdown-item">Chỉ mình tôi</a></li>
                            </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<!-- end post area-->
    <?php foreach ($posts as $post ) : ?>
        <?php $comments=getAllCommentOfPost($post['id']);?>
        <div class="card post" style="width: 80%;">
            <div class="card-body">
                <?php $userPost = findUserById($post['userId']);?>
                <div class="user-post-info">
                    <img style="width: 40px;height: 40px; border-radius: 50%;" src="uploads/<?php echo $userPost['id'];?>.jpg">
                    <div class="user-post-date">
                        <a class="user-post-name" href="profile.php?id=<?php echo $post['userId'];?>">
                            <?php echo $userPost['username']; ?>
                        </a>
                        <p class="post-date" ><?php echo $post['createdAt']; ?></p>
                    </div>
                </div>
                <p class="card-text"><?php echo $post['content']; ?></p>
                <div class ="post">
                    <div class="post-like-comment">
                        <div class="post-like">
                            <i <?php if (userLiked($post['id'])): ?>
                                class="fa fa-thumbs-up like-btn"
                            <?php else: ?>
                                class="fa fa-thumbs-o-up like-btn"
                            <?php endif ?>
                                    data-id="<?php echo $post['id'] ?>">
                            </i>
                            <span class="likes"><?php echo getLikes($post['id']); ?></span><span> lượt thích</span>
                        </div>
                        <div class="post-comment">
                            <i class="fa fa-commenting-o" aria-hidden="true"></i>
                            <span id="comments_count_<?php echo $post['id'] ?>"><?php echo count($comments) ?></span><span> bình luận</span>
                        </div>
                    </div>
                </div>


                <form class="clearfix" action="index.php" method="post"
                      id="comment_form_<?php echo $post['id'] ?>" data-id="<?php echo $post['id']; ?>">
                    <div class="comment-area">
                        <input name="post_id" value="<?php echo $post['id']; ?>" hidden>
                        <input name="comment_text" id="comment_text_<?php echo $post['id'] ?>" class="form-control" ></input>
                        <button name="submit" class="btn btn-primary btn-sm pull-right submit_comment" data-id="<?php echo $post['id']; ?>">Bình luận</button>
                    </div>
                </form>
                <hr>

                <div id="comments_wrapper_<?php echo $post['id']; ?>">
                    <?php if (isset($comments)): ?>

                        <?php foreach ($comments as $comment): ?>

                            <div class="comment clearfix">
                                <div class="comment-details">
                                    <img style="width: 30px;height: 30px; border-radius: 50%;" src="uploads/<?php echo $comment['user_id'];?>.jpg">
                                    <div class="comment-body">
                                        <a class="user-comment-name" href="profile.php/?id=<?=$comment['user_id']?>"><span class="comment-name"><?php echo findUserById($comment['user_id'])['username'] ?></span></a>
                                        <p><?php echo $comment['body']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- // comment -->
                        <?php endforeach ?>
                    <?php else: ?>
                        <a>Hãy trở thành người đầu tiên bình luận về bài viết này</a>
                    <?php endif ?>
                </div><!-- comments wrapper -->
            </div><!-- // all comments -->
            <!-- end comment3 -->


        </div>
    <?php endforeach; ?>
</div>

<?php endif;?>
<?php include 'footer.php'; ?>