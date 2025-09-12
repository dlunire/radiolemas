<section class="help">
    <h3 class="help__title">
        🗂️ Panel de configuración de credenciales de base de datos
    </h3>

    <p>
        Este formulario está diseñado para recopilar los parámetros necesarios
        para establecer una conexión con un sistema gestor de bases de datos
        (SGBD). A través de esta interfaz, el usuario puede configurar
        credenciales de acceso, opciones de codificación, y el tiempo de vida de
        la sesión, asegurando una integración adecuada con motores como MySQL,
        PostgreSQL, SQLite o MariaDB.
    </p>

    <h4 class="help__subtitle">
        <span>Campos disponibles:</span>
    </h4>

    <ul class="help__list">
        <li class="help__item">
            <strong>Seleccione una opción:</strong> Lista desplegable que
            permite indicar el entorno de ejecución del proyecto. Ejemplos
            disponibles:
            <code>Producción</code> o <code>Entorno de desarrollo</code>.
        </li>

        <li class="help__item">
            <strong>Contraseña de la BD:</strong> Campo de entrada enmascarada que
            permite ingresar la contraseña del usuario con permisos sobre la base
            de datos.
        </li>
        <li class="help__item">
            <strong>Tiempo de vida:</strong> Define la duración de la sesión o
            token en segundos. El valor por defecto es <code>3600</code>,
            equivalente a 1 hora.
        </li>
        <li class="help__item">
            <strong>Nombre del host:</strong> Dirección del servidor de base de
            datos, puede ser <code>localhost</code> o una IP pública, según el entorno
            de despliegue.
        </li>
        <li class="help__item">
            <strong>N.º de puerto:</strong> Puerto TCP utilizado para la
            conexión al SGBD. Ejemplo típico: <code>3306</code> para MySQL o MariaDB.
        </li>
        <li class="help__item">
            <strong>Usuario de la BD:</strong> Nombre del usuario que posee privilegios
            para realizar operaciones sobre la base de datos especificada.
        </li>
        <li class="help__item">
            <strong>Nombre de la BD:</strong> Nombre exacto de la base de datos con
            la que se desea establecer la conexión.
        </li>
        <li class="help__item">
            <strong>Codificación:</strong> Charset definido para la comunicación
            con el SGBD. Valor por defecto: <code>utf8</code>.
        </li>
        <li class="help__item">
            <strong>Colación:</strong> Define las reglas de comparación y
            ordenamiento de texto en la base de datos. Por defecto:
            <code>utf8_general_ci</code>.
        </li>
        <li class="help__item">
            <strong>Motor de BD:</strong> Especifica el tipo de SGBD a utilizar.
            Ejemplos válidos: <code>mysql</code>, <code>mariadb</code>,
            <code>sqlite</code>, <code>postgresql</code>.
        </li>
        <li class="help__item">
            <strong>Prefijo de las tablas:</strong> Cadena opcional que se
            antepone a los nombres de las tablas, útil para evitar conflictos en
            bases de datos compartidas. Ejemplo: <code>dl_</code>.
        </li>
    </ul>

    <h4 class="help__subtitle">Botón de acción:</h4>
    <ul class="help__list">
        <li class="help__item">
            <strong>Establecer credenciales:</strong> Envía los datos ingresados
            y aplica la configuración necesaria para permitir el acceso del sistema
            a la base de datos definida.
        </li>
    </ul>
</section>
