<template>
    <div class="px-6 py-12">
        <!-- Hero Section -->
        <div
            class="relative w-full h-[500px] rounded-xl overflow-hidden shadow-lg mb-12"
        >
            <img
                src="/public/images/hero.jpg"
                alt="الحي"
                class="absolute inset-0 w-full h-full object-cover"
            />
            <div
                class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center text-center text-white px-4"
            >
                <h1 class="text-5xl font-bold mb-4">
                    مرحبًا بك في NeighborConnect
                </h1>
                <p class="text-xl max-w-2xl">
                    منصة مجتمعية لتبادل الموارد، مشاركة المنشورات، ورفع الشكاوى
                    — كل ذلك في مكان واحد.
                </p>
                <Link
                    href="/login"
                    class="mt-8 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-full"
                >
                    انضم إلى المجتمع
                </Link>
            </div>
        </div>

        <!-- Features Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-right">
            <Link
                :href="route('resource')"
                class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition"
            >
                <div
                    class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition"
                >
                    <img
                        src="/public/images/sharing.png"
                        alt="تبادل"
                        class="h-32 mx-auto mb-4"
                    />
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">
                        تبادل الموارد
                    </h2>
                    <p class="text-gray-600">
                        أعر أو استعر العناصر المفيدة من جيرانك بسهولة وأمان.
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
                        alt="منشورات"
                        class="h-32 mx-auto mb-4"
                    />
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">
                        مشاركة ومناقشة
                    </h2>
                    <p class="text-gray-600">
                        أنشئ منشورات لمشاركة الأفكار أو الإعلانات أو أحداث الحي.
                    </p>
                </div>
            </Link>

            <Link
                :href="route('posts.create')"
                class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition"
            >
                <div
                    class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition"
                >
                    <img
                        src="/public/images/complaint.png"
                        alt="شكاوى"
                        class="h-32 mx-auto mb-4"
                    />
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">
                        رفع الشكاوى
                    </h2>
                    <p class="text-gray-600">
                        قدّم الشكاوى أو الاقتراحات للمساهمة في تحسين الحياة
                        المجتمعية.
                    </p>
                </div>
            </Link>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { route } from "ziggy-js";
</script>
