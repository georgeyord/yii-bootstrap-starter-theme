
/**
 * Main scripts
 */
$(function() {

    // do things here
    // note that you have access to baseUrl
    var loginUrl = baseUrl + "/user/login";

    // Bind Offcanvas toggle
    $('body').on('click', '.offcanvas-toggle', function() {
        $('.offcanvas').toggleClass('offcanvas-active');
    });

    // Bind tooltips on hover
    $('body').on('mouseover click focus', '.js-tooltip', function(e) {
        var $this = $(this);
        // Check that the popover is not already initialized
        if (!$this.data('bs.tooltip')) {
            var options = {};

            // Set additional popover class if needed
            if ($this.data('class')) {
                var dataClass = $this.data('class');
                var arrow = true;
                // Depending on the additional/target classes show or hide the arrow
                arrow = (dataClass.indexOf('no-tip') == -1);
                // Build the template
                options.template = '<div class="tooltip ' + $this.data('class') + '">' + (arrow ? '<div class="tooltip-arrow"></div>' : '') + '<div class="tooltip-inner"></div></div>';
            }

            // Get content from another  if needed
            if ($this.data('contentSelector')) {
                options.html = true;
                options.title = $($this.data('contentSelector')).html();
            }

            $this.tooltip(options);
            if (!$this.data('trigger') || $this.data('trigger').indexOf('mouseover') > -1)
                $this.tooltip('show');
        }
    });

    // Bind on-top popovers
    $('body').on('mouseover click focus', '.js-popover', function(e) {
        var $this = $(this);
        // Check that the popover is not already initialized
        if (!$this.data('bs.popover')) {
            var options = {};

            // Set additional popover class if needed
            if ($this.data('class')) {
                var dataClass = $this.data('class');
                var arrow = true;
                // Depending on the additional/target classes show or hide the arrow
                $.each(['on-top', 'no-tip'], function(i, v) {
                    if (dataClass.indexOf(v) > -1 || $this.attr('class').indexOf(v) > -1)
                        arrow = false;
                });
                // Build the template
                options.template = '<div class="popover ' + $this.data('class') + '">' + (arrow ? '<div class="arrow"></div>' : '') + '<div class="popover-inner"><h1 class="popover-title"></h1><div class="popover-content"><p></p></div></div></div>';
            }

            // Get content from another  if needed
            if ($this.data('contentSelector')) {
                options.html = true;
                options.content = $($this.data('contentSelector')).html();
            }

            // Check if the Popover should show exactly on top of trigger element
            if ($this.hasClass('on-top')) {
                if (!$this.attr('id'))
                    throw new Error('Element must have id attribute');
                // Render popover inside the target element to position it with css rules
                options.container = '#' + $this.attr('id');
                $this.css({position: 'relative'});
            }
            $this.popover(options);
            if ($this.data('trigger') && $this.data('trigger').indexOf('mouseover') > -1)
                $this.popover('show');
        }
    });

    // Bind on-top popovers
    $('body').on('hover click focus', '.js-modal', function(e) {
        var $this = $(this);
        // Check that the popover is not already initialized
        if (!$this.data('bs.popover')) {
            var options = {backdrop: true};

            // Set additional popover class if needed
//            if ($this.data('class')) {
//                var dataClass = $this.data('class');
//                // Build the template
//                options.template = '<div class="popover ' + $this.data('class') + '">' + (arrow ? '<div class="arrow"></div>' : '') + '<div class="popover-inner"><h1 class="popover-title"></h1><div class="popover-content"><p></p></div></div></div>';
//            }

            if ($this.data('remote'))
                options.messgage = $.get($this.data('remote'));
            $this.bootbox(options);
        }
    });

    // Bind tagsinput form fields
    if ($.fn.tagsinput) {
        $.each($('.js-tagsinput'), function(kb, vb) {
            var $this = $(vb);
            // Check that the popover is not already initialized
            if (!$this.data('bs.tagsinput')) {
                var options = {
                    confirmKeys: [
                        13, // enter
                        9, // tab
                        188 // comma
                    ]
                };

                // Set additional classes if needed
                if ($this.data('class'))
                    options.tagClass = $this.data('class');

                // Set max tags limit if needed
                if ($this.data('maxTags'))
                    options.maxTags = $this.data('maxTags');

                // Set typeahead endpoint and activate typeahead if needed
                if ($this.data('typeaheadSource') || $this.data('typeaheadLocal') || $this.data('typeaheadRemote')  && typeof options.typeahead != 'object')
                        options.typeahead = {};
                if ($this.data('typeaheadSource')) {
                    if (typeof $this.data('typeaheadSource') == 'object')
                        options.typeahead.source = $this.data('typeaheadSource');
                    else
                        options.typeahead.source = function(query) {
                            return $.getJSON($this.data('typeaheadSource'), query);
                        };
                }
                if (typeof $this.data('typeaheadLocal') == 'object')
                        options.typeahead.local = $this.data('typeaheadLocal');
                if (typeof $this.data('typeaheadRemote'))
                    options.typeahead.remote = $this.data('typeaheadRemote');

                if (options.typeahead)
                    options.typeahead.freeInput = ($this.data('typeaheadFreeInput') == true ? true : false);

                $this.tagsinput(options);
            }
        });
    }

    // Toggle multiline crop on/off
    $('body').on('click', '.js-toggle-class', function() {
        var trigger = $(this);
        var target = trigger.data('selector') ? trigger.parents(trigger.data('selector')) : trigger;
        if (trigger.data('class')) {
            target.toggleClass(trigger.data('class'));
        }
    });
});