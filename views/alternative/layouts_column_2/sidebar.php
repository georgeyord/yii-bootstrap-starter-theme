<div class="row">
    <div class="secondNav">
        <?php  $this->beginWidget('zii.widgets.CPortlet', array(
            'title'=>'',
        ));
        ?>
            <?php if(isset($this->menu) && is_array($this->menu)) : ?>
                <?php echo BSHtml::listGroup($this->menu,array('class' => 'affix')); ?>
                <div class="divider"><span></span></div>
            <?php endif; ?>
            <?php if(!empty($this->secondNavPartials)) : ?>
                <?php $max = count($this->secondNavPartials)-1 ?>
                <?php foreach($this->secondNavPartials  as $key =>$value) : ?>
                    <?php if($value['partial'] !== null) : ?>
                        <?php $this->renderPartial($value['partial'],isset($value['params'])?$value['params']:array() ) ?>
                        <div class="clearfix"></div>
                    <?php endif; ?>
                    <?php if($key < $max) : ?>
                        <div class="divider"><span></span></div>
                    <?php endif ?>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php $this->endWidget(); ?>
        <div class="clearfix"></div>
    </div>
</div>