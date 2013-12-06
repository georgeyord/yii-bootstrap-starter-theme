<?php $this->beginContent($this->layoutBase . '/main'); ?>
<div class="row">
    <div class="col-md-3">
        <?php $this->renderPartial($this->layoutBase . '_column_2/sidebar') ?>
    </div>
    <div id="mainCol" class="col-md-9">
        <?php echo $content ?>
    </div>
</div>
<?php $this->endContent(); ?>