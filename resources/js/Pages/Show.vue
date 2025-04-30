<template>
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Back button -->
            <button
                @click="$inertia.visit(route('home'))"
                class="flex items-center text-indigo-600 hover:text-indigo-800 mb-6 transition-colors"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 mr-1"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"
                    />
                </svg>
                Back to resources
            </button>

            <!-- Main card -->
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <!-- Image section -->
                <div class="relative h-64 sm:h-80 md:h-96 bg-gray-200">
                    <img
                        :src="'/' + resource.image"
                        :alt="resource.title"
                        class="w-full h-full object-cover"
                        v-if="resource.image"
                    />
                    <div
                        v-else
                        class="w-full h-full flex items-center justify-center text-gray-500"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-16 w-16"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                            />
                        </svg>
                    </div>
                    <!-- Availability badge -->
                    <span
                        class="absolute top-4 right-4 px-3 py-1 rounded-full text-sm font-semibold"
                        :class="
                            resource.is_available
                                ? 'bg-green-100 text-green-800'
                                : 'bg-red-100 text-red-800'
                        "
                    >
                        {{
                            resource.is_available
                                ? "Available"
                                : "Not Available"
                        }}
                    </span>
                </div>

                <!-- Content section -->
                <div class="p-6 sm:p-8">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1
                                class="text-2xl sm:text-3xl font-bold text-gray-900"
                            >
                                {{ resource.title }}
                            </h1>
                            <p class="text-gray-500 text-sm mt-1">
                                Posted {{ formatDate(resource.created_at) }}
                            </p>
                        </div>
                        <!-- Price placeholder (you can add price field later) -->
                        <div
                            class="bg-indigo-50 text-indigo-800 px-3 py-1 rounded-lg text-sm font-semibold"
                        >
                            Free
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-2">
                            Description
                        </h2>
                        <p class="text-gray-600 whitespace-pre-line">
                            {{ resource.description }}
                        </p>
                    </div>

                    <!-- Owner info (if you have user relationship) -->
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-3">
                            Owner Information
                        </h2>
                        <div class="flex items-center">
                            <div
                                class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center mr-3"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6 text-gray-500"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">
                                    {{ user.name }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    Member since
                                    {{ formatDate(user.created_at) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div
                        class="mt-8 border-t border-gray-200 pt-6 flex flex-col sm:flex-row gap-4"
                    >
                        <button
                            v-if="resource.is_available"
                            @click="reserveResource"
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-3 px-6 rounded-lg font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center justify-center"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-2"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                            Reserve Now
                        </button>
                        <button
                            v-else
                            disabled
                            class="flex-1 bg-gray-300 text-gray-600 py-3 px-6 rounded-lg font-medium cursor-not-allowed flex items-center justify-center"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-2"
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
                            Currently Unavailable
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from "vue";
import { router } from "@inertiajs/vue3";
import { route } from "ziggy-js";

const props = defineProps({
    resource: Object,
    user: Object,
});

const formatDate = (dateString) => {
    const options = { year: "numeric", month: "long", day: "numeric" };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

const reserveResource = () => {
    router.post(`/resources/${props.resource.id}/reserve`, {
        onSuccess: () => {
            // Handle successful reservation
            alert("Resource reserved successfully!");
        },
        onError: (errors) => {
            // Handle errors
            alert(
                "Failed to reserve resource: " +
                    (errors.message || "Unknown error")
            );
        },
    });
};
</script>

<style scoped>
/* Custom styles if needed */
</style>
