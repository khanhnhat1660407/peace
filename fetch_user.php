<?php

//fetch_user.php

include('init.php');
$query="SELECT* from users where id in (SELECT DISTINCT f1.user2Id FROM relationship AS f1 JOIN relationship AS f2  ON  f1.user2Id = f2.user1Id 
WHERE f1.user1Id ='".$_SESSION['userId']."' )";
$statement = $db->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$output = '
<div class="message-left-side">
';

foreach($result as $row)
{
	$status = '';
	$current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
	$current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
	$user_last_activity = fetch_user_last_activity($row['id'], $db);

	$output .= '
	<div class="start_chat friend-list-item" data-touserid="'.$row['id'].'" data-tousername="'.$row['username'].'">
	    <img class="friend-avatar" src="uploads/'.$row['id'].'.jpg">
		<p class="friend-name">'.$row['username'].' '.count_unseen_message($row['id'], $_SESSION['userId'], $db).' '.fetch_is_type_status($row['id'], $db).'</p>
	</div>
	';
}

$output .= '</div><div id="message-right-side" class="message-right-side"></div>';

echo $output;

?>