<?php

/**
 * A simple response utility.
 *
 * @author karlpatrickespiritu <https://github.com/karlpatrickespiritu>, <wiwa.espiritu@gmail.com>
 */

namespace App\Utils;

class Response
{
    private $data = null;
    private $html = null;
    private $message = null;
    private $success = false;
    private $errors = [];

    public function __construct($data = null)
    {
        if ($data !== null) {
            $this->data = $data;
        }

        return $this;
    }

    public function __toString()
    {
        return json_encode($this);
    }

    /*=== Setters ===*/
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function setHtml($html)
    {
        $this->html = $html;
        return $this;
    }

    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    public function setSuccess($status)
    {
        $this->success = (bool) $status;
        return $this;
    }

    /**
     * Add a key-value pair error.
     *
     * @param $key
     * @param null $value
     * @return $this
     */
    public function addError($key, $value = null)
    {
        if ($value === null) {
            $this->errors = $key;
        } else {
            $this->errors[$key] = $value;
        }

        if ($this->success) {
            $this->success = false;
        }

        return $this;
    }

    /**
     * Add an error using a key.
     *
     * @param $key
     * @return bool
     * @return $this
     */
    public function removeError($key)
    {
        if (!array_key_exists($key, $this->errors)) {
            return false;
        }

        unset($this->errors[$key]);

        return $this;
    }

    /*=== Getters ===*/

    public function getData()
    {
        return $this->data;
    }

    public function getHtml()
    {
        return $this->html;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getSuccess()
    {
        return $this->success;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}