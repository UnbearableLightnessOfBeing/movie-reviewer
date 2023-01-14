<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link, useForm, usePage } from '@inertiajs/inertia-vue3';

import { getAvatarSource } from '@/Utils/utils'; 

const user = usePage().props.value.auth.user;

const form = useForm({
    avatar: null,
});


</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-secondary">Фотография профиля</h2>

            <p class="mt-1 text-sm text-secondary">
                Сменить фотографию пользователя
            </p>
        </header>
        <form encript="multipart/form-data" @submit.prevent="form.post(route('avatar.update'))" class="mt-6 space-y-6">
            <div class="mt-1 flex gap-3 items-end w-full">
                <img    :src="$page.props.auth.user.avatar? $page.props.ziggy.url + '/storage/' + $page.props.auth.user.avatar : getAvatarSource(user.name)" 
                        width="80" class="mr-2 rounded-full overflow-hedden" alt="avatar">
                <input
                    class="text-secondary bg-primary"
                    id="avatar"
                    name="avatar"
                    type="file"
                    @input="form.avatar = $event.target.files[0]"
                    accept="image/*"
                    capture
                />
                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                    {{ form.progress.percentage }}%
                </progress>
                <InputError class="mt-2" :message="form.errors.avatar" />
            </div>
            <div class="flex items-center gap-4">
                <PrimaryButton :textColor="'bg-primary'" class="border border-secondary" :disabled="form.processing">Сохранить</PrimaryButton>
            </div>
        </form>
    </section>
</template>

<style lang="scss" scoped>

</style>