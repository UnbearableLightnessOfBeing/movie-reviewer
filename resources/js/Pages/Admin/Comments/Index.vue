<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import AdminInterractor from '@/Components/AdminInterractor.vue';
import PopupWatched from '@/Components/PopupWatched.vue';
import { defineProps, ref } from 'vue';
import dayjs from 'dayjs';
import ru from 'dayjs/locale/ru';

dayjs.locale(ru);

let watchedComment = ref(1);
let isCommentWatched = ref(false);

function updateWatchedComment(value) {
    watchedComment.value = value;
    isCommentWatched.value = true;
}

const props = defineProps(['comments', 'filters', 'notifs', 'watchedComment']);

</script>

<template>
    <AdminLayout >
        <template #header>
            <h1 class="text-3xl font-bold text-indigo-600">
                Комментарии
            </h1>
            <PopupWatched v-if="isCommentWatched" @closeWindow="isCommentWatched = false" :item = "comments.data.find(comment => +comment.id === +watchedComment)">
                <template v-slot:modelProps="slotProps" >
                    <div>
                        <strong class="text-xl">Фильм</strong>
                        <p class="text-md text-gray-400">{{ slotProps.item.movie.title }}</p>
                    </div>
                    <div>
                        <strong class="text-xl">Пользователь</strong>
                        <p class="text-md text-gray-300">{{ slotProps.item.user.name }}</p>
                    </div>
                    <div>
                        <strong class="text-xl">Комментарий</strong>
                        <p class="text-md text-gray-300">{{ slotProps.item.text }}</p>
                    </div>
                    <div>
                        <strong class="text-xl">Оставлен</strong>
                        <p class="text-md text-gray-300">{{ dayjs(slotProps.item.created_at).locale(ru).format('ddd, MMM D, YYYY h:mm A') }}</p>
                    </div>
                </template>
            </PopupWatched>
        </template>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <AdminInterractor @update:watched-item="updateWatchedComment" :items="comments" :filters="filters" 
                                :notifs="notifs" :watchable="true" routeName='comments' :creatable="false" :deletable="true" :editable="false">
                    <template v-slot:table-headings>
                        <th class="px-4 py-3">Фильм</th>
                        <th class="px-4 py-3">Пользователь</th>
                        <th class="px-4 py-3">Комментарий</th>
                        <th class="px-4 py-3">Оставлен</th>
                    </template>
                    <template v-slot:table="tableProps" >
                        <td class="px-4 py-3 border">
                            {{ tableProps.item.movie.title }}
                        </td>
                        <td class="px-4 py-3 border">
                            {{ tableProps.item.user.name }}
                        </td>
                        <td class="px-4 py-3 border">
                            {{ tableProps.item.text.length > 70? tableProps.item.text.slice(0, 70) + ' ...' : tableProps.item.text }}
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


