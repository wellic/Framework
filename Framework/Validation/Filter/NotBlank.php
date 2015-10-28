<?php

namespace Framework\Validation\Filter;

/**
 * Class NotBlank validates that the attribute value is not empty.
 *
 * @package Framework\Validation\Filter
 * @author JuraZubach
 * @since 1.0
 */
class NotBlank
{
    /**
     * Check input box is not blank.
     *
     * @param $var
     * @return array|bool
     */
    public function check($var)
    {
        return (iconv_strlen($var) == 0) ? ['error' => 'must be not blank'] : true;
    }
}