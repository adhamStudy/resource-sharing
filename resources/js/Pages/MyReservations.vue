<template>
    <div class="max-w-6xl mx-auto py-10 px-4" dir="rtl">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">
            حجوزاتي
        </h1>

        <div v-if="reservations.length === 0" class="text-center text-gray-500">
            لا توجد حجوزات حتى الآن.
        </div>

        <div
            v-for="reservation in reservations"
            :key="reservation.id"
            class="bg-white shadow-md rounded-xl overflow-hidden mb-6 border"
        >
            <div class="md:flex gap-6">
                <!-- Resource Image -->
                <div
                    class="md:w-1/3 flex items-center justify-center bg-gray-50 p-4"
                >
                    <img
                        v-if="!reservation.resource.image"
                        src="/public/images/resource.png"
                        alt="المورد"
                        class="w-48 h-48 object-cover rounded-lg shadow"
                    />
                    <img
                        v-else
                        :src="'/' + reservation.resource.image"
                        alt="المورد"
                        class="w-48 h-48 object-cover rounded-lg shadow"
                    />
                </div>

                <!-- Details -->
                <div class="md:w-2/3 p-6 space-y-4">
                    <h2 class="text-2xl font-semibold text-indigo-700">
                        {{ reservation.resource.title }}
                    </h2>
                    <p class="text-gray-700 text-base leading-relaxed">
                        {{ reservation.resource.description }}
                    </p>

                    <div
                        class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600 mt-4"
                    >
                        <div>
                            <span class="font-semibold">تاريخ البداية:</span>
                            {{ reservation.start_date }}
                        </div>
                        <div>
                            <span class="font-semibold">تاريخ الانتهاء:</span>
                            {{ reservation.end_date }}
                        </div>
                        <div>
                            <span class="font-semibold">تم الحجز بواسطة:</span>
                            {{ reservation.user.name }} (أنت)
                        </div>
                        <div>
                            <span class="font-semibold">المالك:</span>
                            {{ reservation.owner.name }} -
                            {{ reservation.owner.email }}
                        </div>
                    </div>

                    <!-- Release Button -->
                    <div class="mt-6">
                        <button
                            @click="releaseResource(reservation.resource.id)"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm"
                        >
                            إلغاء الحجز
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import { route } from "ziggy-js";

defineProps({
    reservations: Array,
});

const releaseResource = (resourceId) => {
    if (confirm("هل أنت متأكد أنك تريد إلغاء الحجز؟")) {
        router.post(
            route("resources.release", resourceId),
            {},
            {
                preserveScroll: true,
                onSuccess: () => {
                    alert("تم إلغاء الحجز بنجاح.");
                },
                onError: () => {
                    alert("فشل في إلغاء الحجز.");
                },
            }
        );
    }
};
</script>
