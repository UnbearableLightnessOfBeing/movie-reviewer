<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Register" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-primarylight shadow sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel class="text-secondary" for="name" value="Имя пользователя" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block bg-primary text-white w-full"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                            />

                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="mt-4">
                            <InputLabel class="text-secondary" for="email" value="Email" />

                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block bg-primary text-white w-full"
                                v-model="form.email"
                                required
                                autocomplete="username"
                            />

                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="mt-4">
                            <InputLabel class="text-secondary" for="password" value="Пароль" />

                            <TextInput
                                id="password"
                                type="password"
                                class="mt-1 block bg-primary text-white w-full"
                                v-model="form.password"
                                required
                                autocomplete="new-password"
                            />

                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="mt-4">
                            <InputLabel class="text-secondary" for="password_confirmation" value="Подтвердите пароль" />

                            <TextInput
                                id="password_confirmation"
                                type="password"
                                class="mt-1 block bg-primary text-white w-full"
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
                            />

                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <Link
                                :href="route('login')"
                                class="underline text-sm text-secondary hover:text-amber-500 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary"
                            >
                                Уже зарегистрированы?
                            </Link>

                            <PrimaryButton class="ml-4 border border-secondary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Зарегистрироваться
                            </PrimaryButton>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
