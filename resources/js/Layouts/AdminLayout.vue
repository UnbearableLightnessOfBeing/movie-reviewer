<script setup>
import { ref, onMounted } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import Sidebar from '@/Components/Sidebar.vue';
import { Link, usePage,  } from '@inertiajs/inertia-vue3';

import { getAvatarSource } from '@/Utils/utils.js';

const showingNavigationDropdown = ref(false);

let sidebarOpen = ref(true);
let dropdownOpen = ref(false);
let notificationOpen = ref(false);

function setSidebar(value) {
    sidebarOpen.value = value;
}

</script>

<template>
    <div>
        <div class="flex h-screen bg-primary font-roboto">
            <Sidebar :sidebarOpen="sidebarOpen" @update:sidebarOpen="setSidebar" />
            <div class="flex-1 flex flex-col overflow-hidden">

                <header class="w-full h-fit flex justify-between items-center py-4 px-6 bg-white border-b-4 border-indigo-600">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>

                        <div class="relative mx-4 lg:mx-0">
                            <Link class="text-indigo-600 hover:text-purple-600 font-bold flex gap-2 fustify-center items-center w-32 sm:w-64 rounded-md pl-10 pr-4"
                                :href="route('/')">
                                <svg class="w-[30px] h-[30px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="purple" d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256S114.6 512 256 512s256-114.6 256-256zM215 127c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-71 71L392 232c13.3 0 24 10.7 24 24s-10.7 24-24 24l-214.1 0 71 71c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L103 273c-9.4-9.4-9.4-24.6 0-33.9L215 127z"/></svg>
                                Вернуться на сайт
                            </Link>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <!-- <div x-data="{ notificationOpen: false }" class="relative"> -->
                        <div class="relative">
                        </div>

                        <!-- <div x-data="{ dropdownOpen: false }" class="relative"> -->
                        <div class="relative">
                            <button @click="dropdownOpen = ! dropdownOpen"
                                class="relative block h-8 w-8 rounded-full overflow-hidden shadow focus:outline-none">
                                <img class="h-full w-full object-cover"
                                    :src="$page.props.auth.user.avatar? $page.props.ziggy.url + '/storage/' + $page.props.auth.user.avatar : getAvatarSource($page.props.auth.user.name)"
                                    alt="Your avatar">
                            </button>

                            <div v-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

                            <div v-show="dropdownOpen"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-10">
                                <Link :href="route('profile.edit')" 
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">Профиль</Link>
                                <Link :href="route('logout')" method="post" as="button"
                                    class="block w-full text-start px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">Выйти</Link>
                            </div>
                        </div>
                    </div>
                </header>


                <!-- Page Heading -->
                <header class="bg-white shadow" v-if="$slots.header">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <slot name="header" />
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>

