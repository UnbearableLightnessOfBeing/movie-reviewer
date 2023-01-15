<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import AdminInterractor from '@/Components/AdminInterractor.vue';
import PopupWatched from '@/Components/PopupWatched.vue';
import { defineProps, ref } from 'vue';
import dayjs from 'dayjs';
import ru from 'dayjs/locale/ru';

dayjs.locale(ru);

let watchedLog = ref(1);
let isLogWatched = ref(false);

function updateWatchedLog(value) {
    watchedLog.value = value;
    isLogWatched.value = true;
}

const props = defineProps(['logs', 'filters', 'notifs', 'watchedLog']);

</script>

<template>
    <AdminLayout >
        <template #header>
            <h1 class="text-3xl font-bold text-indigo-600">
                Логи
            </h1>
            <PopupWatched v-if="isLogWatched" @closeWindow="isLogWatched = false" :item = "logs.data.find(log => +log.id === +watchedLog)">
                <template v-slot:modelProps="slotProps" >
                    <div>
                        <strong class="text-xl">Сообщение</strong>
                        <p class="text-md text-gray-400">{{ slotProps.item.message }}</p>
                    </div>
                    <div>
                        <strong class="text-xl">Записанo</strong>
                        <p class="text-md text-gray-300">{{ dayjs(slotProps.item.logged_at).locale(ru).format('ddd, MMM D, YYYY h:mm A') }}</p>
                    </div>
                    <div>
                        <strong class="text-xl">JSON данные</strong>
                        <p class="text-md text-gray-300">{{ (slotProps.item.context) }}</p>
                    </div>
                </template>
            </PopupWatched>
        </template>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <AdminInterractor @update:watched-item="updateWatchedLog" :items="logs" :filters="filters" 
                                :notifs="notifs" :watchable="true" routeName='actions' :creatable="false" :deletable="true" :editable="false">
                    <template v-slot:table-headings>
                        <th class="px-4 py-3">Cooбщение</th>
                        <th class="px-4 py-3">Записано</th>
                    </template>
                    <template v-slot:table="tableProps" >
                        <td class="px-4 py-3 border">
                            {{ tableProps.item.message }}
                        </td>
                        <td class="px-4 py-3 border">
                            {{ dayjs(tableProps.item.logged_at).locale(ru).format('D/MMM/YYYY') }}
                        </td>
                    </template>
                </AdminInterractor>
            </div>
        </div>
    </AdminLayout>
</template>

<style lang="scss" scoped>

</style>

