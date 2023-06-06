<script setup>

 defineProps({
     type: {
       type: String,
       default: 'submit'
     },
 });

</script>

<style>

.tooltipW{

position: relative;

}

.tooltipW::before {
content: attr(data-tooltip);
position: absolute;
bottom: 100%;
left: 50%;
transform: translateX(-50%);
padding: 8px;
background-color: #fdd831;
color: #000000;
border-radius: 4px;
font-size: 8px;
opacity: 0;
pointer-events: none;
transition: opacity 0.5s ease-in-out;
}
.tooltipW:hover::before {
opacity: 1;
}

</style>

<template>
    <button 
        :type="type"
        class="tooltipW WarningButton inline-flex items-center px-4 py-2 bg-yellow-400 border border-transparent rounded-md
         font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-300 focus:bg-yellow-700
          active:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
           data-tooltip="">
        <slot />
    </button>
</template>
