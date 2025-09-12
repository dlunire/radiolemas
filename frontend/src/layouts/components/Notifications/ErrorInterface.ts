export interface ServerResponse {
    status: boolean;
    error?: string;
    message?: string;
    success?: string
}

/**
 * Devuelve un tipo. No pretende validar el contenido, sino devolver el tipo.
 * 
 * @param input Entrada con tipo desconocido
 * @returns 
 */
export function getType<T>(input: unknown): T {
    return input as T;
}