<?php

namespace Application\Model;

class Text
{

    // from the texts table
    public $key;
    public $text;
    // from languages table
    public $language;

    public function exchangeArray($data)
    {
        $this->key = (isset($data['key'])) ? $data['key'] : null;
        $this->text = (isset($data['text'])) ? $data['text'] : null;
        $this->language = (isset($data['language'])) ? $data['language'] : null;
    }

    public function toArray()
    {
        return array(
            'key' => $this->key,
            'text' => $this->text,
            'language' => $this->language,
        );
    }

}
