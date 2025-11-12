# Radios Lemas

## Instalación

Primero, antes de comenzar debe clonar el proyecto previamente

```bash
git clone git@github.com:dlunire/radiolemas.git
```

Una vez clonado, ingrese el directorio:

```bash
cd radiolemas
```

Y posteriormente, instale las dependencias

```bash
composer install && cd frontend && npm install
```         

Luego el frontend:

```bash
npm run build && cd ..
```

Puede optar por desarrollar sobre él corriendo el servidor de desarrollo:

```bash
php -S localhost:4000 -t public/
```

## Qué ofrece la estación

### Aplicación Web Progresiva

Incluye una **Aplicación Web Progresiva (PWA, Progresive Web Application, en inglés). Ésta permite instalarse en su teléfono o computador como si fuese una aplicación nativa si usted lo permite.

Es completamente responsive.

### Página principal

Incluye una página principal con las principales secciones, entre las cuales, se encuentran:

- Redes Sociales: iconos de las principales redes sociales y widget de Facebook e Instagram para que puedan visualizar lo que publicas.
- Banner o cabecera animada (configurable)
- Sección de noticias
- Programación (puedes mostrarlo o no si lo desea).
- Acerca de la estación de radio.
- Una sección de contacto, que incluye, un mapa de Google y un formulario de contacto.
- Pie de página.

También cuenta con:
 - Un menú de navegación para navegar entre secciones.
 - En Vivo: para navegar directamente a la página de reproducción (incluye un reproductor).
 - News o noticias: le permite navegar en la página de noticias, donde podrá escoger las noticias de su preferencias.
  

### Panel de administración

En el panel de administración, usted puede:
- Publicar noticias, donde puede establecer:
  - Foto de portada.
  - Asignarle una categoría.
  
- Configurar su Aplicación Web Progresiva (PWA, Progresive Web Application, en inglés).
- Configurar su enlace o servidor streaming que contrató.
- Configurar su token de acceso para los Widgets para Facebook e Instagram.
- Subir banner, tanto para su teléfono como para su PC, demanera que las imágenes se adapten al dispositivo.
- Subir publicidad.
- Configurar las redes sociales donde esté registrado.
- Su perfil de usuario.
- Crear otro usuario para que le ayude a publicar contenido.
  
Cada foto que usted suba se optimiza y se convierte directamente al formato WebP.