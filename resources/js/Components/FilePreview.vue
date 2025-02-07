<script setup>
defineProps({
    filePath: {
        type: String,
        required: true,
    },
    fileType: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <img
        v-if="/image/i.test(fileType)"
        class="h-full p-1 aspect-square"
        :src="`/${filePath}`"
    />
    <div v-else>{{ filePath.slice(0, 20) }}</div>
</template>
