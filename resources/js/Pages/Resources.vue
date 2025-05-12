<template>
    <div class="max-w-7xl mx-auto p-3 sm:p-6" dir="rtl">
        <div
            class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-6"
        >
            <h1
                class="text-2xl sm:text-3xl font-bold text-gray-800 mb-3 sm:mb-0"
            >
                موارد الحي
            </h1>

            <Link
                :href="route('create')"
                class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition text-sm sm:text-base w-full sm:w-auto text-center"
            >
                إنشاء مورد
            </Link>
        </div>

        <!-- Search and Filter Controls -->
        <div class="bg-white rounded-lg shadow-sm p-3 sm:p-4 mb-4 sm:mb-6">
            <form @submit.prevent="search">
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4"
                >
                    <!-- Search -->
                    <div>
                        <label
                            for="search"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            البحث
                        </label>
                        <input
                            id="search"
                            v-model="filters.search"
                            type="text"
                            placeholder="ابحث بالاسم..."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        />
                    </div>

                    <!-- Availability Filter -->
                    <div>
                        <label
                            for="availability"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            الحالة
                        </label>
                        <select
                            id="availability"
                            v-model="filters.availability"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="all">جميع الموارد</option>
                            <option value="available">متاح الآن</option>
                            <option value="unavailable">محجوز حالياً</option>
                        </select>
                    </div>

                    <!-- Sort By -->
                    <div>
                        <label
                            for="sort_by"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            الترتيب حسب
                        </label>
                        <select
                            id="sort_by"
                            v-model="filters.sort_by"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="created_at">تاريخ الإضافة</option>
                            <option value="title">الاسم</option>
                        </select>
                    </div>

                    <!-- Sort Direction -->
                    <div>
                        <label
                            for="sort_direction"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            الترتيب
                        </label>
                        <select
                            id="sort_direction"
                            v-model="filters.sort_direction"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="asc">تصاعدي</option>
                            <option value="desc">تنازلي</option>
                        </select>
                    </div>
                </div>

                <div
                    class="mt-4 flex flex-col sm:flex-row sm:justify-end space-y-2 sm:space-y-0 sm:space-x-3 sm:space-x-reverse"
                >
                    <button
                        type="button"
                        @click="resetFilters"
                        class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50 order-2 sm:order-1"
                    >
                        إعادة تعيين
                    </button>
                    <button
                        type="submit"
                        class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm order-1 sm:order-2"
                    >
                        تطبيق الفلاتر
                    </button>
                </div>
            </form>
        </div>

        <!-- Resources Count -->
        <div class="mb-3 sm:mb-4 text-gray-600 text-sm">
            عرض {{ resources.length }} مورد
        </div>

        <!-- Resources Grid -->
        <div
            v-if="resources.length > 0"
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6"
        >
            <div
                v-for="resource in resources"
                :key="resource.id"
                class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 hover:shadow-md transition-shadow"
            >
                <Link :href="route('show', resource.id)">
                    <!-- Resource Image -->
                    <div class="h-40 sm:h-48 bg-gray-200 relative">
                        <img
                            v-if="resource.image"
                            :src="'/' + resource.image"
                            :alt="resource.title"
                            class="w-full h-full object-cover"
                        />
                        <img
                            v-else
                            src="/public/images/resource.png"
                            :alt="resource.title"
                            class="w-full h-full object-cover"
                        />

                        <!-- Availability Badge -->
                        <div
                            class="absolute top-2 left-2 px-2 py-1 text-xs font-medium rounded-full"
                            :class="
                                resource.is_available
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-red-100 text-red-800'
                            "
                        >
                            {{ resource.is_available ? "متاح" : "محجوز" }}
                        </div>
                    </div>

                    <!-- Resource Details -->
                    <div class="p-3 sm:p-4">
                        <h2
                            class="text-base sm:text-lg font-semibold text-gray-900 mb-1"
                        >
                            {{ resource.title }}
                        </h2>
                        <p
                            class="text-xs sm:text-sm text-gray-600 line-clamp-2 mb-2 sm:mb-3"
                        >
                            {{ resource.description }}
                        </p>

                        <!-- Reservation Info (if reserved) -->
                        <div
                            v-if="
                                !resource.is_available && resource.reserved_by
                            "
                            class="mt-2 sm:mt-3 text-xs sm:text-sm"
                        >
                            <div class="flex items-center text-gray-600">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-3 w-3 sm:h-4 sm:w-4 ml-1"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>
                                حجز بواسطة: {{ resource.reserved_by.name }}
                            </div>
                            <div class="flex items-center text-gray-600 mt-1">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-3 w-3 sm:h-4 sm:w-4 ml-1"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                    />
                                </svg>
                                تم الحجز منذ
                                {{ resource.days_since_reservation }} يوم
                            </div>
                        </div>
                    </div>
                </Link>
            </div>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-8 sm:py-12">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-10 w-10 sm:h-12 sm:w-12 mx-auto text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1"
                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                />
            </svg>
            <h3
                class="mt-3 sm:mt-4 text-base sm:text-lg font-medium text-gray-900"
            >
                لا توجد موارد
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                جرب تعديل معايير البحث أو الفلاتر.
            </p>
            <button
                @click="resetFilters"
                class="mt-3 sm:mt-4 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
            >
                مسح الفلاتر
            </button>
        </div>
    </div>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import { reactive } from "vue";

const props = defineProps({
    resources: Array,
    filters: Object,
});

const filters = reactive({
    search: props.filters.search,
    availability: props.filters.availability,
    sort_by: props.filters.sort_by,
    sort_direction: props.filters.sort_direction,
});

const search = () => {
    router.get(route("resource"), filters, {
        preserveState: true,
        preserveScroll: true,
    });
};

const resetFilters = () => {
    filters.search = "";
    filters.availability = "all";
    filters.sort_by = "created_at";
    filters.sort_direction = "desc";
    search();
};
</script>
