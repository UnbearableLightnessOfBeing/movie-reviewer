<script setup>
import { defineProps } from 'vue';
import { getAvatarSource } from '@/Utils/utils'; 
import dayjs from 'dayjs';
import ru from 'dayjs/locale/ru';

const props = defineProps({
    item: {
        type: Object,
        default: {}
    }
});

</script>

<template>
    
    <div class="item-bg fixed top-0 left-0 flex justify-center items-center bg-gray-800 bg-opacity-70 w-screen h-screen z-50">
        <div class="relative item-wrapper p-6 sm:border-4 border-indigo-400 sm:rounded-2xl bg-gray-600 
                    flex flex-col gap-4 text-white w-screen h-screen sm:w-fit sm:h-fit sm:min-w-[500px]">
            <svg class="w-8 h-8 absolute top-3 right-3 hover:cursor-pointer hover:scale-110 transition-all" 
                @click="$emit('closeWindow')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="pink" d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"/></svg>
            <slot name="modelProps" :item="item" />
        </div>
    </div>
</template>

<style lang="scss" scoped>

</style>