<section>
    <h3>Comments</h3>
    <ul>
    <?php foreach($comments as $comment): ?>
        <li>
            <article itemscope itemtype="http://schema.org/Comment">
                <header>
                    
                </header>
                <div itemprop="commentText"><?php echo $comment['comment']; ?></div>
            </article>
        </li>
    <?php endforeach; ?>
    </ul>
</section>

<form action="<?php echo url('comment', true); ?>" method="post" >
    <textarea name="comment"></textarea>
    <input type="submit" />
</form>