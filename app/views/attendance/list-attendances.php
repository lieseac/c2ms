<section itemprop="attendees">
    <h3>Attendance</h3>
    <ul>
    <?php foreach($attendances as $attendance): ?>
        <li><?php echo $attendance['name'];?></li>
    <?php endforeach; ?>
    </ul>

    <form action="<?php echo url('attend', true); ?>" method="POST">
        <label for="subscribe">Subscribe</label><input type="radio" id="subscribe" name="attend" value="1" onclick="this.form.submit();"/>
        <label for="unsubscibe">Unsubscribe</label><input type="radio" id="unsubscribe" name="attend" value="0" onclick="this.form.submit();"/>
    </form>
</section>