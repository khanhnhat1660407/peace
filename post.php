<?php
require_once 'init.php';
require_once 'functions.php';
require_once 'like_dislike.php';
require_once 'comment.php';
$page = 'post';
if (!$currentUser) {
    header('Location: index.php');
    exit();
}
$postId = $_GET['id'];
$post = findPostById($postId);
$postOwner = $post['userId'];
$relationship = findRelationship($currentUser['id'], $post['userId']);
$isFriend = count($relationship) === 2;
$isAllow = $post['privacy'] == 3 ? false : $isFriend ? true : $currentUser['id'] == $postOwner;
//echo '<prev>'; print_r([alow=>$isAllow,privacy=> $post['privacy'],postId=>$postId ,owner=>$postOwner ,isf => $isFriend ? 'true': 'false',current=> $currentUser['id'], issame =>$currentUser['id'] == $postOwner ? 'true': 'false']); exit;
?>
<?php include 'header.php'; ?>
<?php if (empty($post) || !$isAllow): ?>
    <div class="container" style="margin-top: 10%;">
        <div class="row">
            <div class="card" style="width: 80%; margin: 0 auto; text-align:center;">
                <div class="card-body">
                    <h3>Trang mà bạn yêu cầu không tìm thấy!</h3>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
<div class="container" style="margin-top: 10%;">
    <?php $comments = getAllCommentOfPost($post['id']); ?>
    <div class="card post" style="width: 80%;">
        <div class="card-body">
            <?php $userPost = findUserById($post['userId']); ?>
            <div class="user-post-info">
                <img style="width: 40px;height: 40px; border-radius: 50%;"
                     src="uploads/<?php echo $userPost['id']; ?>.jpg">
                <div class="user-post-date">
                    <a class="user-post-name" href="profile.php?id=<?php echo $post['userId']; ?>">
                        <?php echo $userPost['username']; ?>
                    </a>
                    <p class="post-date"><?php echo $post['createdAt']; ?></p>
                </div>
            </div>
            <div class="post-body">
                <p class="card-text"><?php echo $post['content']; ?></p>
                <?php if ($post['image']): ?>
                    <div class="post-image-container">
                        <img src="<?php echo $post['image']; ?>" class="post-image-img" alt="">
                    </div>
                <?php endif; ?>
            </div>
            <div class="post">
                <div class="post-like-comment">
                    <div class="post-like">
                        <i <?php if (userLiked($post['id'])): ?>
                            class="fa fa-thumbs-up like-btn"
                        <?php else: ?>
                            class="fa fa-thumbs-o-up like-btn"
                        <?php endif; ?>
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
            <form class="clearfix" action="post.php?id=<?php echo $post['id'];?>" method="post"
                  id="comment_form_<?php echo $post['id'] ?>" data-id="<?php echo $post['id']; ?>">
                <div class="comment-area">
                    <input name="post_id" value="<?php echo $post['id']; ?>" hidden>
                    <input name="comment_text" id="comment_text_<?php echo $post['id'] ?>" autocomplete="off" class="form-control">
                    <button name="submit" class="btn btn-primary btn-sm pull-right submit_comment"
                            data-id="<?php echo $post['id']; ?>">Bình luận
                    </button>
                </div>
            </form>
            <hr>
            <div id="comments_wrapper_<?php echo $post['id']; ?>">
                <?php if (isset($comments)): ?>

                    <?php foreach ($comments as $comment): ?>

                        <div class="comment clearfix">
                            <div class="comment-details">
                                <img style="width: 30px;height: 30px; border-radius: 50%;"
                                     src="uploads/<?php echo $comment['user_id']; ?>.jpg">
                                <div class="comment-body">
                                    <a class="user-comment-name"
                                       href="profile.php/?id=<?= $comment['user_id'] ?>"><span
                                            class="comment-name"><?php echo findUserById($comment['user_id'])['username'] ?></span></a>
                                    <p class="comment-content"><?php echo $comment['body']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                <?php else: ?>
                    <a>Hãy trở thành người đầu tiên bình luận về bài viết này</a>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php include 'footer.php'; ?>