<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import AdminInterractor from '@/Components/AdminInterractor.vue';
import PopupWatched from '@/Components/PopupWatched.vue';
import { defineProps, ref } from 'vue';
import dayjs from 'dayjs';
import ru from 'dayjs/locale/ru';

import { getAvatarSource } from '@/Utils/utils'; 

dayjs.locale(ru);

function getDate() {

}
let watchedUser = ref(1);
let isUserWatched = ref(false);

function updateWatchedUser(value) {
    watchedUser.value = value;
    isUserWatched.value = true;
}

const props = defineProps(['users', 'filters', 'notifs', 'watchedUser']);

</script>

<template>
    <AdminLayout >
        <template #header>
            <h1 class="text-3xl font-bold text-indigo-600">
                Пользователи
            </h1>
            <PopupWatched v-if="isUserWatched" @closeWindow="isUserWatched = false" :item = "users.data.find(user => +user.id === +watchedUser)">
                <template v-slot:modelProps="slotProps" >
                    <img    :src="slotProps.item.avatar? $page.props.ziggy.url + '/storage/' + 
                            slotProps.item.avatar : getAvatarSource(slotProps.item.name)" 
                            width="100" class="rounded-md overflow-hedden" alt="avatar">
                    <div>
                        <strong class="text-xl">Имя</strong>
                        <p class="text-md text-gray-400">{{ slotProps.item.name }}</p>
                    </div>
                    <div>
                        <strong class="text-xl">Email</strong>
                        <p class="text-md text-gray-300">{{ slotProps.item.email }}</p>
                    </div>
                    <div>
                        <strong class="text-xl">Администратор</strong>
                        <p class="text-md font-bold" :class="slotProps.item.roles?.filter(role => role.name==='admin').length? 'text-emerald-500' : 'text-pink-500'">
                            {{ slotProps.item.roles?.filter(role => role.name==='admin').length? 'Да' : 'Нет' }}
                        </p>
                    </div>
                    <div>
                        <strong class="text-xl">Email</strong>
                        <p class="text-md text-gray-300">{{ slotProps.item.email }}</p>
                    </div>
                    <div>
                        <strong class="text-xl">Зарегистрирован</strong>
                        <p class="text-md text-gray-300">{{ dayjs(slotProps.item.created_at).locale(ru).format('d/MMM/YYYY') }}</p>
                    </div>
                </template>
            </PopupWatched>
        </template>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <AdminInterractor @update:watched-item="updateWatchedUser" :items="users.data" :filters="filters" :notifs="notifs" :watchable="true" routeName='users' :creatable="false" >
                    <template v-slot:table-headings>
                        <th class="px-4 py-3">Имя</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Админ</th>
                        <th class="px-4 py-3">Фото</th>
                        <th class="px-4 py-3">Создан</th>
                    </template>
                    <template v-slot:table="tableProps" >
                        <td class="px-4 py-3 border">
                            {{ tableProps.item.name }}
                        </td>
                        <td class="px-4 py-3 border">
                            {{ tableProps.item.email }}
                        </td>
                        <td class="px-4 py-3 border">
                            <div v-if="tableProps.item.roles.length && tableProps.item.roles.filter(role => role.name === 'admin').length" >
                               <svg class="mx-auto" style="width: 40px; height:40px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="green" d="M470.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L192 338.7 425.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
                            </div>
                            <div v-else>
                                <svg class="mx-auto" style="width: 40px; height:40px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="red" d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z"/></svg>
                            </div>
                        </td>
                        <td class="py-1 border max-w-[100px]">
                            <img    :src="tableProps.item.avatar? $page.props.ziggy.url + '/storage/' + 
                                    tableProps.item.avatar : getAvatarSource(tableProps.item.name)" 
                                    width="100" class="mx-auto rounded-md overflow-hedden" alt="avatar">
                        </td>
                        <td class="px-4 py-3 border">
                            {{ dayjs(tableProps.item.created_at).locale(ru).format('d/MMM/YYYY') }}
                        </td>
                    </template>
                </AdminInterractor>
            </div>
        </div>
    </AdminLayout>
</template>

<style lang="scss" scoped>

</style>


