<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, useForm, Head } from '@inertiajs/inertia-vue3';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PopupSuccess from '@/Components/PopupSuccess.vue';
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
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <section class="container mx-auto p-6 font-mono">
                    <!-- <Link :href="route('admin.genres.index')" class="text-indigo-500 block w-fit mb-4 hover:text-indigo-800">&lt Жанры</Link> -->
                    <section class="flex content-center">
                        <Head title="Добавить жанр" />
                        <form @submit.prevent="form.put(route('admin.genres.update', { id: genre.id }), { preserveScroll: true })"
                            class="w-1/2">
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 flex flex-col gap-5 bg-white sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-6">
                                            <InputLabel for="first-name" class="block w-full text-sm font-medium text-gray-700">Название жанра: </InputLabel>
                                            <TextInput v-model="form.title" required type="text" autocomplete="given-name"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                            <InputError :message="form.errors.title" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="buttons flex gap-2 justify-end">
                                        <button class="bg-indigo-500 hover:bg-indigo-700 h-[40px] self-end text-white px-4 py-2 rounded-lg">Сохранить</button>
                                        <Link :href="route('admin.genres.index')" class="bg-red-500 hover:bg-red-700 h-[40px] self-end text-white px-4 py-2 rounded-lg w-fit block">Отмена</Link>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                    <!-- <div class="w-full flex mb-4 p-2 justif-start">
                        <Link :href="route('admin.genres.store')" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded-lg">Добавить</Link>
                    </div> -->
                </section>
            </div>
        </div>
    </AdminLayout>
    </div>
</template>

<style lang="scss" scoped>

</style>
