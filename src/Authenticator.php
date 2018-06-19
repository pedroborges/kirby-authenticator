<?php

namespace PedroBorges\Authenticator;

use Data;
use Kirby;
use L;
use Panel;

class Authenticator
{
    protected $kirby;
    protected $panel;
    protected $roots;
    protected $site;

    protected static $instance = null;

    public function __construct($root = null)
    {
        $root = $root ? $root : dirname(__DIR__);

        $this->kirby = Kirby::instance();
        $this->panel = Panel::instance();
        $this->roots = new Roots($root);
        $this->site  = $this->kirby->site();

        $this->loadTranslation();

        static::$instance = $this;
    }

    public static function instance($root = null)
    {
        return static::$instance = is_null(static::$instance)
            ? new static($root)
            : static::$instance;
    }

    public function roots()
    {
        return $this->roots;
    }

    protected function loadTranslation()
    {
        $lang = $this->kirby->option('panel.language', 'en');
        $user = $this->site->user();
        $root = $this->roots()->translations();

        if ($user && $user->language()) {
            $lang = $user->language();
        }

        $translation = $root . DS . $lang . '.json';

        if (! is_file($translation)) {
            $translation = $root . DS . 'en.json';
        }

        L::set(Data::read($translation));
    }
}
