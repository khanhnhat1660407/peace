<?php
require_once 'init.php';
require_once 'functions.php';
require_once 'like_dislike.php';
require_once 'comment.php';
$page = 'result';
$name = $_GET['name'];
$peoples = searchFriendByName($name, $currentUser['id']);
$posts = searchPostByString($name);
if (!$currentUser) {
    header('Location: index.php');
    exit();
}
?>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <script src="script.js"></script>

<?php include 'header.php'; ?>
<div class="container">
    <br><br><br><br>
<?php if (empty($peoples) && empty($posts)): ?>
    <div style="text-align: center;">
        <h4>Không có kết quả tìm kiếm cho '<?php echo $name; ?>'</h4>
    </div>
<?php else: ?>
    <div style="text-align: center;">
        <h4>Kết quả tìm kiếm cho '<?php echo $name; ?>'</h4>
    </div>
    <?php if (empty($peoples) == false): ?>
        <div class="card" style="width: 80%; margin: 0 auto; border: none; margin-top: 15px"><h4>Mọi người</h4></div>
    <?php endif; ?>
    <?php foreach ($peoples as $people) : ?>
        <div class="card" style="width: 80%; margin: 0 auto; border-radius: 20px;">
            <div class="card-body">
                <div class="row">
                    <div class="col-2" style="max-width: 100px">
                        <a href="profile.php?id=<?php echo $people['id']; ?>">
                            <img style="width: 80px;height: 80px; border-radius: 50%;"
                                 src="uploads/<?php echo $people['id']; ?>.jpg">
                        </a>
                    </div>
                    <div class="col-10">
                        <h5 class="text-left">
                            <a class="user-post-name" href="profile.php?id=<?php echo $people['id']; ?>">
                                <?php echo $people['username']; ?>
                            </a>
                            <?php if ($people['id'] != $currentUser['id']) : ?>
                                <?php $mutualFriends = countMutualFriend($currentUser['id'], $people['id']); ?>
                                <?php if ($mutualFriends != 0) : ?>
                                    <p class="text-secondary"><?php echo $mutualFriends; ?> bạn chung</p>
                                <?php endif; ?>
                            <?php endif; ?>
                        </h5>
                    </div>
                </div>

            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($posts) == false): ?>
        <div style="width: 80%; margin: 0 auto;">
            <hr>
        </div>
        <div class="card" style="width: 80%; margin: 0 auto; border: none; margin-top: 15px"><h4>Bài viết</h4></div>
    <?php endif; ?>
    <?php foreach ($posts as $post) : ?>
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


                <form class="clearfix" action="index.php" method="post"
                      id="comment_form_<?php echo $post['id'] ?>" data-id="<?php echo $post['id']; ?>">
                    <div class="comment-area">
                        <input name="post_id" value="<?php echo $post['id']; ?>" hidden>
                        <input name="comment_text" id="comment_text_<?php echo $post['id'] ?>" class="form-control">
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
                                        <p><?php echo $comment['body']; ?></p>
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
    <?php endforeach; ?>
<?php endif; ?>
</div>
<?php include 'footer.php'; ?>