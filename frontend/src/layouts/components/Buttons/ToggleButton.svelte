<script lang="ts">
    type Click = (event?: MouseEvent) => void;
    export let active: boolean = false;
    export let label: string = "Etiqueta aquí";

    function onclick(event: MouseEvent) {
        active = !active;
    }
</script>

<div class="toggle-container">
    <button class="button button--toggle" type="button" aria-label="Toggle" {onclick}></button>
    <div class="toggle" class:toggle--active={active}></div>
    <span class="label" class:label--active={active}>{label}</span>
</div>

<style lang="scss">
    .button {
        display: flex;
        position: absolute;
        margin: auto;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        border-radius: 0;
    }
    .toggle {
        &-container {
            position: relative;
            height: 30px;
            overflow: hidden;
            display: flex;
            align-items: center;

            &:hover {
                .label {
                    opacity: 0.85;
                }
            }

            &:active {
                .label {
                    transition: none;
                    opacity: 1;
                }
            }
        }

        & {
            border: 1px solid rgba(black, 0.6);
            position: absolute;
            margin: auto;
            left: 0;
            right: auto;
            top: 0;
            bottom: 0;
            height: 20px;
            width: 40px;
            border-radius: 12.5px;
            transition: 300ms ease;
            pointer-events: none;
            user-select: none;

            &::before {
                content: "";
                display: block;
                position: absolute;
                margin: auto;

                --button-size: 14px;
                width: var(--button-size);
                height: var(--button-size);
                top: 0;
                bottom: 0;
                left: 2px;

                background-color: rgba(black, 0.5);
                border-radius: 50%;
                transition: 300ms ease;
            }

            &--active {
                border-color: rgba(green, 0.6);
                &::before {
                    background-color: green;
                    transform: translate(calc(145%));
                }
            }
        }
    }

    .label {
        padding-left: 50px;
        padding-right: 10px;
        transition: 300ms ease;
        color: rgba(black, 0.9);
        user-select: none;
        pointer-events: none;
        &--active {
            color: green;
        }
    }
</style>
