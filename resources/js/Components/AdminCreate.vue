<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, useForm, Head } from '@inertiajs/inertia-vue3';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { defineProps } from 'vue';

const props = defineProps({
    routeName: String,
    form: Object,
});


</script>

<template>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <section class="container mx-auto p-6 font-mono">
                <section class="flex content-center">
                    <form @submit.prevent="form.post(route('admin.'+ routeName +'.store'), { onSuccess: () => form.reset(), preserveScroll: true })"
                        class="w-full md:w-1/2">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 flex flex-col gap-5 bg-white sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-6">
                                        <slot name="inputs">
                                            inputs
                                        </slot>
                                    </div>
                                </div>
                                    <div class="buttons flex gap-2 justify-end">
                                        <button class="bg-indigo-500 hover:bg-indigo-700 h-[40px] self-end text-white px-4 py-2 rounded-lg">Добавить</button>
                                        <Link :href="route('admin.'+ routeName +'.index')" class="bg-pink-500 hover:bg-pink-700 h-[40px] self-end text-white px-4 py-2 rounded-lg w-fit block">Отмена</Link>
                                    </div>
                            </div>
                        </div>
                    </form>
                </section>
            </section>
        </div>
    </div>
</template>

<style lang="scss" scoped>

</style>