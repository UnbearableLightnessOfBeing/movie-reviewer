<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import AdminInterractor from '@/Components/AdminInterractor.vue';
import { defineProps } from 'vue';

const props = defineProps(['actors', 'filters', 'notifs']);

</script>

<template>
    <AdminLayout >
        <template #header>
            <h1 class="text-3xl font-bold text-indigo-600">
                Актёры
            </h1>
        </template>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <AdminInterractor :items="actors" :filters="filters" :notifs="notifs" routeName='actors'>
                    <template v-slot:table-headings>
                        <th class="px-4 py-3">Имя</th>
                    </template>
                    <template v-slot:table="tableProps" >
                        <td class="px-4 py-3 border w-full">
                            {{ tableProps.item.name }}
                        </td>
                    </template>
                </AdminInterractor>
            </div>
        </div>
    </AdminLayout>
</template>

<style lang="scss" scoped>

</style>


