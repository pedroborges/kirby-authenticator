<?php

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class QRCodeField extends BaseField
{
    public static $assets = [
        'css' => [
            'qrcode.css'
        ]
    ];

    public function result()
    {
        return null;
    }

    public function element()
    {
        $element = parent::element();
        $element->addClass('field-with-icon');

        return $element;
    }

    public function qrcode()
    {
        if (! $this->code()) {
            return;
        }

        $size = $this->size() ? $this->size() : 200;

        $renderer = new ImageRenderer(
            new RendererStyle($size),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);

        return $writer->writeString($this->code());
    }

    public function image()
    {
        if (! $this->code()) {
            return;
        }

        $image = new Brick('div');
        $image->addClass('qrcode');
        $image->append($this->qrcode());

        return $image;
    }

    public function input()
    {
        $wrapper = new Brick('div');
        $wrapper->addClass('text');
        $wrapper->append(kirbytext($this->i18n($this->text())));
        $wrapper->append($this->image());

        return $wrapper;
    }
}
