<?php

namespace Framework\Response;

/**
 * Class ResponseJson represents an HTTP response in JSON format.
 *
 * @package Framework\Response
 * @author JuraZubach
 * @since 1.0
 */
class ResponseJson extends Response
{
    protected $headers = array('Content-Type: application/json');
    public $type = 'json';

    /**
     * Send Response with headers and json - content.
     */
    public function send()
    {
        $this->setHeader('HTTP/1.1 '.$this->code . ' ' . $this->msg);

        echo json_encode($this->getContent());
    }
}