<article itemscope itemtype="http://schema.org/Article">
    <header>
        <h1 itemprop="name"><?php echo $title; ?></h1>
    </header>
    
    <div itemprop="articleBody">
        <?php echo $content; ?>
    </div>
    
    <?php if($comment && $this->user->can('article.comment')): ?>
        <?php $this->view('comment/list-comments', ['comments' => $comments]); ?>
    <?php endif;?>
</article>