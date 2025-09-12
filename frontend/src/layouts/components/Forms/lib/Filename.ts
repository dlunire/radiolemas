/**
 * Interface que representa la estructura de un archivo procesado
 * por el sistema DLUnire.
 * 
 * Esta interfaz es útil para definir el contrato en el frontend
 * para visualizar archivos, tamaños, URLs, y metadatos asociados.
 */
export interface Filename {
    /**
     * URL directa al archivo (privada o pública según configuración)
     */
    url: string;

    /**
     * URL de vista previa del archivo
     */
    preview: string | null;

    /**
     * Tipo MIME del archivo (por ejemplo, 'image/jpeg')
     */
    type: string | null;

    /**
     * Cantidad total de bytes del archivo
     */
    bytes: number;

    /**
     * Formato del archivo (por ejemplo, 'jpeg', 'pdf')
     */
    format: string | null;

    /**
     * Tamaño del archivo en formato legible (por ejemplo, '2.3 MB')
     */
    size: string;

    /**
     * Indica si el archivo es privado (solo accesible con sesión)
     */
    private: boolean;

    /**
     * Identificador único del archivo (UUID)
     */
    uuid: string;

    /**
     * Token opcional que agrupa múltiples archivos
     */
    token: string | null;
}
