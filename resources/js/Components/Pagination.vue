<script setup>
import { defineProps } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['items']);

</script>

<template>
    <div class="flex gap-2">
        <template v-for="(link, key) in items.links" :key="key">
            <div v-if="link.url === null" v-html="link.label" class="opacity-50 px-3 py-2 border text-sm"></div>
            <Link v-else :href="link.url" v-html="link.label" 
                class="px-3 py-2 text-sm text-black focus:border-black leading-4 border-2 border-gray-400 rounded"
                :class="{'border-2 border-indigo-500 text-indigo-500 bg-indigo-200' : items.current_page == link.label}"></Link>
        </template>
    </div>
</template>

<style lang="scss" scoped>

</style>