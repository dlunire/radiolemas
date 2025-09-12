/**
 * Aplica un esquema de apilamiento visual inverso (`z-index`) 
 * a todos los elementos con el atributo `data-list`.
 *
 * Esta función recorre todos los nodos con `[data-list]` dentro del contenedor recibido
 * y está diseñada para asignar dinámicamente un `z-index` que invierte el orden
 * natural del DOM. 
 *
 * Por ejemplo, el primer elemento en el DOM recibirá el mayor `z-index`,
 * y el último, el menor, permitiendo que los elementos anteriores se
 * visualicen por encima de los posteriores.
 *
 * @function zIndexReverse
 * @author David E Luna M
 * @copyright 2025 David E Luna M
 * @returns void No retorna ningún valor. Modifica el DOM directamente.
 */
export function zIndexReverse(container: HTMLElement): void {

    if (!(container instanceof HTMLElement)) {
        throw new Error("Se esperaba un elemento como argumento en «container»");
    }

    const nodes: NodeListOf<HTMLElement> = container.querySelectorAll("[data-list]");
    const { length } = nodes;

    let count: number = 0;
    for (const element of nodes) {
        if (!(element instanceof HTMLElement)) continue;
        element.style.setProperty('--z-index', String(length - count++));
    }
}