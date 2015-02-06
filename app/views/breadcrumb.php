<ol itemprop="breadcrumb" itemscope itemref="http://schema.org/BreadcrumbList">
    
    <?php foreach ($breadcrumbs as $i => $crumb): ?>
    <li itemprop="itemListElement" itemscope itemref="http://schema.org/ListItem">
        <a itemprop="item" href="<?php echo url($crumb); ?>"><span itemprop="name"><?php echo $crumb; ?></span></a>
        <meta itemprop="position" content="<?php echo $i; ?>">
    </li>
    <?php endforeach;?>
    
</ol>