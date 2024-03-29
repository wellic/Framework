<?php

namespace Framework\Validation\Filter;

/**
 * Class Length validates that the attribute value is of certain length.
 *
 * @package Framework\Validation\Filter
 * @author JuraZubach
 * @since 1.0
 */
class Length
{
    public $min;
    public $max;

    /**
     * @param $min
     * @param $max
     */
    public function __construct($min, $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * Check input box is not min or max length.
     *
     * @param $var
     * @return array|bool
     */
    public function check($var)
    {
        $length = iconv_strlen($var);
        if($length < $this->min)
            return ['error' => 'must be more than '.$this->min.' characters'];
        if($length > $this->max)
            return ['error' => 'must be less than '.$this->max.' characters'];

        return true;
    }
}