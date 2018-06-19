<?php

return function ($key, $url) {
    $form = new Kirby\Panel\Form([
        'intro' => [
            'label'    => 'authenticator.turnOn.label',
            'type'     => 'info',
            'text'     => l('authenticator.turnOn.text', [
                'ios'     => '<a href="https://itunes.apple.com/us/app/google-authenticator/id388497605?mt=8" target="_blank">iOS</a>',
                'android' => '<a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" target="_blank">Android</a>',
                'windows' => '<a href="https://www.microsoft.com/p/microsoft-authenticator/9nblgggzmcj6" target="_blank">Windows Mobile</a>'
            ])
        ],
        'qrcode' => [
            'label'    => 'authenticator.turnOn.qrcode.label',
            'type'     => 'qrcode',
            'text'     => 'authenticator.turnOn.qrcode.text',
            'code'     => $url,
            'size'     => 150
        ],
        // TODO: Require security code confirmation
        // 'security_code' => [
        //     'label'       => 'authenticator.securityCode.label',
        //     'type'        => 'number',
        //     'icon'        => 'shield',
        //     'placeholder' => null,
        //     'min'         => 1,
        //     'max'         => 999999,
        //     'help'        => 'authenticator.securityCode.label',
        //     'required'    => true,
        //     'autofocus'   => true
        // ]
    ]);

    $form->buttons->submit->addClass('btn-positive');
    $form->buttons->submit->value = l('authenticator.toggle.on');

    return $form;
};
