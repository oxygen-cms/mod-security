<?php

use OxygenModule\Security\Controller\SecurityController;

Blueprint::make('Security', function($blueprint) {
    $blueprint->setController(SecurityController::class);
    $blueprint->setBothDisplayNames('Security');
    $blueprint->setIcon('lock');

    $blueprint->setPrimaryToolbarItem('getList');

    $blueprint->makeAction([
        'name'        => 'getList',
        'pattern'     => '/'
    ]);
    $blueprint->makeToolbarItem([
        'action'    => 'getList',
        'label'     => 'Security',
        'icon'      => 'lock',
        'color'     => 'white'
    ]);

    $blueprint->makeAction([
        'name'        => 'getLoginLog',
        'pattern'     => 'loginLog'
    ]);
    $blueprint->makeToolbarItem([
        'action'    => 'getLoginLog',
        'label'     => 'View Login Log',
        'icon'      => 'lock',
        'color'     => 'blue'
    ]);

    $blueprint->makeAction([
        'name'        => 'postLoginLocation',
        'pattern'     => 'loginLocation/{id}',
        'method'      => 'POST'
    ]);
    $blueprint->makeToolbarItem([
        'action'    => 'postLoginLocation',
        'label'     => 'Get Location',
        'icon'      => 'location-arrow'
    ]);
});