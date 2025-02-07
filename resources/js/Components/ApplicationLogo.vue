<script setup>
defineProps({
    class: String,
    showAppName: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <div class="flex items-center gap-x-2">
        <img class="h-16 aspect-square" :class="class" src="/appIcon.png" />
        <span v-if="showAppName" class="font-medium text-primary"
            >FileSync</span
        >
    </div>
</template>
