
<h1>Artikelen</h1>

<ul>
<?php foreach($articles as $article): ?>
    <li><a href="<?php echo $article['url']; ?>"><?php echo $article['title']; ?></a></li>
<?php endforeach; ?>
</ul>