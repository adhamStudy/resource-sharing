<template>
    <div class="flex flex-col items-center">
        <h1 class="text-center text-3xl">Ninja Reaction Timer</h1>

        <button
            class="bg-green-700 text-white rounded-sm shadow-sm w-fit px-4 py-2 mt-2"
            @click="start"
        >
            Click me to play
        </button>
    </div>
</template>

<script setup>
// create function called start to start the game

const start = () => {
    console.log("Game started");
};
</script>
