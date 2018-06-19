<?php

namespace PedroBorges\Authenticator;

use Kirby\Panel\View as BaseView;
use Panel;

class View extends BaseView
{
    public function __construct($file, $data = [])
    {
        $pluginView = Authenticator::instance()->roots()->views() . DS . $file . '.php';

        // Default to panel views
        $this->_root = file_exists($pluginView)
            ? Authenticator::instance()->roots()->views()
            : Panel::instance()->roots()->views();
        $this->_file = $file;
        $this->_data = $data;
    }
}
