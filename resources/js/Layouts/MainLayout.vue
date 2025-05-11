<template>
    <div class="min-h-screen bg-blue-50" @click="handleOutsideClick">
        <!-- Navbar -->
        <header
            class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 w-full"
            ref="header"
        >
            <div
                class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center"
            >
                <!-- Left: Logo & Navigation -->
                <div class="flex items-center gap-6">
                    <h1 class="text-xl font-bold text-gray-800 dark:text-white">
                        <Link :href="route('home')"> Nighborhood </Link>
                    </h1>
                    <nav class="hidden md:flex gap-6">
                        <Link
                            href="/"
                            :class="[
                                'hover:text-blue-600 font-medium transition-all',
                                $page.url === '/'
                                    ? 'font-bold text-blue-600 text-lg'
                                    : 'text-gray-700 dark:text-gray-300 text-base',
                            ]"
                        >
                            Home
                        </Link>
                        <Link
                            href="/resource"
                            :class="[
                                'hover:text-blue-600 font-medium transition-all',
                                $page.url.startsWith('/resource')
                                    ? 'font-bold text-blue-600 text-lg'
                                    : 'text-gray-700 dark:text-gray-300 text-base',
                            ]"
                        >
                            Resources
                        </Link>
                        <Link
                            :href="route('posts.index')"
                            :class="[
                                'hover:text-blue-600 font-medium transition-all',
                                $page.url.startsWith('/posts')
                                    ? 'font-bold text-blue-600 text-lg'
                                    : 'text-gray-700 dark:text-gray-300 text-base',
                            ]"
                        >
                            Posts
                        </Link>
                        <Link
                            v-if="user"
                            :href="route('reservations.index')"
                            :class="[
                                'hover:text-blue-600 font-medium transition-all',
                                $page.url.startsWith('/reservations')
                                    ? 'font-bold text-blue-600 text-lg'
                                    : 'text-gray-700 dark:text-gray-300 text-base',
                            ]"
                        >
                            My Reservations
                        </Link>

                        <span v-if="user" class="text-gray-500">
                            {{ user.name }}
                        </span>
                    </nav>
                </div>

                <!-- Right: Login/Logout and Hamburger -->
                <div class="flex items-center gap-10">
                    <div v-if="user">
                        <Link :href="route('profile')">
                            <div class="flex flex-col gap-4">
                                <img
                                    src="/public/images/profile.png"
                                    alt="User Profile"
                                    class="h-8 w-8 rounded-full border border-gray-300"
                                />
                            </div>
                        </Link>
                    </div>
                    <div v-if="user">
                        <Link
                            href="/logout"
                            method="post"
                            as="button"
                            class="text-gray-700 dark:text-gray-300 hover:text-red-500 font-medium"
                        >
                            Logout
                        </Link>
                    </div>
                    <div v-else class="flex items-center gap-4">
                        <Link
                            href="/user-account/create"
                            class="text-gray-700 dark:text-gray-300 hover:text-blue-500 font-medium"
                        >
                            Register
                        </Link>
                        <Link
                            href="/login"
                            as="button"
                            class="text-gray-700 dark:text-gray-300 hover:text-blue-500 font-medium"
                        >
                            Sign-in
                        </Link>
                    </div>

                    <!-- Mobile Hamburger -->
                    <button
                        @click.stop="toggleMobileMenu"
                        class="md:hidden text-gray-700 dark:text-gray-300 focus:outline-none"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                :d="
                                    isOpen
                                        ? 'M6 18L18 6M6 6l12 12'
                                        : 'M4 6h16M4 12h16M4 18h16'
                                "
                            />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Nav -->
            <div
                v-if="isOpen"
                class="md:hidden px-4 pb-4 space-y-2"
                @click.stop
            >
                <Link
                    href="/"
                    :class="[
                        'block hover:text-blue-600 font-medium transition-all',
                        $page.url === '/'
                            ? 'font-bold text-blue-600 text-lg'
                            : 'text-gray-700 dark:text-gray-300 text-base',
                    ]"
                    @click="closeMobileMenu"
                >
                    Home
                </Link>
                <Link
                    href="/resource"
                    :class="[
                        'block hover:text-blue-600 font-medium transition-all',
                        $page.url.startsWith('/resource')
                            ? 'font-bold text-blue-600 text-lg'
                            : 'text-gray-700 dark:text-gray-300 text-base',
                    ]"
                    @click="closeMobileMenu"
                >
                    Resources
                </Link>
                <Link
                    :href="route('posts.index')"
                    :class="[
                        'block hover:text-blue-600 font-medium transition-all',
                        $page.url.startsWith('/posts')
                            ? 'font-bold text-blue-600 text-lg'
                            : 'text-gray-700 dark:text-gray-300 text-base',
                    ]"
                    @click="closeMobileMenu"
                >
                    Posts
                </Link>
                <Link
                    v-if="user"
                    :href="route('reservations.index')"
                    :class="[
                        'block hover:text-blue-600 font-medium transition-all',
                        $page.url.startsWith('/reservations')
                            ? 'font-bold text-blue-600 text-lg'
                            : 'text-gray-700 dark:text-gray-300 text-base',
                    ]"
                    @click="closeMobileMenu"
                >
                    My Reservations
                </Link>
            </div>
        </header>

        <!-- Flash Message -->
        <div
            v-if="$page.props.flash.success"
            class="bg-green-100 text-black text-sm border border-green-200 rounded-lg p-2 m-5 dark:bg-green-900 dark:text-white dark:border-green-700"
        >
            {{ $page.props.flash.success }}
        </div>

        <!-- Page Content -->
        <main class="max-w-7xl mx-auto px-4 py-8">
            <slot />
        </main>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const isOpen = ref(false);
const user = computed(() => usePage().props.user);
const header = ref(null);

const toggleMobileMenu = () => {
    isOpen.value = !isOpen.value;
};

const closeMobileMenu = () => {
    isOpen.value = false;
};

const handleOutsideClick = (event) => {
    if (isOpen.value && header.value && !header.value.contains(event.target)) {
        isOpen.value = false;
    }
};

import { router } from "@inertiajs/vue3";
router.on("navigate", () => {
    isOpen.value = false;
});
</script>
