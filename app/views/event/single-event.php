<article itemscope itemref="http://schema.org/Event">
    <header>
        <h1 itemprop="name"><?php echo $title; ?></h1>
        <p>
            <time itemprop="startDate" datetime="<?php echo $start; ?>"><?php echo $start; ?></time>
            till 
            <time itemprop="endDate" datetime="<?php echo $end; ?>"><?php echo $end; ?></time>
        </p>
    </header>
    
    <div itemprop="description">
        <?php echo $description; ?>
    </div>
    
    <?php if($attendance && $this->user->can('event.attend')): ?>
        <?php $this->view('attendance/list-attendances', ['attendances' => $attendances]); ?>
    <?php endif;?>
    
    <?php if($comment && $this->user->can('event.comment')): ?>
        <?php $this->view('comment/list-comments', ['comments' => $comments]); ?>
    <?php endif;?>
</article>