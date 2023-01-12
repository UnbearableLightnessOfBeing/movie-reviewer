<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import AdminWelcome from '@/Components/AdminWelcome.vue';
import { defineProps } from 'vue';

const props = defineProps({
    statistic: Object,
});

</script>

<template>
    <AdminLayout>
        <template #header>
            <h1 class="text-3xl font-bold text-indigo-600">
                Главная
            </h1>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <AdminWelcome :statistic="statistic" />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style lang="scss" scoped>

</style>