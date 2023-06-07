<script setup>
defineProps({
    type: {
        type:  String,
        default: 'submit'
    }
});
</script>

<style>

.tooltipA{

position: relative;

}

.tooltipA::before {
content: attr(data-tooltip);
position: absolute;
bottom: 100%;
left: 50%;
transform: translateX(-50%);
padding: 8px;
background-color: #ad48d4;
color: #ffffff;
border-radius: 4px;
font-size: 8px;
opacity: 0;
pointer-events: none;
transition: opacity 0.5s ease-in-out;
}
.tooltipA:hover::before {
opacity: 1;
}

</style>

<template>
    <button
        class="tooltipA PrimaryButton inline-flex items-center px-4 py-2 bg-purple-800 border border-transparent rounded-md font-semibold text-xs
        text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2
         focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
         >
        <slot />
    </button>
</template>
