<?php

namespace Blog\Model;

use Framework\Model\ActiveRecord;
use Framework\Validation\Filter\Length;
use Framework\Validation\Filter\NotBlank;

/**
 * Class Post
 * @package Blog\Model
 * @author JuraZubach
 * @since 1.0
 */
class Post extends ActiveRecord
{
    public $id;
    public $title;
    public $content;
    public $date;

    public static function getTable()
    {
        return 'posts';
    }

    public function getRules()
    {
        return array(
            'title'   => array(
                new NotBlank(),
                new Length(4, 100)
            ),
            'content' => array(new NotBlank())
        );
    }
}