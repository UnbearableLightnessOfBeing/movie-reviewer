<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    textColor: {
        type: String,
        default: ''
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center px-4 py-2 bg-primarylight border border-transparent rounded-md font-semibold text-sm text-white tracking-widest hover:bg-black focus:bg-gray-700 active:bg-gray-900 focus:outline-none transition ease-in-out duration-150"
        :class="textColor"
    >
        <slot />
    </button>
</template>
