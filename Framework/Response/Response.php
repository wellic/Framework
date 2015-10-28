<?php

namespace Framework\Response;

/**
 * Class Response represents an HTTP response.
 *
 * @package Framework\Response
 * @author JuraZubach
 * @since 1.0
 */
class Response implements ResponseInterface
{

    protected $headers = array();
    public $type = 'html';

    protected $content;
    protected $msg;
    public $code;

    /**
     * @param $content
     * @param string $msg
     * @param int $code
     */
    public function __construct($content, $msg = '', $code = 200){

        $this->content = $content;
        $this->msg = $msg;
        $this->code = $code;
    }


    /**
     * Sets the headers.
     *
     * @param $header
     */
    public function setHeader($header)
    {
        $this->headers[] = $header;
    }

    /**
     * Get type page, html or json.
     *
     * @param $type
     */
    public function getType($type)
    {
        $this->type = $type;
    }

    /**
     * Get content.
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get code, default = '200';
     *
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Send Response with headers and content.
     *
     * @return mixed
     */
    public function send()
    {
        $this->setHeader('HTTP/1.1 '.$this->code . ' ' . $this->msg);

        header(implode("\n", $this->headers));

        echo $this->getContent();
    }
}