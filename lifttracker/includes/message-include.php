<?php echo($this->GetHtmlSafeText($message)); ?>

<?php if (isset($list)) { ?>
    <ul>
    <?php foreach ($list as $listItem) { ?>
        <li><?php echo($this->GetHtmlSafeText($listItem)); ?></li>
    <?php } ?>
    </ul>
<?php } ?>
