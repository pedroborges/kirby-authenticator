<?php

namespace PedroBorges\Authenticator;

use Obj;

class Roots extends Obj
{
    public $root;

    public function __construct($root = null)
    {
        $this->root         = $root ? $root : dirname(__DIR__);

        $this->index        = $this->root . DS . 'authenticator';

        $this->blueprints   = $this->index . DS . 'blueprints';
        $this->fields       = $this->index . DS . 'fields';
        $this->forms        = $this->index . DS . 'forms';
        $this->translations = $this->index . DS . 'translations';
        $this->views        = $this->index . DS . 'views';
    }
}
