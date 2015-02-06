<h1>Kalender</h1>

<ul>
<?php foreach($events as $event): ?>
    <li><a href="<?php echo $event['url']; ?>"><?php echo $event['title']; ?></a></li>
<?php endforeach; ?>
</ul>