<?php foreach($users as $user) : ?>
<div class="user">
	<img src="<?php echo $user['avatar']; ?>">
	<span class="name"><?php echo $user['firstname'].' '.$user['lastname']; ?></span>
	<span class="date"><?php echo $h->human_timediff(strtotime($user['date'])); ?> ago</span>
</div>
<?php endforeach; ?>