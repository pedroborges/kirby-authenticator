<?php

return function () {
    $form = new Kirby\Panel\Form([
        'intro' => [
            'label'    => 'authenticator.turnOff.label',
            'type'     => 'info',
            'text'     => 'authenticator.turnOff.text'
        ],
        'security_code' => [
            'label'       => 'authenticator.turnOff.securityCode.label',
            'type'        => 'number',
            'icon'        => 'shield',
            'placeholder' => null,
            'min'         => 1,
            'max'         => 999999,
            'help'        => 'authenticator.securityCode.help',
            'required'    => true,
            'autofocus'   => true
        ]
    ]);

    $form->attr('autocomplete', 'off');
    $form->data('autosubmit', 'native');

    $form->buttons->submit->addClass('btn-negative');
    $form->buttons->submit->value = l('authenticator.toggle.off');

    return $form;
};
