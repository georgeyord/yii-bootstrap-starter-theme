<?php
/**
 * User: Pascal Brewing
 * Date: 08.09.13
 * Time: 19:56
 * @package ${DIR}.${NAME}
 * Class ${NAME}
 */
$cs = Yii::app()->clientScript;
$themePath = '/assets-' . Yii::app()->theme->name.'/alternative';
if(isset(Yii::app()->params->version))
    $version = Yii::app()->params->version;
else if($this->module && isset ($this->module->params) && isset ($this->module->params['version']))
    $version = $this->module->params['version'];
$version = trim(str_replace(' Version ', '', $version));
//CVarDumper::dump($version);
/**
 * StyleSHeets
 */
if (YII_DEBUG) {
    $cs
        ->registerCssFile($themePath . '/css/bootstrap.css')
        ->registerCssFile($themePath . '/css/bootstrap-theme.css');
} else {
    $cs->registerCssFile($themePath . "/css/application-{$version}.min.css");
}

/**
 * JavaScripts
 */
//echo CGoogleApi::init();

//echo CHtml::script(
//    CGoogleApi::load('jquery.min','1.8.3')
//);

$cs
    ->registerCoreScript('jquery', CClientScript::POS_END)
    ->registerCoreScript('jquery.ui', CClientScript::POS_END);
if (YII_DEBUG) {
    $cs
        ->registerScriptFile($themePath . '/js/bootstrap.js', CClientScript::POS_END)
        ->registerScriptFile($themePath . '/js/holder.js', CClientScript::POS_END);
//    $cs->registerScriptFile($themePath . '/js/redactor/redactor.min.js', CClientScript::POS_END);
} else {
//    $cs->registerScriptFile($themePath . '/js/redactor/redactor.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($themePath . "/js/application-{$version}.min.js", CClientScript::POS_END);
}
$cs
//    ->registerScriptFile('https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js?lang=css', CClientScript::POS_END)
    ->registerScript('tooltip', "$('[data-toggle=\"tooltip\"]').tooltip();", CClientScript::POS_READY)
    ->registerScript('popover', "$('[data-toggle=\"popover\"]').popover();", CClientScript::POS_READY)
    ->registerScript('analytics',
        "
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-34355526-3', 'pascal-brewing.de');
          ga('send', 'pageview');
        "
        , CClientScript::POS_END
    )
    ->registerScript('affix',
        "
            $('#myAffix').affix({
                offset: {
                    top: 100
                    , bottom: function () {
                        return (this.bottom = $('.bs-footer').outerHeight(true))
                    }
                }
            });
            var _body = $('body');
            _body.scrollspy({
                target: '.bs-sidebar',
                offset: 100
            });

            $(window).on('load', function () {
                _body.scrollspy('refresh')
            });
        ",
        CClientScript::POS_READY
    );

?>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="<?php echo $themePath ?>/js/html5shiv.js"></script>
<script src="<?php echo $themePath ?>/js/respond.min.js"></script>
<![endif]-->
