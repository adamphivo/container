<?php

class MessageReader {
    public function __construct(SplQueue $queue, SplObjectStorage $storage) {
        $this->queue = $queue;
        $this->storage = $storage;
        $this->badWords = ["sacrebleu","mince","zut"];
    }

    public function treatTopMessage() {
        $this->queue->rewind();

        if($this->isMessageStored()  && $this->isMessageDateValid() &&
           $this->isMessageContentValid()) {
            echo $this->queue->current()->text."\n";
            echo $this->queue->current()->language."\n";
        } else {
            echo "Message non valide";
        }

        $this->storage->detach($this->queue->current());
        $this->queue->dequeue();
    }

    public function isMessageStored() {
        return $this->storage->contains($this->queue->current());
    }

    public function isMessageDateValid() {
        $info = $this->storage->getInfo();
        return $info[1] > time() ? true : false; 
    }

    public function isMessageContentValid() {
        foreach($this->badWords as $badWord) {
            if(strpos($this->queue->current()->text, $badWord) !== false) {
                return false;
            } else {
                continue;
            }
        }
        return true;
    }
}