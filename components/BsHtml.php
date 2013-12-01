<?php

/**
 * BsHtml is an extention of static class CHtml and provides a collection of helper
 * methods for creating HTML views for Bootstrap 3.
 * It includes also some helpers function for adding/removing values in htmlOptions
 * of the element.
 */
class BsHtml extends CHtml {
    // Awesome icons base classes
    const ICON_CLASS = 'fa';
    const ICON_FA_PREFIX = 'fa-';

    /**
     * Display a link that on hover it opens up a help tooltip
     *
     *  - No extra options are passed through the js
     *
     * @param string $helpMessage the help message inside the tooltip
     * @param string $content the link's text, leave empty to display only an icon
     * @param array $htmlOptions the htmlOptions for the link
     * @param string $icon the icon that should be used (css class)
     * @return string the html required
     */
    public static function help($title, $content, $label = '', $htmlOptions = array(), $icon = '-question-sign color-info') {
        // Generate a unique id for the content
        $contentId = 'help-content-' . uniqid();

        // Merge htmlOptions with the default
        self::addCssClass('popover-toggle', $htmlOptions);
        self::defaultArrayValues(array(
            'data-trigger' => 'hover',
            'data-class' => 'info',
            'data-placement' => "left",
            'data-content-selector' => "#$contentId",
            'title' => empty($title) ? null : $title,
                ), $htmlOptions);

        // Append the icon to the content
        if ($icon !== false)
            $label .= self::icon('question-sign ', self::COLOR_INFO);

        $label .= CHtml::tag('div', array(
                    'style' => 'display: none !important;',
                    'id' => $contentId,
                        ), $content);

        return CHtml::tag('span', $htmlOptions, $label);
    }

    /**
     * Render a icon inside an i element
     * @param string $icon
     * @param mixed $htmlOptions
     *      if array will be used as htmloptions for i element, special attribute 'content' will be the content of the element
     *      else if string will be used as class in htmloptions
     * @param string $prefix
     * @return string the html required
     */
    public static function icon($icon, $htmlOptions = array(), $prefix = self::ICON_FA_PREFIX) {
        if (is_string($htmlOptions))
            $htmlOptions = array('class' => $htmlOptions);
        $content = self::popArrayValue('content', $htmlOptions, '');
        self::addCssClass(array(static::ICON_CLASS, $prefix . $icon), $htmlOptions);
        return CHtml::tag('i', $htmlOptions, $content);
    }

    /**
     * HELPER FUNCTIONS FOR ARRAYS
     * ---------------------------
     */

    /**
     * HELPER FUNCTION
     * Returns a specific value from the given array (or the default value if not set).
     * @param string $key the item key.
     * @param array $array the array to get from.
     * @param mixed $defaultValue the default value.
     * @return mixed the value.
     */
    public static function getArrayValue($key, array $array, $defaultValue = null) {
        return isset($array[$key]) ? $array[$key] : $defaultValue;
    }

    /**
     * HELPER FUNCTION
     * Removes and returns a specific value from the given array (or the default value if not set).
     * @param string $key the item key.
     * @param array $array the array to pop the item from.
     * @param mixed $defaultValue the default value.
     * @return mixed the value.
     */
    public static function popArrayValue($key, array &$array, $defaultValue = null) {
        $value = self::getArrayValue($key, $array, $defaultValue);
        unset($array[$key]);
        return $value;
    }

    /**
     * HELPER FUNCTION
     * Sets the default value for a specific key in the given array.
     * @param string $key the item key.
     * @param mixed $value the default value.
     * @param array $array the array.
     */
    public static function defaultArrayValue($key, $value, array &$array) {
        if (!isset($array[$key]) && $value !== null) {
            $array[$key] = $value;
        }
    }

    /**
     * HELPER FUNCTION
     * Sets a set of default values for the given array.
     * @param array $array the array to set values for.
     * @param array $values the default values.
     */
    public static function defaultArrayValues(array $values, array &$array) {
        foreach ($values as $name => $value) {
            self::defaultArrayValue($name, $value, $array);
        }
    }

    /**
     * HELPER FUNCTIONS FOR HTML OPTIONS
     * ---------------------------------
     */

    /**
     * Appends new class names to the given options.
     * @param mixed $className the class(es) to append.
     * @param array $htmlOptions the options.
     * @return array the options.
     */
    public static function addCssClass($className, &$htmlOptions) {
        // Always operate on arrays
        if (is_string($className)) {
            $className = explode(' ', $className);
        }
        if (isset($htmlOptions['class'])) {
            $classes = array_filter(explode(' ', $htmlOptions['class']));
            foreach ($className as $class) {
                $class = trim($class);
                // Don't add the class if it already exists
                if (array_search($class, $classes) === false) {
                    $classes[] = $class;
                }
            }
            $className = $classes;
        }
        $htmlOptions['class'] = implode(' ', $className);
    }

    /**
     * Appends a CSS style string to the given options.
     * @param string $style the CSS style string.
     * @param array $htmlOptions the options.
     * @return array the options.
     */
    public static function addCssStyle($style, &$htmlOptions) {
        if (is_array($style)) {
            $style = implode('; ', $style);
        }
        $style = rtrim($style, ';');
        $htmlOptions['style'] = isset($htmlOptions['style']) ? rtrim($htmlOptions['style'], ';') . '; ' . $style : $style;
    }

}

?>
