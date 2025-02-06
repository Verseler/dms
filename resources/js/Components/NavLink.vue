<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
    prependIcon: {
        type: String,
    },
});

const classes = computed(() =>
    props.active
        ? 'py-2 px-3 font-medium text-blue-900 focus:outline-none focus:border-blue-700 bg-primary rounded transition duration-150 ease-in-out'
        : 'py-2 px-3 font-medium text-gray-500 focus:outline-none focus:text-gray-700 hover:text-gray-700 hover:border-gray-300 focus:border-gray-300 transition duration-150 ease-in-out',
);
</script>

<template>
    <Link :href="href" :class="classes" class="flex items-center gap-x-1">
        <v-icon v-if="prependIcon" :icon="prependIcon" />
        <slot />
    </Link>
</template>
