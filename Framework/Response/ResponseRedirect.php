<?php


namespace Framework\Response;

use Framework\DI\Service;

/**
 * Class ResponseRedirect
 *
 * @package Framework\Response
 * @author JuraZubach
 * @since 1.0
 */
class ResponseRedirect extends Response
{
    public $code;
    public $url;
    public $replace;

    /**
     * @param $url
     * @param bool|true $replace
     * @param int $code
     */
    public function __construct($url, $replace = true, $code = 307)
    {
        $this->url = $url;
        $this->replace = $replace;
        $this->code = $code;
    }

    /**
     * Redirects user to specified url.
     */
    public function send()
    {
        $request = Service::get('request');
        header('Referer: '.$request->getUri());
        header('Location: '.$this->url, $this->replace, $this->code);
        exit();
    }
}