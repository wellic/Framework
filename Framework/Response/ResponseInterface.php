<?php

namespace Framework\Response;

/**
 * Interface Response.
 *
 * @package Framework\Response
 * @author JuraZubach
 * @since 1.0
 */
interface ResponseInterface
{

    /**
     * Sets the headers.
     *
     * @param $header
     */
    public function setHeader($header);

    /**
     * Get content.
     *
     * @return mixed
     */
    public function getContent();

    /**
     * Get code, default = '200';
     *
     * @return int
     */
    public function getCode();

    /**
     * Send Response with headers and content.
     *
     * @return mixed
     */
    public function send();
}