<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import AdminInterractor from '@/Components/AdminInterractor.vue';
import { defineProps } from 'vue';

const props = defineProps(['genres', 'filters', 'notifs']);

</script>

<template>
    <AdminLayout >
        <template #header>
            <h1 class="text-3xl font-bold text-indigo-600">
                Жанры
            </h1>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <AdminInterractor :items="genres" :filters="filters" :notifs="notifs" routeName='genres'>
                    <template #table="tableProps" >
                        <td class="px-4 py-3 border w-full">
                            {{ tableProps.item.title }}
                        </td>
                    </template>
                </AdminInterractor>
            </div>
        </div>
    </AdminLayout>
</template>

<style lang="scss" scoped>

</style>

