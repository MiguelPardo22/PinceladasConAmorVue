
<style>
.tooltip {

    position: relative;

}

.tooltip::before {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    padding: 8px;
    background-color: #d61a1a;
    color: #ffffff;
    border-radius: 4px;
    font-size: 8px;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.5s ease-in-out;
}

.tooltip:hover::before {
    opacity: 1;
}
</style>

<template>
    <button class="tooltip DangerButton inline-flex items-center px-4 py-2 bg-red-600 border border-transparent
             rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-400
              active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2
               transition ease-in-out duration-150" data-tooltip="">
        <slot />
    </button>
</template>
