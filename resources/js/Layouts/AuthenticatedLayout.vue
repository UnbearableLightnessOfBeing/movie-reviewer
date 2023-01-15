<script setup>
import { ref, onMounted } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, usePage,  } from '@inertiajs/inertia-vue3';

import { getAvatarSource } from '@/Utils/utils.js';

const showingNavigationDropdown = ref(false);

let user = ref(usePage().props.value.auth.user);

</script>

<template>
    <div>
        <div class="min-h-screen bg-primary">
            <nav class="bg-primary border-b border-primarylight">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <!-- <ApplicationLogo
                                        class="text-white block h-9 w-auto fill-current"
                                    /> -->
                                    <svg fill="gray" width="50" height="50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M64 64V352H576V64H64zM0 64C0 28.7 28.7 0 64 0H576c35.3 0 64 28.7 64 64V352c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zM128 448H512c17.7 0 32 14.3 32 32s-14.3 32-32 32H128c-17.7 0-32-14.3-32-32s14.3-32 32-32z"/></svg>
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink :href="route('/')" :active="route().current('/')" class="text-secondary font-bold text-lg">
                                    Главная
                                </NavLink>
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')" class="text-secondary font-bold text-lg">
                                    Фильмы
                                </NavLink>
                                <NavLink v-if="$page.props.auth.user && $page.props.auth.user.roles.map(role => role.name === 'admin').length" 
                                        :href="route('admin.index')" :active="route().current('admin')"
                                        class="text-secondary font-bold text-lg">
                                    Администратор
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                        <img v-if="$page.props.auth.user" 
                                            :src="$page.props.auth.user.avatar? $page.props.ziggy.url + '/storage/' + $page.props.auth.user.avatar : getAvatarSource(user.name)" 
                                            width="40" class="mr-2 rounded-full overflow-hedden" alt="avatar">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-secondary bg-primarylight hover:text-amber-500 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{ $page.props.auth.user? $page.props.auth.user.name : 'Режим гостя' }}

                                                <svg
                                                    class="ml-2 -mr-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink class="bg-primarylight" v-if="$page.props.auth.user" :href="route('profile.edit')"> Профиль </DropdownLink>
                                        <DropdownLink v-else :href="route('profile.edit')"> Войти </DropdownLink>
                                        <DropdownLink class="bg-primarylighgt" v-if="$page.props.auth.user" :href="route('logout')" method="post" as="button">
                                            Выйти
                                        </DropdownLink>
                                        <DropdownLink v-else :href="route('register')">
                                            Регистрация
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-secondary hover:bg-primarylight 
                                    focus:outline-none focus:bg-primarylight focus:text-secindary transition duration-150 ease-in-out"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink class="text-secondary font-bold" :href="route('/')" :active="route().current('/')">
                            Главная
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')" class="text-secondary font-bold text-lg">
                            Фильмы
                        </ResponsiveNavLink>
                        <ResponsiveNavLink v-if="$page.props.auth.user && $page.props.auth.user.roles.map(role => role.name === 'admin').length" 
                                :href="route('admin.index')" :active="route().current('admin')"
                                class="text-secondary font-bold text-lg">
                            Администратор
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-primarylight">
                        <div class="px-4">
                            <div class="font-medium text-base text-secondary">
                                {{ $page.props.auth.user? $page.props.auth.user.name : 'Режим гостя' }}
                            </div>
                            <div v-if="$page.props.auth.user" class="font-medium text-sm text-gray-300">{{ $page.props.auth.user.email  }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <img v-if="$page.props.auth.user"
                                :src="$page.props.auth.user.avatar? $page.props.ziggy.url + '/storage/' + $page.props.auth.user.avatar : getAvatarSource(user.name)" 
                                width="40" class="mr-2 mx-4 rounded-full overflow-hedden" alt="avatar">
                            <ResponsiveNavLink v-if="$page.props.auth.user" :href="route('profile.edit')"> Профиль </ResponsiveNavLink>
                            <ResponsiveNavLink v-else :href="route('login')"> Войти </ResponsiveNavLink>
                            <ResponsiveNavLink v-if="$page.props.auth.user" :href="route('logout')" method="post" as="button">
                                Выйти
                            </ResponsiveNavLink>
                            <ResponsiveNavLink v-else :href="route('register')">
                                Регистрация
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-primary shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
