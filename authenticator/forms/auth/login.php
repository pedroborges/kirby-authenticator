<?php

return function () {
    $form = new Kirby\Panel\Form([
        'username' => [
            'label'       => 'login.username.label',
            'type'        => 'text',
            'icon'        => 'user',
            'required'    => true,
            'autofocus'   => true,
            'default'     => s::get('kirby_panel_username')
        ],
        'password' => [
            'label'       => 'login.password.label',
            'type'        => 'password',
            'required'    => true
        ],
        'security_code' => [
            'label'       => 'authenticator.securityCode.label',
            'type'        => 'number',
            'icon'        => 'shield',
            'placeholder' => null,
            'min'         => 1,
            'max'         => 999999,
            'help'        => 'authenticator.securityCode.help'
        ]
    ]);

    $form->attr('autocomplete', 'off');
    $form->data('autosubmit', 'native');
    $form->style('centered');

    $form->buttons->submit->value = l('login.button');

    return $form;
};
