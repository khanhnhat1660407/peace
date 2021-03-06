<?php 
  require_once 'init.php';
  require_once 'functions.php';
	
	$user_id = $currentUser['id'];
    if (isset($_POST['comment_text'])) {
        
        global $db;
        $post_id             = $_POST['post_id'];
        $user_post_id        = findUserByPostId($post_id)[0]["userId"];
        $isOwner             = $currentUser['id'] == $user_post_id;
        $comment_text        = strip_tags($_POST['comment_text']);
        $result              = InsetComment($post_id,$user_id,$comment_text);
        $inserted_id         = $db->lastInsertId();
        $inserted_comment    = getCommentByID($inserted_id);
        $count_comment       = getCommentsCountByPostId($post_id);

        if (true) {
            if(!$isOwner)
            {
                addNotification($user_post_id,2,'comment',$currentUser['id'],$currentUser['username'].' đã bình luân bài viết của bạn', 'post.php?id='.$post_id);
            }
            $comment = "<div class=\"comment clearfix\">
                            <div class=\"comment-details\"> 
                                <a class=\"comment-user-name\" href=\"profile?id=\"".$inserted_comment['user_id'].">
                                    <span class=\"comment-name\">" . findUserById($inserted_comment['user_id'])['username'] . "</span>
                                </a>
                                <p>" . $inserted_comment['body'] . "</p>
                            </div>
                        </div>";
            $comment_info = array(
                'comment' => $comment,
                'comments_count' =>$count_comment 
            );
        }
    }
    