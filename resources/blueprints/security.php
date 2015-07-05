<?php

use Carbon\Carbon;
use OxygenModule\Auth\Controller\AuthController;
use Oxygen\Core\Action\Factory\ActionFactory;
use Oxygen\Core\Action\Group;
use Oxygen\Core\Contracts\CoreConfiguration;

use Oxygen\Core\Html\Dialog\Dialog;
use OxygenModule\Security\Controller\SecurityController;

Blueprint::make('Security', function($blueprint) {
    $blueprint->setController(SecurityController::class);
    $blueprint->setDisplayName('Security', Blueprint::SINGULAR);
    $blueprint->setDisplayName('Security', Blueprint::PLURAL);
    $blueprint->setIcon('lock');

    $blueprint->setDefaultToolbarItem('getList');

    $blueprint->makeAction([
        'name'        => 'getList',
        'pattern'     => '/'
    ]);
    $blueprint->makeToolbarItem([
        'action'    => 'getList',
        'label'     => 'Utilities',
        'icon'      => 'database',
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