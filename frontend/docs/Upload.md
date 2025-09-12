# Componente Upload.svelte

Este componente permite subir archivos mediante:

- Selección tradicional con input file oculto.
- Arrastrar y soltar (drag & drop).
- Pegar archivos desde el portapapeles (Ctrl + V).

## Propiedades

| Propiedad      | Tipo                 | Descripción                                                       | Valor por defecto    |
|----------------|----------------------|-----------------------------------------------------------------|---------------------|
| `content`      | `Function | undefined` | Snippet para personalizar el contenido del área de arrastre.     | `undefined`          |
| `buttonContent`| `Function | undefined` | Snippet para personalizar el contenido del botón de subida.       | `undefined`          |
| `name`         | `string`             | Nombre del campo de archivo. Si `multiple` es true, se convierte en `name[]`. | `"file"`             |
| `multiple`     | `boolean`            | Permite seleccionar varios archivos.                             | `false`              |
| `accept`       | `string | undefined` | Tipos MIME permitidos para selección.                            | `undefined`          |
| `action`       | `string`             | Ruta donde se envían los archivos.                               | `"/files/upload"`    |
| `data`         | `unknown`            | Contenido de la respuesta luego de la subida.                   | `undefined`          |
| `error`        | `string | null`      | Mensaje de error en la subida.                                  | `null`               |
| `abort`        | `string | null`      | Mensaje si el usuario aborta la subida.                         | `null`               |

## Uso básico con snippets personalizados

Tome en cuenta que los snippets son opcionales:

```svelte
<Upload
    name="documents"
    multiple={true}
    accept="application/pdf, image/*"
    action="/api/upload/documents"
>
    {#snippet content()}
        <p>Arrastra tus documentos aquí o pégalos con Ctrl + V</p>
    {/snippet}

    {#snippet buttonContent()}
        <span>Enviar archivos</span>
    {/snippet}
</Upload>
