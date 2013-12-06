<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Pascal Brewing">
    <meta name="keywords" content="Yii,Bootstrap3,Widgets,Composer,Grunt">
    <link rel="shortcut icon" href="../../assets/ico/favicon.png">
    <title><?= $this->pageTitle ?> | Yii-Bootstrap-3-Module</title>
    <?php $this->renderPartial($this->layoutBase . '/script_header') ?>
</head>
<body>

<div id="wrap">
    <!-- Fixed navbar -->
    <?php $this->renderPartial($this->layoutBase . '/navbar') ?>
    <!-- Begin page content -->
    <div class="container">
        <?php echo $content ?>
    </div>
</div>

<div id="footer">
    <div class="container">
        <ul class="list-inline text-center">
            <li class=" ">
                <?php echo BSHtml::link(
                    CHtml::image(
                        Yii::app()->baseUrl.'/img/bootstrap.png',
                        'Bootstrap3 ;)',
                        array(
                            'class' => '',
                            'height' => 30
                        )
                    ),
                    'http://getbootstrap.com',
                    array(
                        'target' => '_blank',
                    )
                )
                ?>
                <?php echo BSHtml::link(
                    CHtml::image(
                        Yii::app()->baseUrl.'/img/yii.png',
                        'Yii ;)',
                        array(
                            'class' => '',
                            'height' => 30
                        )
                    ),
                    'http://www.yiiframework.com/extension/yii-bootstrap3-module/',
                    array(
                        'target' => '_blank',
                    )
                )
                ?>
            </li>
            <li class="">
                <?php echo BSHtml::link(
                    CHtml::image(
                        Yii::app()->baseUrl.'/img/bitbucket_logo_landing.png',
                        'Bitbucket ;)',
                        array(
                            'class' => '',
                            'height' => 30
                        )
                    ),
                    'https://bitbucket.org/DrMabuse/yii-bootstrap-3-module',
                    array(
                        'target' => '_blank',
                    )
                )
                ?>
            </li>
            <li class="">
                <?php echo BSHtml::link(
                    CHtml::image(
                        Yii::app()->baseUrl.'/img/logo.png',
                        'Packagist ;)',
                        array(
                            'class' => '',
                            'height' => 30
                        )
                    ),
                    'https://packagist.org/packages/drmabuse/yii-bootstrap-3-module',
                    array(
                        'target' => '_blank',
                    )
                )
                ?>
            </li>
            <li>
                <?php echo BSHtml::emphasis(BSHtml::link(
                    BSHtml::icon(BSHtml::GLYPHICON_COPYRIGHT_MARK).' Pascal Brewing',
                    'http://www.pascal-brewing.de',
                    array('style' => 'color:#666')
                )) ?>
            </li>
        </ul>
    </div>
</div>
<div id="demo_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="clearfix"></div>
</body>
</html>

