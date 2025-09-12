<?php

namespace DLUnire\Models;

use Framework\Auth\UserBase;

class Users extends UserBase {

    // Descomente la siguiente línea para establecer una tabla de usuarios personalizada:
    // protected static ?string $table = 'tabla_usuario_personalizada';

    // ------------------------------------------------------------------------
    // Descomente las líneas donde desee establecer valores personalizados para 
    // la captura y almacenamiento de datos.
    // ------------------------------------------------------------------------

    // Descomente la siguiente línea para establecer un campo de usuario personalizado en el formulario:
    protected static ?string $username_field = 'users_username';

    // Descomente la siguiente línea para establecer un campo de contraseña personalizado en el formulario:
    protected static ?string $password_field = 'users_password';

    // Descomente la siguiente línea para establecer una columna de usuario personalizada en la tabla:
    protected static ?string $username_column = 'users_username';

    // Descomente la siguiente línea para establecer una columna de contraseña personalizada en la tabla:
    protected static ?string $password_column = 'users_password';

    // Descomente la siguiente línea para establecer una columna de token personalizada en la tabla:
    protected static ?string $token_column = 'token';
}
