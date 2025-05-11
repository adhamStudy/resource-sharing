<template>
    <div class="px-6 py-12">
        <!-- Hero Section -->
        <div
            class="relative w-full h-[500px] rounded-xl overflow-hidden shadow-lg mb-12"
        >
            <img
                src="/public/images/hero.jpg"
                alt="Neighborhood"
                class="absolute inset-0 w-full h-full object-cover"
            />
            <div
                class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center text-center text-white px-4"
            >
                <h1 class="text-5xl font-bold mb-4">
                    Welcome to NeighborConnect
                </h1>
                <p class="text-xl max-w-2xl">
                    A community-driven platform to swap resources, share posts,
                    and raise concerns—all in one place.
                </p>
                <Link
                    href="/register"
                    class="mt-8 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-full"
                >
                    Join the Community
                </Link>
            </div>
        </div>

        <!-- Features Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
            <Link
                :href="route('resource')"
                class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition"
            >
                <div
                    class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition"
                >
                    <img
                        src="/public/images/sharing.png"
                        alt="Sharing"
                        class="h-32 mx-auto mb-4"
                    />
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">
                        Swap Resources
                    </h2>
                    <p class="text-gray-600">
                        Lend or borrow useful items from your neighbors easily
                        and safely.
                    </p>
                </div>
            </Link>

            <Link
                :href="route('posts.index')"
                class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition"
            >
                <div
                    class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition"
                >
                    <img
                        src="/public/images/posts.png"
                        alt="Posts"
                        class="h-32 mx-auto mb-4"
                    />
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">
                        Post & Discuss
                    </h2>
                    <p class="text-gray-600">
                        Create posts to share thoughts, announcements, or
                        neighborhood events.
                    </p>
                </div>
            </Link>

            <div
                class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition"
            >
                <img
                    src="/public/images/complaint.png"
                    alt="Complaints"
                    class="h-32 mx-auto mb-4"
                />
                <h2 class="text-xl font-semibold text-gray-700 mb-2">
                    Raise Concerns
                </h2>
                <p class="text-gray-600">
                    Submit complaints or suggestions to help improve community
                    life.
                </p>
            </div>
        </div>
    </div>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
import { route } from "ziggy-js";
</script>
