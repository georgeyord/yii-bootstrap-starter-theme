(function ($){

    /**
     * $.fn.bsform plugin is actually yiiactiveform but with extra methods.
     * We copy yiiactiveform into bsform and we add the extra methods later.
     */
    $.fn.bsform = function (options){
        // Init the pphComponents
        var $form = $(this);

        // Extend yiiactiveform's default component options with the ones we set
        $.extend($.fn.bsform.options, $.fn.yiiactiveform.defaults, $.fn.bsform.defaults, options);

        // Apply yiiactiveform
        return this.each(function (){
            $(this).yiiactiveform(options);
            _initComponents($form, $.fn.bsform.components, options);
        });
    };

    // the default options
    $.fn.bsform.defaults = {
        errorSummarySeparator: '\n',
        // default options for the components
        componentsDefaults: {
            autoresize: {
                // On resize:
                onResize : function() {
                    // trigger window resize
                    $(window).trigger('resize');
                },
                // After resize:
                animateCallback : function() {
                    $(window).trigger('resize');
                }
            }
        }
    };

    // The final options object
    $.fn.bsform.options = {};

    /**
     * This method is called on afterValidate. We use this method so we display the errors as tooltips
     */
    $.fn.bsform.displayErrors = function (form, data, hasError){
        var $form = $(form), options = $.fn.bsform.options;

        // Go through all the fields that contain an error
        var errors = 0;
        for (var field in data) {
            var input = $('#'+field, $form).length ? $('#'+field, $form) : $('[data-id="'+field+'"]', $form), message = _summarizeErrors(data[field], $.fn.bsform.options.errorSummarySeparator);
            var selector = input;
            if (input.is(':hidden'))
                selector = input.closest(':visible');

            // Display the error tooltip
//            PPH.dom.error(selector, message, tipOptions);
            errors++;

            // the css classes that should be removed on focus
            var obsoleteClasses =  options.validatingCssClass+' '+options.errorCssClass+' '+options.successCssClass;

            // Register
            $(selector).one('mouseup focus', function (e){
                var $this = $(this),
                    $container = $(this, $form).parents('.'+options.errorCssClass+':first');

                $this.removeClass(obsoleteClasses);
                $container.removeClass(obsoleteClasses);

                /*
                 * if the developer used "echo $form->error() instead of just "$form->error"
                 * we should select the error element and clean the message
                 */
                var $error = $form.find('#' + this.errorID);
                if ($error.length)
                    $error.html('').hide();

            });

        }

        // Errors are represented by tooltips so the first element
        // that contains a tooltip should be our first error
//        var firstError = $('['+options.qtipDescriptor+']:first');
//
//        if (errors && firstError.length && options.scrollErrors) {
//            var top = firstError.offset().top - options.scrollErrorOffset;
//            $('html, body').animate({scrollTop : top}, options.scrollErrorDuration);
//        }
        // for some reason hasError is undefined when performing ajax validation
        return errors==0;
    };

    /**
     * PPH Components initialization functions
     */
    $.fn.bsform.components = {
        autoresize: function (){
            $(this.element).autoResize(this.options);
        },
    };

    /// PRIVATE FUNCTIONS

    // Initializes the components needed for the display
    var _initComponents = function (form, components, options){
        if (typeof form == 'string')
            form = $(form);
    };

    /**
     * Summarize the errors into a printable error summary
     */
    var _summarizeErrors = function (array, separator) {
        var str = '';
        $.each(array, function (index, message){
            str += message + separator;
        });
        return str;
    };
})(jQuery);