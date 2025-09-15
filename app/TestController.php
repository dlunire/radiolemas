<?php

declare(strict_types=1);

namespace DLUnire\Controllers;

use DLRoute\Server\DLServer;
use Framework\Abstracts\BaseController;

final class TestController extends BaseController {

    public function ip(): array {

        return [
            "IP" => DLServer::get_ipaddress()
        ];
    }
}