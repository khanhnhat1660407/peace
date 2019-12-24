<?php 
  require_once 'init.php';
  require_once 'functions.php';
	
	$user_id = $currentUser['id'];
    if (isset($_POST['comment_text'])) {
        
        global $db;
        $post_id             = $_POST['post_id'];
        $comment_text        = $_POST['comment_text'];
        $result              = InsetComment($post_id,$user_id,$comment_text);
        $inserted_id         = $db->lastInsertId();
        $inserted_comment    = getCommentByID($inserted_id);
        $count_comment       = getCommentsCountByPostId($post_id);
    
        if (true) {
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
    