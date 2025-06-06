<template>
    <form @submit.prevent="login" class="px-4 py-6" dir="rtl">
        <div
            class="w-full sm:w-4/5 md:w-3/4 lg:w-2/3 xl:w-1/2 mx-auto max-w-md"
        >
            <div>
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
                    class="input-error text-red-500 text-sm mt-1"
                    v-if="form.errors.email"
                >
                    {{ form.errors.email }}
                </div>
            </div>

            <div class="mt-4">
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
                    class="input-error text-red-500 text-sm mt-1"
                    v-if="form.errors.password"
                >
                    {{ form.errors.password }}
                </div>
            </div>

            <div class="mt-6">
                <button
                    class="btn-primary w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md"
                    type="submit"
                >
                    تسجيل الدخول
                </button>

                <div class="mt-4 text-center text-sm">
                    ليس لديك حساب؟
                    <span>
                        <Link
                            :href="route('user-account.create')"
                            as="button"
                            class="text-blue-600 dark:text-blue-400 hover:text-blue-800 font-medium mr-1"
                        >
                            إنشاء حساب
                        </Link>
                    </span>
                </div>
                <div class="mt-4 text-center">
                    <button
                        @click="loginWithGithub"
                        class="btn-secondary w-full py-2 px-4 bg-gray-800 hover:bg-gray-900 text-white font-medium rounded-md"
                    >
                        تسجيل الدخول باستخدام GitHub
                    </button>
                </div>
            </div>
        </div>
    </form>
</template>

<script setup>
import { useForm, Link } from "@inertiajs/vue3";
const form = useForm({
    email: "",
    password: "",
});
function loginWithGithub() {
    window.location.href = route("socialite.login"); // This will perform a full redirect
}
const login = () => form.post(route("login.store"));
</script>
