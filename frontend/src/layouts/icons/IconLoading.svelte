<script lang="ts">
    export let className: string = "";
    export let size: number = 40;
    export let color: string = "white";
    export let fixedColor: string = "#fff4";
    export let open: boolean = false;
    export let position: string = "absolute";
</script>

{#if open}
    <div class="animation {className}" style="--position: {position}">
        <div
            class="mirror mirror--center"
            data-name="loading"
            style="--loading-size: {size}px; --animation-color: {color}; --fixed-color: {fixedColor};"
        >
            <div class="box">
                <svg viewBox="0 0 140 140" class="canva">
                    <!-- Circunferencia con borde fijo-->
                    <circle
                        class="circle circle--fixed"
                        cx="70"
                        cy="70"
                        r="43"
                    />

                    <!-- Circunferencia con borde animado -->
                    <circle
                        class="circle circle--rotate"
                        cx="70"
                        cy="70"
                        r="43"
                    />
                </svg>
            </div>
        </div>
    </div>
{/if}

<style lang="scss">
    @use "sass:color";
    @use "../../assets/sass/vars" as *;

    .mirror {
        --line-fixed-color: var(--fixed-color);
        --line-move-color: var(--animation-color);

        display: flex;
        position: absolute;
        margin: auto;

        left: 0;
        right: 0;
        top: 0;
        bottom: 0;

        box-sizing: border-box;

        align-items: center;
        justify-content: center;

        &--left {
            justify-content: flex-end;
        }

        &--right {
            justify-content: flex-start;
        }
    }

    .box {
        height: var(--loading-size);
        width: var(--loading-size);

        animation: 2s rotate-box linear infinite;
        border-radius: 50%;
    }

    .canva {
        width: var(--loading-size);
        height: var(--loading-size);
        border-radius: 50% !important;
        animation: 1600ms ease-in-out rotate infinite;
        background-color: var(--canva-color);
    }

    .circle {
        stroke-width: 7%;
        transition: 300ms ease;

        fill: none;

        &--rotate {
            stroke: var(--line-move-color);
            stroke-dasharray: 480;
            stroke-dashoffset: -700;
            stroke-linecap: round;
            animation: 800ms ease-in-out line-stroke infinite alternate;
        }

        &--fixed {
            stroke: var(--line-fixed-color);
        }
    }

    @keyframes line-stroke {
        from {
            stroke-dashoffset: -480;
        }
    }

    @keyframes rotate {
        0% {
            transform: rotate(359deg);
        }

        50% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(0deg);
        }
    }

    @keyframes rotate-box {
        from {
            transform: rotate(359deg);
        }

        to {
            transform: rotate(0deg);
        }
    }

    .mirror {
        transform: rotateY(180deg);
    }

    .loading {
        &-container {
            border-radius: 4px;
            position: absolute;
            margin: auto;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;

            background-color: $base-color;
            transition: 300ms ease;
            z-index: 100;

            &--window {
                --loading-size: 50px;
                --animation-color: #{$secondary-color};
                --canva-color: #{rgba(white, 0.05)};

                background-color: color.adjust($color: white, $lightness: -10%);
                display: flex;
                align-items: center;
                justify-content: center;
                padding-top: 100px;
            }
        }
    }

    .animation-container {
        --canva-color: #{black};

        $color: color.adjust(
            $color: $base-color,
            $lightness: -15%,
        );

        background-color: rgba($color, 0.6);
        z-index: 20;

        display: flex;
        align-items: center;
        justify-content: center;

        &--sales {
            background-color: rgba(white, 0.5);
        }

        & {
            background-color: silver;
            position: fixed;
            margin: auto;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
        }
    }

    .animation {
        --background: white;

        position: var(--position);
        background-color: var(--background);
        border-radius: inherit;
        background-color: $secondary-color;
        border-radius: inherit;

        &--translucent {
            --background: #{rgba(white, 0.4)};
        }

        &--silver {
            --background: #{color.adjust($color: white, $lightness: -10%)};
        }

        &--primary {
            background-color: color.adjust(
                $color: $base-color,
                $lightness: -5%
            );
        }

        &--create {
            --background: #{color.adjust($color: $base-color, $lightness: -35%)};
        }

        &--logout {
            --background: red;
            --animation-color: white;
            --fixed-color: #{rgba(white, 0.3)};
        }

        &--profile {
            border-top: 5px solid var(--profile-color);
            border-bottom: 5px solid var(--profile-color);
        }

        &--button-delete {
            --background: #540000;
            border: 1px solid rgba(red, 0.5);
        }
    }
    .animation {
        margin: auto;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        z-index: 1000;

        &--blue {
            background-color: #002741;
            color: white;
            --animation-color: white;
        }

        svg {
            height: var(--loading-size);
            width: var(--loading-size);
        }

        .circle {
            &--fixed {
                stroke: var(--fixed-color);
            }

            &--rotate {
                stroke: var(--animation-color);
            }
        }
    }
</style>
