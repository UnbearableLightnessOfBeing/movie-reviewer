<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, useForm, Head } from '@inertiajs/inertia-vue3';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PopupSuccess from '@/Components/PopupSuccess.vue';
import AdminEdit from '@/Components/AdminEdit.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { defineProps } from 'vue';

import { getAvatarSource } from '@/Utils/utils'; 
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    user: Object,
});

const form = useForm({
    name: props.user.name,
    isAdmin: props.user.roles?.map(role => role.name === 'admin').length? true : false,
});

const avatarForm = useForm({
    avatar: {},
    userId: props.user.id
});

function setAdmin(value) {
    form.isAdmin = value
}

function submitAvatar(image) {
    console.log(image);
    // Inertia.put(route('admin.avatar.update', { id: props.user.id }));
}

// form.defaults({
//     name: props.user.name,
// });

</script>

<template>
    <div>
    <AdminLayout>
        <template #header>
            <h1 class="text-3xl font-bold text-indigo-600">
                Пользователи
            </h1>
            <Head title="Редактировать пользователя" />
        </template>
        <!-- <form encript="multipart/form-data" @submit.prevent="avatarForm.post(route('admin.avatar.update'), { preserveScroll: true })">
                <div class="flex flex-col gap-6">
                    <div>
                        <InputLabel for="avatar" class="block w-full text-sm font-medium text-gray-700">Аватар профиля: </InputLabel>
                        <img    :src="props.user.avatar? $page.props.ziggy.url + '/storage/' + 
                                props.user.avatar : getAvatarSource(props.user.name)" 
                                width="100" class="rounded-md overflow-hedden" alt="avatar">
                        <input
                            id="avatar"
                            name="avatar"
                            type="file"
                            @input="avatarForm.avatar = $event.target.files[0]"
                            accept="image/*"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            capture
                        />
                        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                            {{ form.progress.percentage }}%
                        </progress>
                        <InputError :message="form.errors.avatar" class="mt-2" />
                        <button>submit</button>
                    </div>
                </div>
            </form> -->
        <AdminEdit :isPost="true" routeName="avatar" :form="avatarForm" :item="user">
            <template v-slot:inputs>
                <div class="flex flex-col gap-6">
                    <div>
                        <InputLabel for="avatar" class="block w-full text-sm font-medium text-gray-700">Аватар профиля: </InputLabel>
                        <img    :src="props.user.avatar? $page.props.ziggy.url + '/storage/' + 
                                props.user.avatar : getAvatarSource(props.user.name)" 
                                width="100" class="rounded-md overflow-hedden" alt="avatar">
                        <input
                            id="avatar"
                            name="avatar"
                            type="file"
                            @input="avatarForm.avatar = $event.target.files[0]"
                            accept="image/*"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            capture
                        />
                        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                            {{ form.progress.percentage }}%
                        </progress>
                        <InputError :message="form.errors.avatar" class="mt-2" />
                    </div>
                </div>
            </template>
        </AdminEdit>
        <AdminEdit routeName="users" :form="form" :item="user">
            <template v-slot:inputs>
                <div class="flex flex-col gap-6">
                    <div>
                        <InputLabel for="first-name" class="block w-full text-sm font-medium text-gray-700">Имя пользователя: </InputLabel>
                        <TextInput v-model="form.name" required type="text" autocomplete="given-name"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>
                    <div>
                        <div class="flex gap-4 justify-start items-end">
                            <InputLabel for="admin" class="block text-sm font-medium text-gray-700
                                        hover:cursor-pointer">Права админастратора: </InputLabel>
                            <Checkbox class="w-6 h-6 hover:cursor-pointer" id="admin" :checked="form.isAdmin" @update:checked="setAdmin" />
                        </div>
                        <InputError :message="form.errors.isAdmin" class="mt-2" />
                    </div>
                </div>
            </template>
        </AdminEdit>
    </AdminLayout>
    </div>
</template>

<style lang="scss" scoped>

</style>


