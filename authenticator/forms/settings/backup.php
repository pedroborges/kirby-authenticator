<?php

return function ($user, $backup) {
    $form = new Kirby\Panel\Form([
        'intro' => [
            'label'    => 'authenticator.backup.label',
            'type'     => 'info',
            'text'     => 'authenticator.backup.text'
        ],
        'backup' => [
            'type'        => 'text',
            'icon'        => 'shield',
            'readonly'    => true
        ],
        'note' => [
            'type'     => 'info',
            'text'     => 'authenticator.backup.note'
        ],
    ], [
        'backup' => $backup
    ]);

    $form->cancel('users/' . $user->username . '/edit');

    $form->buttons->submit->addClass('btn-positive');
    $form->buttons->submit->value = l('save');
    $form->buttons->cancel->html = l('authenticator.backup.cancel');

    return $form;
};
