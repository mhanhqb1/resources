<?php

/**
 * Controller_Upload
 *
 * @package Controller
 * @created 2014-11-20
 * @version 1.0
 * @author thailh
 * @copyright Oceanize INC
 */
class Controller_Upload extends \Controller_Rest
{
    /**
     * Upload image to server
     *
     * @return boolean
     */
    public function action_image()
    {
        return $this->response(\Lib\Util::uploadImage());
    }

    /**
     *  Upload video to server
     *
     * @return boolean
     */
    public function action_video()
    {
        return $this->response(\Lib\Util::uploadVideo());
    }

}
