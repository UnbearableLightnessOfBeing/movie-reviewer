<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Forgot Password" />

        <div class="mb-4 mt-10 text-center text-lg text-secondary">
            Забыли пароль? Не проблема. Мы отправи ссылку на Ваш email, перейдя по которой Вы сможете заменить свой пароль на новый.
        </div>

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

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="border border-secondary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Получить ссылку для восстановления пароля
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
