<html>
    <head>
        <?php include(APP_PATH . '/views/head.php'); ?>
    </head>
    <body itemscope itemtype="http://schema.org/WebPage">
        <?php include(APP_PATH . '/views/header.php'); ?>
        <?php include(APP_PATH . '/views/menu.php'); ?>
        <?php include(APP_PATH . '/views/breadcrumb.php'); ?>
        
        <?php echo $content; ?>
        
        <?php include(APP_PATH . '/views/footer.php'); ?>
    </body>
</html>