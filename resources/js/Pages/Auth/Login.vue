<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Вход" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-primarylight shadow sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel class="text-secondary" for="email" value="Email" />

                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block bg-primary text-white w-full"
                                v-model="form.email"
                                required
                                autofocus
                                autocomplete="username"
                            />

                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="mt-4">
                            <InputLabel class="text-secondary" for="password" value="Password" />

                            <TextInput
                                id="password"
                                type="password"
                                class="mt-1 block bg-primary text-white w-full"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                            />

                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="block mt-4">
                            <label class="flex items-center">
                                <Checkbox name="remember" v-model:checked="form.remember" />
                                <span class="ml-2 text-sm text-secondary">Запомнить меня</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <Link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="underline text-sm text-secondary hover:text-amber-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary"
                            >
                                Забыли пароль?
                            </Link>

                            <PrimaryButton class="ml-4 border border-secondary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Войти
                            </PrimaryButton>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
