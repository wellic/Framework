<?php

namespace Framework\Validation;

use Framework\Model\ActiveRecord;
use Framework\Exception\ValidationException;

/**
 * Class Validator
 * @package Framework\Validation
 * @author JuraZubach
 * @since 1.0
 */
class Validator
{
    protected $errors = NULL;
    protected $rules;
    protected $objVars;


    /**
     * Check if $post instanceof ActiveRecord object.
     *
     * @param $post
     */
    public function __construct($post)
    {
        try
        {
            if($post instanceof ActiveRecord)
            {
                $this->rules = $post->getRules();
                $this->objVars = get_object_vars($post);
            }
            else {
                throw new ValidationException($post.' - is not instance of ActiveRecord');
            }
        } catch(ValidationException $e)
        {
            echo 'ERROR - '.$e->getMessage();
        }
    }

    /**
     * Check the data for rules using filters.
     *
     * @return bool
     */
    public function isValid()
    {
        foreach($this->rules as $name => $filters)
        {
            foreach($filters as $filter)
            {
                $result = $filter->check($this->objVars[$name]);
                if(is_array($result))
                {
                    $this->errors[$name] = 'Error, '.$name.' '.$result['error'];
                }
            }
        }

        return ($this->errors == NULL);

    }

    /**
     * Get the errors, found in validation.
     *
     * @return null
     */
    public function getErrors()
    {
        return $this->errors;
    }
}