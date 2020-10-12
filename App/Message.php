<?php

class Message {
    public function __construct($text, $language) {
        $this->text = $text;
        $this->language = $language;
    }
}