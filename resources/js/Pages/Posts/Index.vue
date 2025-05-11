<template>
    <div class="py-4 sm:py-8">
        <div class="max-w-2xl mx-auto px-2 sm:px-4">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-3 sm:p-5 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
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
                    <div class="space-y-3 sm:space-y-4">
                        <div
                            v-if="posts.data.length === 0"
                            class="text-gray-500 text-center py-6"
                        >
                            No posts yet. Be the first to create one!
                        </div>

                        <div
                            v-for="post in posts.data"
                            :key="post.id"
                            class="p-3 bg-white rounded-lg border border-gray-200 hover:shadow-sm transition-shadow"
                        >
                            <Link
                                :href="route('posts.index', post.id)"
                                class="block"
                            >
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
                                    </div>
                                </div>
                            </Link>

                            <!-- Post Image with Modal Trigger - Moved outside of Link -->
                            <div
                                v-if="post.image"
                                class="mt-2 rounded-lg overflow-hidden cursor-pointer"
                                @click.stop.prevent="
                                    openImageModal(getImageUrl(post.image))
                                "
                            >
                                <img
                                    :src="getImageUrl(post.image)"
                                    :alt="post.title"
                                    class="w-full h-32 sm:h-40 object-cover rounded-lg hover:opacity-90 transition-opacity"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image Modal -->
            <div
                v-if="showImageModal"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-75"
                @click="closeImageModal"
            >
                <div class="relative max-w-4xl w-full" @click.stop>
                    <button
                        @click="closeImageModal"
                        class="absolute -top-10 right-0 text-white hover:text-gray-300 focus:outline-none"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-8 w-8"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                    <img
                        :src="currentImage"
                        alt="Full size post image"
                        class="max-h-[90vh] w-full object-contain"
                        @error="handleImageError"
                    />
                </div>
            </div>

            <!-- Floating Action Button (FAB) for Create Post -->
            <Link
                :href="route('posts.create')"
                class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 w-12 h-12 rounded-full bg-indigo-600 text-white flex items-center justify-center shadow-lg hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 z-10"
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
import { ref, onMounted, onUnmounted } from "vue";

const props = defineProps({
    posts: Object,
});

const showImageModal = ref(false);
const currentImage = ref("");
const imageLoadError = ref(false);

// Function to get image URL with proper path handling
const getImageUrl = (imagePath) => {
    if (!imagePath) return "";

    // If image path already starts with http/https or /, use it directly
    if (imagePath.startsWith("http") || imagePath.startsWith("/")) {
        return imagePath;
    }

    // Otherwise, prepend /storage/
    return `/storage/${imagePath}`;
};

const openImageModal = (imageUrl) => {
    if (!imageUrl) return;

    currentImage.value = imageUrl;
    showImageModal.value = true;
    imageLoadError.value = false;
    document.body.style.overflow = "hidden";
};

const closeImageModal = () => {
    showImageModal.value = false;
    document.body.style.overflow = "";
};

const handleImageError = () => {
    console.error("Failed to load image:", currentImage.value);
    imageLoadError.value = true;

    // You can add a toast notification or other feedback here if needed
};

const handleEscape = (e) => {
    if (e.key === "Escape") {
        closeImageModal();
    }
};

onMounted(() => {
    window.addEventListener("keydown", handleEscape);
});

onUnmounted(() => {
    window.removeEventListener("keydown", handleEscape);
    // Make sure to reset the body overflow in case component is unmounted with modal open
    document.body.style.overflow = "";
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
