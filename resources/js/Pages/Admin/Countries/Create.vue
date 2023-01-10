<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import AdminCreate from '@/Components/AdminCreate.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';


const form = useForm({
    title: '',
});

</script>

<template>
    <div>
    <AdminLayout>
        <template #header>
            <h1 class="text-3xl font-bold text-indigo-600">
                Страны
            </h1>
            <Head title="Добавить жанр" />
        </template>
        <AdminCreate routeName="countries" :form="form">
            <template v-slot:inputs>
                <InputLabel for="first-name" class="block text-sm font-medium text-gray-700">Название страны: </InputLabel>
                <TextInput v-model="form.title" required type="text" autocomplete="given-name"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                <InputError :message="form.errors.title" class="mt-2" />
            </template>
        </AdminCreate>
    </AdminLayout>
    </div>
</template>

<style lang="scss" scoped>

</style>
