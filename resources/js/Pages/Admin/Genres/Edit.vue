<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, useForm, Head } from '@inertiajs/inertia-vue3';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PopupSuccess from '@/Components/PopupSuccess.vue';
import AdminEdit from '@/Components/AdminEdit.vue';
import { defineProps } from 'vue';

const props = defineProps(['genre']);

const form = useForm({
    title: props.genre.title,
});

form.defaults({
    title: props.genre.title,
});

</script>

<template>
    <div>
    <AdminLayout>
        <template #header>
            <h1 class="text-3xl font-bold text-indigo-600">
                Жанры
            </h1>
            <Head title="Редактировать жанр" />
        </template>
        <AdminEdit routeName="genres" :form="form" :item="genre">
            <template v-slot:inputs>
                <InputLabel for="first-name" class="block w-full text-sm font-medium text-gray-700">Название жанра: </InputLabel>
                <TextInput v-model="form.title" required type="text" autocomplete="given-name"
                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                <InputError :message="form.errors.title" class="mt-2" />
            </template>
        </AdminEdit>
    </AdminLayout>
    </div>
</template>

<style lang="scss" scoped>

</style>
