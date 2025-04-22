<template>
    <div class="min-h-screen bg-blue-50">
        <!-- Navbar -->
        <header
            class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 w-full"
        >
            <div
                class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center"
            >
                <!-- Logo / App Name -->
                <h1 class="text-xl font-bold text-gray-800">MyApp</h1>

                <!-- Desktop Nav -->
                <nav class="hidden md:flex space-x-6">
                    <Link
                        href="/"
                        class="text-gray-700 hover:text-blue-600 font-medium"
                        >Home</Link
                    >
                    <Link
                        href="/resource"
                        class="text-gray-700 hover:text-blue-600 font-medium"
                        >Resources</Link
                    >
                </nav>

                <!-- Mobile Hamburger -->
                <button
                    class="md:hidden text-gray-700 focus:outline-none"
                    @click="isOpen = !isOpen"
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

            <!-- Mobile Nav Links -->
            <div v-if="isOpen" class="md:hidden px-4 pb-4">
                <Link
                    href="/"
                    class="block text-gray-700 py-2 hover:text-blue-600 font-medium"
                    >Home</Link
                >
                <Link
                    href="/resource"
                    class="block text-gray-700 py-2 hover:text-blue-600 font-medium"
                    >Resources</Link
                >
            </div>
        </header>

        <!-- Page Content -->
        <main class="max-w-7xl mx-auto px-4 py-8">
            <slot />
        </main>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

const isOpen = ref(false);
</script>
