<template>
    <div class="py-6 sm:py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1
                            class="text-xl sm:text-2xl font-semibold text-gray-900"
                        >
                            Posts
                        </h1>
                    </div>

                    <!-- Flash Message -->
                    <div
                        v-if="$page.props.flash.success"
                        class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded"
                    >
                        {{ $page.props.flash.success }}
                    </div>

                    <!-- Twitter-style Posts -->
                    <div class="space-y-4 sm:space-y-6">
                        <div
                            v-if="posts.data.length === 0"
                            class="text-gray-500 text-center py-8"
                        >
                            No posts yet. Be the first to create one!
                        </div>

                        <div
                            v-for="post in posts.data"
                            :key="post.id"
                            class="p-3 sm:p-4 bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow"
                        >
                            <Link class="block">
                                <div class="flex space-x-2 sm:space-x-3">
                                    <!-- Profile Picture -->
                                    <div class="flex-shrink-0">
                                        <div
                                            class="h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-indigo-100 flex items-center justify-center"
                                        >
                                            <span
                                                class="text-indigo-800 font-semibold"
                                                >{{
                                                    post.user.name.charAt(0)
                                                }}</span
                                            >
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1 min-w-0">
                                        <div
                                            class="flex flex-wrap items-center text-xs sm:text-sm"
                                        >
                                            <span
                                                class="font-medium text-gray-900"
                                                >{{ post.user.name }}</span
                                            >
                                            <span class="mx-1 text-gray-500"
                                                >&middot;</span
                                            >
                                            <span class="text-gray-500">{{
                                                formatTimeAgo(post.created_at)
                                            }}</span>
                                        </div>

                                        <h3
                                            class="mt-1 text-sm sm:text-base font-medium text-gray-900"
                                        >
                                            {{ post.title }}
                                        </h3>
                                        <p
                                            class="mt-1 text-xs sm:text-sm text-gray-600 line-clamp-3"
                                        >
                                            {{ post.content }}
                                        </p>

                                        <!-- Post Image -->
                                        <div
                                            v-if="post.image"
                                            class="mt-2 sm:mt-3 rounded-lg overflow-hidden"
                                        >
                                            <img
                                                :src="'/storage/' + post.image"
                                                :alt="post.title"
                                                class="w-full h-32 sm:h-48 object-cover rounded-lg"
                                            />
                                        </div>

                                        <!-- Post Actions -->
                                    </div>
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Floating Action Button (FAB) for Create Post -->
            <Link
                :href="route('posts.create')"
                class="fixed bottom-4 right-4 sm:bottom-8 sm:right-8 w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-indigo-600 text-white flex items-center justify-center shadow-lg hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 z-10"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 sm:h-6 sm:w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 4v16m8-8H4"
                    />
                </svg>
            </Link>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    posts: Object,
});

const formatDate = (dateString) => {
    const options = { year: "numeric", month: "long", day: "numeric" };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

const formatTimeAgo = (dateString) => {
    const date = new Date(dateString);
    const now = new Date();
    const seconds = Math.floor((now - date) / 1000);

    if (seconds < 60) {
        return `${seconds}s`;
    }

    const minutes = Math.floor(seconds / 60);
    if (minutes < 60) {
        return `${minutes}m`;
    }

    const hours = Math.floor(minutes / 60);
    if (hours < 24) {
        return `${hours}h`;
    }

    const days = Math.floor(hours / 24);
    if (days < 7) {
        return `${days}d`;
    }

    const weeks = Math.floor(days / 7);
    if (weeks < 5) {
        return `${weeks}w`;
    }

    return formatDate(dateString);
};
</script>
