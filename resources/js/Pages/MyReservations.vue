<template>
    <div class="py-6 sm:py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-4 sm:p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-900">
                            My Reservations
                        </h1>
                        <button
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            Browse Resources
                        </button>
                    </div>

                    <!-- Flash Message (if needed) -->
                    <div
                        v-if="flashMessage"
                        class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert"
                    >
                        <span class="block sm:inline">{{ flashMessage }}</span>
                    </div>

                    <!-- Reservations List -->
                    <div
                        v-if="reservationsData.length === 0"
                        class="text-center py-12"
                    >
                        <div class="text-gray-500">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-12 w-12 mx-auto text-gray-400"
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
                            <h3 class="mt-2 text-lg font-medium text-gray-900">
                                No reservations found
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                You don't have any active reservations.
                            </p>
                            <div class="mt-6">
                                <button
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Browse Available Resources
                                </button>
                            </div>
                        </div>
                    </div>

                    <div v-else class="space-y-6">
                        <div
                            v-for="reservation in sortedReservations"
                            :key="reservation.id"
                            class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden"
                        >
                            <div class="p-4 sm:p-5">
                                <div
                                    class="flex items-center justify-between mb-4"
                                >
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="h-6 w-6 text-indigo-600"
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
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <h2
                                                class="text-lg font-medium text-gray-900"
                                            >
                                                Resource #{{
                                                    reservation.resource_id
                                                }}
                                            </h2>
                                            <p class="text-sm text-gray-500">
                                                Reservation ID:
                                                {{ reservation.id }}
                                            </p>
                                        </div>
                                    </div>
                                    <div
                                        class="hidden sm:flex sm:flex-col sm:items-end"
                                    >
                                        <span
                                            :class="[
                                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                                isActive(reservation)
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-gray-100 text-gray-800',
                                            ]"
                                        >
                                            {{
                                                isActive(reservation)
                                                    ? "Active"
                                                    : "Expired"
                                            }}
                                        </span>
                                    </div>
                                </div>

                                <div class="sm:flex sm:justify-between">
                                    <div
                                        class="grid grid-cols-2 gap-4 mb-4 sm:mb-0"
                                    >
                                        <div>
                                            <div
                                                class="text-sm font-medium text-gray-500"
                                            >
                                                Start Date
                                            </div>
                                            <div
                                                class="mt-1 text-sm text-gray-900"
                                            >
                                                {{
                                                    formatDate(
                                                        reservation.start_date
                                                    )
                                                }}
                                            </div>
                                        </div>
                                        <div>
                                            <div
                                                class="text-sm font-medium text-gray-500"
                                            >
                                                End Date
                                            </div>
                                            <div
                                                class="mt-1 text-sm text-gray-900"
                                            >
                                                {{
                                                    formatDate(
                                                        reservation.end_date
                                                    )
                                                }}
                                            </div>
                                        </div>
                                        <div class="col-span-2">
                                            <div
                                                class="text-sm font-medium text-gray-500"
                                            >
                                                Reserved Since
                                            </div>
                                            <div
                                                class="mt-1 text-sm text-gray-900"
                                            >
                                                {{
                                                    formatDateTime(
                                                        reservation.created_at
                                                    )
                                                }}
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="flex flex-col space-y-2 sm:space-y-0 sm:space-x-2 sm:flex-row mt-4 sm:mt-0"
                                    >
                                        <button
                                            @click="
                                                extendReservation(reservation)
                                            "
                                            :disabled="!isActive(reservation)"
                                            class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed"
                                        >
                                            Extend
                                        </button>
                                        <button
                                            @click="
                                                releaseReservation(reservation)
                                            "
                                            :disabled="!isActive(reservation)"
                                            class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed"
                                        >
                                            Release
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Progress bar for reservation duration -->
                            <div
                                v-if="isActive(reservation)"
                                class="bg-gray-100 h-2"
                            >
                                <div
                                    class="bg-indigo-600 h-2"
                                    :style="{
                                        width:
                                            calculateProgress(reservation) +
                                            '%',
                                    }"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Extension Modal -->
            <div
                v-if="showExtensionModal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
            >
                <div
                    class="bg-white rounded-lg shadow-xl max-w-md w-full p-6"
                    @click.stop
                >
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-medium text-gray-900">
                            Extend Reservation
                        </h2>
                        <button
                            @click="closeExtensionModal"
                            class="text-gray-400 hover:text-gray-500"
                        >
                            <svg
                                class="h-6 w-6"
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
                    </div>

                    <div class="mb-4">
                        <p class="text-sm text-gray-500">
                            Current end date:
                            <span class="font-medium">{{
                                selectedReservation
                                    ? formatDate(selectedReservation.end_date)
                                    : ""
                            }}</span>
                        </p>
                    </div>

                    <div class="mb-4">
                        <label
                            for="extension-days"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Extension Period (days)
                        </label>
                        <select
                            id="extension-days"
                            v-model="extensionDays"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                        >
                            <option value="7">1 week (7 days)</option>
                            <option value="14">2 weeks (14 days)</option>
                            <option value="30">1 month (30 days)</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <p class="text-sm text-gray-500">
                            New end date:
                            <span class="font-medium">{{ newEndDate }}</span>
                        </p>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button
                            @click="closeExtensionModal"
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Cancel
                        </button>
                        <button
                            @click="handleExtension"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Confirm Extension
                        </button>
                    </div>
                </div>
            </div>

            <!-- Release Confirmation Modal -->
            <div
                v-if="showReleaseModal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
            >
                <div
                    class="bg-white rounded-lg shadow-xl max-w-md w-full p-6"
                    @click.stop
                >
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-medium text-gray-900">
                            Release Reservation
                        </h2>
                        <button
                            @click="closeReleaseModal"
                            class="text-gray-400 hover:text-gray-500"
                        >
                            <svg
                                class="h-6 w-6"
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
                    </div>

                    <div class="mb-6">
                        <p class="text-sm text-gray-500">
                            Are you sure you want to release this reservation?
                            This action cannot be undone.
                        </p>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button
                            @click="closeReleaseModal"
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Cancel
                        </button>
                        <button
                            @click="handleRelease"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                        >
                            Release
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";

// Hardcoded data from your sample
const userData = {
    id: 2,
    name: "adhamii",
    email: "adhmalslahy@gmail.com",
};

const reservationsData = ref([
    {
        id: 1,
        user_id: 2,
        resource_id: 3,
        start_date: "2025-04-30",
        end_date: "2025-05-07",
        created_at: "2025-04-30T13:33:29.000000Z",
        updated_at: "2025-04-30T13:33:29.000000Z",
    },
    {
        id: 2,
        user_id: 2,
        resource_id: 6,
        start_date: "2025-04-30",
        end_date: "2025-05-07",
        created_at: "2025-04-30T13:52:32.000000Z",
        updated_at: "2025-04-30T13:52:32.000000Z",
    },
    {
        id: 3,
        user_id: 2,
        resource_id: 5,
        start_date: "2025-05-07",
        end_date: "2025-05-14",
        created_at: "2025-05-07T13:52:24.000000Z",
        updated_at: "2025-05-07T13:52:24.000000Z",
    },
]);

// State for modals and UI
const showExtensionModal = ref(false);
const showReleaseModal = ref(false);
const selectedReservation = ref(null);
const extensionDays = ref("7");
const flashMessage = ref("");

// Sort reservations by start date (newest first) and then by active status
const sortedReservations = computed(() => {
    return [...reservationsData.value].sort((a, b) => {
        // First sort by active status
        const aActive = isActive(a);
        const bActive = isActive(b);

        if (aActive && !bActive) return -1;
        if (!aActive && bActive) return 1;

        // Then sort by start date (newest first)
        return new Date(b.start_date) - new Date(a.start_date);
    });
});

// Calculate new end date based on the extension days
const newEndDate = computed(() => {
    if (!selectedReservation.value) return "";

    const endDate = new Date(selectedReservation.value.end_date);
    endDate.setDate(endDate.getDate() + parseInt(extensionDays.value));

    return formatDate(endDate.toISOString().split("T")[0]);
});

// Check if a reservation is currently active
function isActive(reservation) {
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const endDate = new Date(reservation.end_date);
    return endDate >= today;
}

// Calculate progress percentage for the reservation timeline
function calculateProgress(reservation) {
    const startDate = new Date(reservation.start_date);
    const endDate = new Date(reservation.end_date);
    const today = new Date();

    const totalDays = (endDate - startDate) / (1000 * 60 * 60 * 24);
    const elapsedDays = (today - startDate) / (1000 * 60 * 60 * 24);

    const progress = (elapsedDays / totalDays) * 100;
    return Math.min(Math.max(progress, 0), 100); // Ensure between 0-100
}

// Format date for display
function formatDate(dateString) {
    const options = { year: "numeric", month: "long", day: "numeric" };
    return new Date(dateString).toLocaleDateString(undefined, options);
}

// Format date and time for display
function formatDateTime(dateTimeString) {
    const options = {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    };
    return new Date(dateTimeString).toLocaleDateString(undefined, options);
}

// Extension modal functions
function extendReservation(reservation) {
    selectedReservation.value = reservation;
    extensionDays.value = "7"; // Reset to default
    showExtensionModal.value = true;
}

function closeExtensionModal() {
    showExtensionModal.value = false;
    selectedReservation.value = null;
}

function handleExtension() {
    // Placeholder for when you implement actual functionality
    // This is where you'd make an API call to extend the reservation

    // For now, just update the local data to simulate success
    if (selectedReservation.value) {
        const index = reservationsData.value.findIndex(
            (r) => r.id === selectedReservation.value.id
        );
        if (index !== -1) {
            const endDate = new Date(selectedReservation.value.end_date);
            endDate.setDate(endDate.getDate() + parseInt(extensionDays.value));

            // Create a new object to ensure reactivity
            const updatedReservation = {
                ...reservationsData.value[index],
                end_date: endDate.toISOString().split("T")[0],
                updated_at: new Date().toISOString(),
            };

            // Update the array
            reservationsData.value[index] = updatedReservation;

            // Show success message
            flashMessage.value = "Reservation successfully extended!";
            setTimeout(() => {
                flashMessage.value = "";
            }, 3000);
        }
    }

    closeExtensionModal();
}

// Release modal functions
function releaseReservation(reservation) {
    selectedReservation.value = reservation;
    showReleaseModal.value = true;
}

function closeReleaseModal() {
    showReleaseModal.value = false;
    selectedReservation.value = null;
}

function handleRelease() {
    // Placeholder for when you implement actual functionality
    // This is where you'd make an API call to release the reservation

    // For now, just remove from local data to simulate success
    if (selectedReservation.value) {
        const index = reservationsData.value.findIndex(
            (r) => r.id === selectedReservation.value.id
        );
        if (index !== -1) {
            reservationsData.value.splice(index, 1);

            // Show success message
            flashMessage.value = "Reservation successfully released!";
            setTimeout(() => {
                flashMessage.value = "";
            }, 3000);
        }
    }

    closeReleaseModal();
}

// If you need to simulate empty state for testing
function clearReservations() {
    reservationsData.value = [];
}

// For testing: to restore original data
function resetData() {
    reservationsData.value = [
        {
            id: 1,
            user_id: 2,
            resource_id: 3,
            start_date: "2025-04-30",
            end_date: "2025-05-07",
            created_at: "2025-04-30T13:33:29.000000Z",
            updated_at: "2025-04-30T13:33:29.000000Z",
        },
        {
            id: 2,
            user_id: 2,
            resource_id: 6,
            start_date: "2025-04-30",
            end_date: "2025-05-07",
            created_at: "2025-04-30T13:52:32.000000Z",
            updated_at: "2025-04-30T13:52:32.000000Z",
        },
        {
            id: 3,
            user_id: 2,
            resource_id: 5,
            start_date: "2025-05-07",
            end_date: "2025-05-14",
            created_at: "2025-05-07T13:52:24.000000Z",
            updated_at: "2025-05-07T13:52:24.000000Z",
        },
    ];
}
</script>
