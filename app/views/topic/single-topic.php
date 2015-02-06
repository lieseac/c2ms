
<h1><?php echo $title; ?></h1>

<ul>
<?php foreach($items as $item): ?>
    <li><a href="<?php echo $item['url']; ?>"><?php echo $item['title']; ?></a></li>
<?php endforeach; ?>
</ul>