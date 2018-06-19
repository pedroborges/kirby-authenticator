<?php

class AuthenticatorField extends BaseField
{
    public static $assets = [
        'css' => [
            'authenticator.css'
        ]
    ];

    public function isOn()
    {
        return 16 === strlen($this->model()->authenticatorsecret);
    }

    public function label()
    {
        $status = $this->isOn()
            ? '<span>' . l('authenticator.field.status.on') . '</span>'
            : '<span>' . l('authenticator.field.status.off') . '</span>';

        $label = new Brick('label', l('authenticator.field.label', compact('status')));
        $label->addClass('label');

        return $label;
    }

    public function help()
    {
        $text = $this->isOn()
            ? l('authenticator.field.info.on')
            : l('authenticator.field.info.off');

        $help = new Brick('div', $text);
        $help->addClass('field-help marginalia text');

        return $help;
    }

    public function content()
    {
        if (! $this->canEdit()) {
            return null;
        }

        $username = $this->model()->username;

        $action = $this->isOn() ? 'off' : 'on';
        $icon   = $this->isOn() ? 'fa-toggle-off' : 'fa-toggle-on';
        $text   = $this->isOn() ? l('authenticator.toggle.off') : l('authenticator.toggle.on');

        $button = new Brick('a');
        $button->addClass('label-option');
        $button->data('modal', true);
        $button->attr('href', purl('users/' . $username . '/two-steps/' . $action));
        $button->html('<i class="icon icon-left fa ' . $icon . '"></i>' . $text);

        return $button;
    }

    public function element()
    {
        $status = $this->isOn()
            ? 'two-steps--on'
            : 'two-steps--off';

        return parent::element()->addClass($status);
    }

    protected function canEdit()
    {
        // TODO: allow admin to enable/disable two-step login for other users
        // return $this->model()->username == site()->user() || site()->user()->isAdmin();
        return $this->model()->username == site()->user();
    }
}
