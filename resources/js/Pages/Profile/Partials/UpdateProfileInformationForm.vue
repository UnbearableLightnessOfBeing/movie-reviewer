<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/inertia-vue3';

import { getAvatarSource } from '@/Utils/utils'; 

const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});

const user = usePage().props.value.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
    avatar: null,
});

// function onFileChanged(e) {
//     console.log(e.target.files[0]);
//     form.avatar = e.target.files[0];
// };
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-secondary">Редактировать профиль</h2>

            <p class="mt-1 text-sm text-secondary">
                Обновите информацию о своём профиле и почтовый адрес.
            </p>
        </header>

        <form  @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">


            <div>
                <InputLabel class="text-secondary" for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 bg-primary text-white block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel class="text-secondary" for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 bg-primary text-white block w-full"
                    v-model="form.email"
                    required
                    autocomplete="email"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="props.mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="props.status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton class="border border-secondary" :disabled="form.processing">Сохранить</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
