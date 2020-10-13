<?php

class Container {

    private $registry = [];
    private $instances = [];
    private $factories = [];

    public function __construct() {
        $this->queue = new SplQueue();
        $this->storage = new SplObjectStorage();
    }

    public function register($key, Callable $resolver) {
        $this->registry[$key] = $resolver; 
    }
    public function registerFactory($key, Callable $resolver) {
        $this->factories[$key] = $resolver;
    }

    public function get($key) {
        if(isset($this->factories[$key])){
            return $this->factories[$key]();
        } if(!isset($this->instances[$key])){
            if(isset($this->registry[$key])){
                $this->instances[$key] = $this->registry[$key]($this);
            } else {
                throw new Exception($key . " n'est pas dans mon conteneur.\n");
            }
        }
        return $this->instances[$key];
    }
}