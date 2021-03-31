<?php
namespace Guestbook\Model;

class GuestbookModel
{
    protected $id, $name, $email, $message;

    public function unset($key)
    {
        if (isset(get_object_vars($this)[$key])) {
            unset($this->$key);
        }
        return $this;
    }

    public function __set($key, $value)
    {
        $this->$key = $value;
        return $this;
    }
}