<?php

/**
 * Overload CActiveForm so the only thing that a developer should do
 * when there is a need for tooltips, pphDropDowns, tags input etc would only
 * be writing the actual form.
 *
 * NOTE: Please note that errors should not be echoed because this would result
 * as duplicate error display
 */
class BsForm extends CActiveForm {
    // JS file required
    const ASSOCIATED_JS_OBJECT = 'bsform';
    
    // Additional Components used
    const TAGSINPUT = 'tagsinput';

    // CSS Classes used for tooltips & errors
    const ERROR_CSS_CLASSES = 'error-state';

    /**
     * @var boolean $enableClientValidation By default enable client validation
     */
    public $enableClientValidation = true;

    /**
     * @var boolean $clearOnFocus Clear validation errors on element focus
     */
    public $clearOnFocus = true;

    /**
     * @var string $errorSummarySeparator the error summary separator
     */
    public $errorSummarySeparator = PHP_EOL;

    /**
     * @var string $errorMessageCssClass the css class that gets applied to an error message
     */
    public $errorMessageCssClass = self::ERROR_CSS_CLASSES;

    /**
     * @var boolean whether or not we should scroll to first error
     */
    public $scrollErrors = true;

    /**
     * @var type the offset that we should add to the scrollTop (usually some fixed element like topNav)
     */
    public $scrollErrorOffset = 130;

    /**
     * @var duration for the scrollTop (in ms)
     */
    public $scrollErrorDuration = 800;

    /**
     * @var string the javascript options passed to the form - in case someone wants to re-initialize the form
     */
    public $runOptions;

    /**
     * Rewrite the parent::run() function so that yiiactiveform is not loaded and bsform is loaded instead
     * @yiiupgrade CActiveForm::run()
     * @version 1.1.14
     */
    public function run() {

        if (is_array($this->focus))
            $this->focus = "#" . CHtml::activeId($this->focus[0], $this->focus[1]);

        echo CHtml::endForm();

        $cs = Yii::app()->clientScript;
        if (!$this->enableAjaxValidation && !$this->enableClientValidation) {
            if ($this->focus !== null) {
                $cs->registerCoreScript('jquery');
                $cs->registerScript('CActiveForm#focus', "
                    if(!window.location.hash)
                        $('" . $this->focus . "').focus();
                ");
            }
            return;
        }

        // Add the display errors method to the afterValidate clientOption
        // We shouldn't override the afterValidate function, it may be used by some developer
        if (isset($this->clientOptions['afterValidate']))
            $afterValidate = rtrim(ltrim($this->clientOptions['afterValidate'], 'js: '), ';') . '; ' . $this->_getAfterValidate();
        else
            $afterValidate = $this->_getAfterValidate();

        $this->clientOptions['afterValidate'] = 'js: function (form, data, hasError){' . $afterValidate . '}';

        // Default PPH validation style options
        if ($this->enableClientValidation || $this->enableAjaxValidation) {
            $this->clientOptions['validateOnSubmit'] = true;
            $this->clientOptions['validateOnChange'] = false;
        }

        $options = $this->clientOptions;

        if (isset($this->clientOptions['validationUrl']) && is_array($this->clientOptions['validationUrl']))
            $options['validationUrl'] = CHtml::normalizeUrl($this->clientOptions['validationUrl']);

        $options['attributes'] = array_values($this->attributes);

        if ($this->summaryID !== null)
            $options['summaryID'] = $this->summaryID;

        if ($this->focus !== null)
            $options['focus'] = $this->focus;

        $id = $this->id;

        /**
         * Auto set the options from public properties
         */
        $properties = array('errorSummarySeparator', 'pphComponentAttribute',
            'componentsDefaults', 'scrollErrors', 'scrollErrorOffset', 'scrollErrorDuration');

        foreach ($properties as $prop) {
            if (isset($this->$prop))
                $options[$prop] = $this->$prop;
        }

        $this->runOptions = CJavaScript::encode($options);
        $cs->registerScript(__CLASS__ . '#' . $id, "\$('#$id').".self::ASSOCIATED_JS_OBJECT."($this->runOptions);");
    }

    /**
     * @return string the js snippet that invokes error display on afterValidate event
     */
    private function _getAfterValidate() {
        return "return $(this).".self::ASSOCIATED_JS_OBJECT.".displayErrors(form, data, hasError);";
    }

    /**
     * The function is used to find and display the right field depending on the attribute given.
     *
     * @param object $model
     * @param string $attribute
     * @param string $htmlOptions
     * @return string the html needed to display the textfield
     */
    public function magicField($model, $attribute, $htmlOptions = array()) {
        // Check if it has options to render radio/checkbox/input
        // Check length to show textarea
        // Check if file to show uploader
        return parent::textField($model, $attribute, $htmlOptions);
    }

    /**
     * Return a tagsinput instead of a simple textfield
     *
     * @param object $model the model we are using
     * @param string $attribute the model's attribute
     * @param array $data the name=>value pairs of data we will assign to the list
     * @param array $htmlOptions the htmlOptions that are copied to the pphDropdown component
     * @return string the html to display
     */
    public function tagsInput($model, $attribute, $data, $htmlOptions = array()) {
        BsHtml::addCssClass('js-tagsinput', $htmlOptions);
        return parent::textField($model, $attribute, $htmlOptions);
    }

}