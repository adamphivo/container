<?php

class MessageProducer {
    public function __construct(SplQueue $queue, SplObjectStorage $storage) {
        $this->queue = $queue;
        $this->storage = $storage;
    }

    public function makeMessage(string $text, string $language, int $priority) {
        $message = new Message($text, $language);
        $dateCreated = time();
        $dateLimit = time() + (24 * 60 * 60 );
        $metaData = [$dateCreated, $dateLimit, ["priority" => $priority]];

        $this->dispatchMessage($message, $metaData);
    }

    public function dispatchMessage($message,$metaData) {
        $this->queue->enqueue($message);
        $this->storage->attach($message, $metaData);
    }
}