<?php

declare(strict_types=1);

namespace DLUnire\Controllers\SocialMedia;

use DLCore\Core\BaseController;
use DLUnire\Services\Utilities\ConfigStorage;

/**
 * Controla el almacenamiento o eliminación de las redes sociales
 * 
 * @package DLUnire\Controlleres\SocialMedia
 * @author David E Luna M <dlunireframework@gmail.com>
 * @copyright 2025 David E Luna M
 * @license Comercial
 */
final class SocialMediaController extends BaseController {

    /**
     * Almacena las redes sociales con las que se tengan cuenta registrada
     *
     * @return array
     */
    public function store(): array {

        /** @var string|null $pinterest */
        $pinterest = $this->get_input('pinterest');

        /** @var string|null $x */
        $x = $this->get_input('x');

        /** @var string|null $facebook */
        $facebook = $this->get_input('facebook');

        /** @var string|null $tiktok */
        $tiktok = $this->get_input('tiktok');

        /** @var string|null $instagram */
        $instagram = $this->get_input('instagram');

        /** @var string|null $youtube */
        $youtube = $this->get_input('youtube');

        /** @var string|null $threads */
        $threads = $this->get_input('threads');

        /** @var string|null $patreon */
        $patreon = $this->get_input('patreon');

        /** @var ConfigStorage $data */
        $data = new ConfigStorage();

        $data->save(filename: '/socialmedia/socialmedia', data: [
            "pinterest" => $pinterest,
            "x" => $x,
            "facebook" => $facebook,
            "tiktok" => $tiktok,
            "instagram" => $instagram,
            "youtube" => $youtube,
            "threads" => $threads,
            "patreon" => $patreon
        ]);

        http_response_code(201);
        return [
            "status" => true,
            "success" => ""
        ];
    }

}