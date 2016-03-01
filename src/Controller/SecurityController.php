<?php

namespace OxygenModule\Security\Controller;

use App;
use Artisan;
use Config;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use OxygenModule\Security\Repository\LoginLogRepositoryInterface;
use View;
use Lang;
use Response;

use Symfony\Component\Console\Output\BufferedOutput;
use Oxygen\Core\Blueprint\BlueprintManager;
use Oxygen\Core\Http\Notification;
use Oxygen\Core\Controller\BlueprintController;
use ZipArchive;

class SecurityController extends BlueprintController {

    /**
     * Constructs the AuthController.
     *
     * @param BlueprintManager        $manager
     */
    public function __construct(BlueprintManager $manager) {
        parent::__construct($manager->get('Security'));
    }

    /**
     * Shows the update form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList() {
        return View::make('oxygen/mod-security::list', [
            'title' => Lang::get('oxygen/mod-security::ui.title')
        ]);
    }

    /**
     * Views the login log.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLoginLog() {
        $repository = App::make(LoginLogRepositoryInterface::class);

        return View::make('oxygen/mod-security::loginLog', [
            'log' => $repository->all(),
            'title' => Lang::get('oxygen/mod-security::ui.loginLog.title')
        ]);
    }

    /**
     * Returns the location for the given login.
     *
     * @return \Illuminate\Http\Response
     */
    public function postLoginLocation($id) {
        $repository = App::make(LoginLogRepositoryInterface::class);
        $item = $repository->find($id);

        $client = new Client();
        try {
            $data = $client->get(
                'https://freegeoip.net/json/' . $item->getIpAddress()
            )->json();
        } catch(RequestException $e) {
            return Response::notification(new Notification(
                Lang::get('oxygen/mod-security::messages.loginLog.geolocationServerConnectionError'),
                Notification::FAILED
            ));
        }

        if(!isset($data['country_name']) || !isset($data['region_name']) || !isset($data['city'])) {
            return Response::notification(new Notification(
                Lang::get('oxygen/mod-security::messages.loginLog.loginLocationFailed'),
                Notification::FAILED
            ));
        } else {
            return Response::notification(new Notification(
                Lang::get(
                    'oxygen/mod-security::messages.loginLog.loginLocation',
                    ['country' => $data['country_name'], 'region' => $data['region_name'], 'city' => $data['city']]
                )
            ));
        }
    }

}