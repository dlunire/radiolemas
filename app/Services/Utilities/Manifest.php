<?php

declare(strict_types=1);

namespace DLUnire\Services\Utilities;

use DLStorage\Storage\SaveData;
use Framework\Abstracts\BaseController;

final class Manifest extends SaveData {
        
    /**
     * Almacesa los datos de la aplicación en formato binario
     * 
     * @return boolean
     */
    public function save(BaseController $controller): bool {
        
        // $background = $controller->

        /**
         * Manifest de Progresive Web Application
         * 
         * @var array<string, string|array<int, array<string,string>> $manifest
         */
        $manifest = [
            'name' => 'Radio Emisora - Plataforma',
            'short_name' => 'RadioApp',
            'start_url' => '/?source=pwa',
            'display' => 'standalone',
            'background_color' => '#ffffff',
            'theme_color' => '#000000',
            'orientation' => 'portrait',
            'icons' => [
                [
                    'src' => '/icons/icon-192.png',
                    'sizes' => '192x192',
                    'type' => 'image/png',
                ],
                [
                    'src' => '/icons/icon-512.png',
                    'sizes' => '512x512',
                    'type' => 'image/png',
                ],
            ],
        ];

        return false;
    }
    
}