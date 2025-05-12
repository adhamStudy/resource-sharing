<template>
    <form @submit.prevent="register" class="px-4 py-6" dir="rtl">
        <div
            class="w-full sm:w-4/5 md:w-3/5 lg:w-1/2 xl:w-2/5 mx-auto max-w-md"
        >
            <!-- Name -->
            <div>
                <label for="name" class="label block text-sm font-medium mb-1">
                    الاسم الكامل
                </label>
                <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                />
                <div
                    v-if="form.errors.name"
                    class="input-error text-red-500 text-sm mt-1"
                >
                    {{ form.errors.name }}
                </div>
            </div>

            <!-- Email -->
            <div class="mt-3 sm:mt-4">
                <label for="email" class="label block text-sm font-medium mb-1">
                    البريد الإلكتروني
                </label>
                <input
                    id="email"
                    v-model="form.email"
                    type="text"
                    class="input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                />
                <div
                    v-if="form.errors.email"
                    class="input-error text-red-500 text-sm mt-1"
                >
                    {{ form.errors.email }}
                </div>
            </div>

            <!-- Phone -->
            <div class="mt-3 sm:mt-4">
                <label for="phone" class="label block text-sm font-medium mb-1">
                    رقم الهاتف
                </label>
                <input
                    id="phone"
                    v-model="form.phone"
                    type="tel"
                    class="input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                />
                <div
                    v-if="form.errors.phone"
                    class="input-error text-red-500 text-sm mt-1"
                >
                    {{ form.errors.phone }}
                </div>
            </div>

            <!-- Password -->
            <div class="mt-3 sm:mt-4">
                <label
                    for="password"
                    class="label block text-sm font-medium mb-1"
                >
                    كلمة المرور
                </label>
                <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                />
                <div
                    v-if="form.errors.password"
                    class="input-error text-red-500 text-sm mt-1"
                >
                    {{ form.errors.password }}
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="mt-3 sm:mt-4">
                <label
                    for="password_confirmation"
                    class="label block text-sm font-medium mb-1"
                >
                    تأكيد كلمة المرور
                </label>
                <input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="input w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                />
            </div>

            <!-- Submit -->
            <div class="mt-5 sm:mt-6">
                <button
                    class="btn-primary w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md"
                    type="submit"
                >
                    إنشاء حساب
                </button>
                <div class="mt-4 text-center text-sm">
                    لديك حساب بالفعل؟
                    <span>
                        <Link
                            href="/login"
                            as="button"
                            class="text-blue-600 dark:text-blue-400 hover:text-blue-800 font-medium mr-1"
                        >
                            تسجيل الدخول
                        </Link>
                    </span>
                </div>
            </div>
        </div>
    </form>
</template>

<script setup>
import { useForm, Link } from "@inertiajs/vue3";

const form = useForm({
    name: null,
    email: null,
    phone: null,
    password: null,
    password_confirmation: null,
});

const register = () => form.post("/user-account");
</script>
