<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

import { getAvatarSource } from '@/Utils/utils.js';

dayjs.extend(relativeTime);

const props = defineProps({
    comment: Object,
    movieId: Number || String,
});

const form = useForm({
    text: props.comment.text,
});

const editing = ref(false);

</script>
 
<template>
    <div class="p-6 flex space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        <div class="flex-1">
            <div class="flex justify-between items-center">
                <div class="flex items-end">

                    <img :src="comment.user.avatar? $page.props.ziggy.url + '/storage/' + comment.user.avatar : getAvatarSource(comment.user.name)" 
                            width="40" class="inline mr-2 rounded-full overflow-hedden" alt="avatar">

                    <span class="text-gray-800" :class="{'text-indigo-500 font-bold': $page.props.auth.user && comment.user.id === $page.props.auth.user.id}">{{ comment.user.name }}</span>
                    <small class="ml-2 text-sm text-gray-600">{{ dayjs(comment.created_at).fromNow() }}</small>
                    <small v-if="comment.created_at !== comment.updated_at" class="text-sm text-gray-600"> &middot; edited</small>
                </div>

                 <Dropdown v-if="$page.props.auth.user && comment.user.id === $page.props.auth.user.id">
                    <template #trigger>
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </button>
                    </template>
                    <template #content>
                        <button class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 
                                    focus:bg-gray-100 transition duration-150 ease-in-out" @click="editing = true">
                            Edit
                        </button>

                        <DropdownLink as="button" :href="route('comments.destroy', [comment.id])" preserve-scroll method="delete">
                            Delete
                        </DropdownLink>

                    </template>
                </Dropdown>

            </div>
             <form v-if="editing" @submit.prevent="form.put(route('comments.update', comment.id), { onSuccess: () => editing = false, preserveScroll: true })">
                <textarea v-model="form.text" class="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                <InputError :message="form.errors.text" class="mt-2" />
                <div class="space-x-2">
                    <PrimaryButton class="mt-4">Save</PrimaryButton>
                    <button class="mt-4" @click="editing = false; form.reset(); form.clearErrors()">Cancel</button>
                </div>
            </form>
            <p v-else class="mt-4 text-lg text-gray-900">
                    {{ comment.text }}
            </p>
        </div>
    </div>
</template>