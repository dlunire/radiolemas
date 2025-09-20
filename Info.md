# Informacion de navegación de la emisora

El siguiente contenido permite generar el mapa de navegación de la emisora de radio.

1. Header (encabezado fijo)
   -  Logotipo de la emisora (RadioLemas).
   -  Menú de Navegación:
      -  Inicio.
      -  Programación.
      -  En Vivo
      -  Noticias (blog con noticias y categoría de noticias).
      -  Contacto.

2. Hero Section (sección principal)
   - Fondo con imagen o gradiente relacionado.
   - Mensaje central corto:
     - "RadioLemas: La voz que conecta contigo"
   
   - Botones principales:
     - Escuchar en vivo.
     - Últimas noticias.

3. Sección: En Vivo
   - Un minireproductor incrustado (streaming/audio player).
   - Texto breve: "Conéctate ahora y disfruta nuestra programación 24/7"

4. Sección: Programación
   - Un listado sencillo con horarios y programas destacados.
   - Ejemplo:
     - Mañana con RadioLemas - 06:00 AM - 10:00 AM
     - Noticias al día - 12:00 PM
     - Música sin pausa - 08:00 PM

5. Página: Noticias (Blog MVP)
   - Vista tipo cards con imagen, título, resumen corto y botón leer más.
   - Cateogrías básicas:
     - Música.
     - Cultura & Comunidad.
     - Actualidad.
   - Cada card lleva al detalle del artículo.
  
6. Sección: Sobre RadioLemas
   - Texto corto sobre la emisora (misión, visión, estilo).
   - Una foto del equipo o del estudio (opcional, MVP puede ser texto plano).
  
7. Sección: Contacto
   - Formulario breve: nombre, correo, mensaje.
   - Redes sociales con iconos: (Facebook, Instagram, X/Twitter, YouTube).

8. Footer
   - Copyright © 2025 RadioLemas
   - Enlaces rápidos.
   - Nota: "Sitio en desarrollo - MVP"

MVP - Diseño recomendado
- Minimalista, con 2 o 3 colores base (los que me digas que ya tienes).
- Tipografía clara y moderna.
- Evita sliders grandes (pesan y no aportan mucho al MVP).
- Backend solo con endpoints esenciales: noticias, programas, contacto.



## PÁGINA DE FACEBOOK INSERTADA EN LA WEB

Fragmento de código para Facebook:

```html
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v23.0&appId=APP_ID"></script>

<div class="fb-page" data-href="https://www.facebook.com/profile.php?id=61575156278078" data-tabs="timeline" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/facebook" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/facebook">Facebook</a></blockquote></div>
```

## Visualizar historias de Instagram

Petición que se envía a Instagram:

```bash
GET https://graph.instagram.com/{ig-user-id}/stories
  ?fields=id,media_type,media_url,permalink,timestamp
  &access_token={ACCESS_TOKEN}
```

Salida que se obtiene de la plataforma:

```json
{
  "data": [
    {
      "id": "17901234567890123",
      "media_type": "IMAGE",
      "media_url": "https://scontent.cdninstagram.com/v/t51.29350-15/1234567890_n.jpg?...",
      "permalink": "https://www.instagram.com/stories/usuario/17901234567890123/",
      "timestamp": "2025-09-20T13:45:12+0000"
    },
    {
      "id": "17909876543210987",
      "media_type": "VIDEO",
      "media_url": "https://scontent.cdninstagram.com/v/t50.2886-16/9876543210_n.mp4?...",
      "permalink": "https://www.instagram.com/stories/usuario/17909876543210987/",
      "timestamp": "2025-09-20T14:01:55+0000"
    }
  ],
  "paging": {
    "cursors": {
      "before": "QVFIUj...",
      "after": "QVFIUm..."
    }
  }
}
```

