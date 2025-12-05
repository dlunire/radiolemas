<?php

namespace DLUnire\Controllers\Contacts;

use Framework\Abstracts\BaseController;

/**
 * Maneja la entrada del usuario por medio del protocolo HTTP
 * 
 * @package DLUnire\Controllers\Contacts
 * 
 * @author David E Luna M <dlunireframework@gmail.com>
 * @copyright (c) 2025 - David E Luna M
 */
final class ContactController extends BaseController {

    /**
     * Recibe los datos del formulario
     *
     * @return array
     */
    public function store(): array {

        /** @var string $name */
        $name = $this->get_required('names');

        /** @var string $email */
        $email = $this->get_email('email');

        /** @var string $subject */
        $subject = $this->get_required('subject');

        /** @var string $content */
        $content = $this->get_string('emasubjectil');

        /**
         * Datos del formulario
         * 
         * @var array{
         *      names: non-empty-string,
         *      email: non-empty-string,
         *      subject: non-empty-string,
         *      content: non-empty-string
         * }
         */
        $data = [
            "names" => $name,
            "email" => $email,
            "subject" => $subject,
            "content" => $content
        ];

        /**
         * **NOTA IMPORTANTE:**
         * 
         * Se require una tabla que reciba el contacto de los usuarios, por lo tanto, el 
         * mensaje que actualmente reciben es una simulación.
         */

        http_response_code(201);
        return [
            "status" => true,
            "success" => "Gracias por escribirnos.\nLo atenderemos tan pronto como sea posible",
            "data" => $data
        ];
    }
}