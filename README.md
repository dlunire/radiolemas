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