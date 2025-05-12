<template>
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8" dir="rtl">
        <div class="max-w-3xl mx-auto">
            <!-- زر الرجوع -->
            <button
                @click="$inertia.visit(route('home'))"
                class="flex items-center text-indigo-600 hover:text-indigo-800 mb-6 transition-colors"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 ml-1"
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
                الرجوع إلى الموارد
            </button>

            <!-- البطاقة الرئيسية -->
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <!-- صورة المورد -->
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
                    <!-- حالة التوفر -->
                    <span
                        class="absolute top-4 left-4 px-3 py-1 rounded-full text-sm font-semibold"
                        :class="
                            resource.is_available
                                ? 'bg-green-100 text-green-800'
                                : 'bg-red-100 text-red-800'
                        "
                    >
                        {{ resource.is_available ? "متاح" : "غير متاح" }}
                    </span>
                </div>

                <!-- المحتوى -->
                <div class="p-6 sm:p-8">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1
                                class="text-2xl sm:text-3xl font-bold text-gray-900"
                            >
                                {{ resource.title }}
                            </h1>
                            <p class="text-gray-500 text-sm mt-1">
                                تم النشر في
                                {{ formatDate(resource.created_at) }}
                            </p>
                        </div>
                        <div
                            v-if="resource.user_id == user.id"
                            class="bg-red-50 hover:bg-red-500 hover:text-white hover:text-sm text-red-800 px-3 py-1 rounded-lg text-sm font-semibold cursor-pointer"
                            @click="deleteResource(resource.id)"
                        >
                            حذف
                        </div>
                    </div>

                    <!-- الوصف -->
                    <div class="mt-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-2">
                            الوصف
                        </h2>
                        <p class="text-gray-600 whitespace-pre-line">
                            {{ resource.description }}
                        </p>
                    </div>

                    <!-- معلومات المالك -->
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-3">
                            معلومات المالك
                        </h2>
                        <div class="flex items-center">
                            <div
                                class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center ml-3"
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
                                    {{ owner.name }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    عضو منذ {{ formatDate(user.created_at) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- الأزرار -->
                    <div
                        v-if="user.id !== resource.user_id"
                        class="mt-8 border-t border-gray-200 pt-6 flex flex-col sm:flex-row gap-4"
                    >
                        <button
                            v-if="resource.is_available"
                            @click="reserveResource"
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-3 px-6 rounded-lg font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center justify-center"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 ml-2"
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
                            احجز الآن
                        </button>
                        <button
                            v-else
                            disabled
                            class="flex-1 bg-gray-300 text-gray-600 py-3 px-6 rounded-lg font-medium cursor-not-allowed flex items-center justify-center"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 ml-2"
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
                            غير متاح حالياً
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
import { Link } from "@inertiajs/vue3";
const props = defineProps({
    resource: Object,
    owner: Object,
    user: Object,
});

const formatDate = (dateString) => {
    const options = { year: "numeric", month: "long", day: "numeric" };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

const reserveResource = () => {
    router.post(
        route("resources.reserve", props.resource.id),

        {
            onSuccess: () => {
                alert("Resource reserved successfully!");
            },
            onError: (errors) => {
                alert(
                    "Failed to reserve resource: " +
                        (errors.message || "Unknown error")
                );
            },
        }
    );
};

const deleteResource = (id) => {
    if (confirm("Are you sure you want to delete this resource?")) {
        router.delete(route("resources.destroy", id));
    }
};
</script>
