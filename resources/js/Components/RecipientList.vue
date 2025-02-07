<script setup>
import { getNameInitial, getRandomColor } from '@/utils';

defineProps({
    recipients: Object,
});

const MAX_RECIPIENTS_VISIBLE = 2;
</script>

<template>
    <div v-if="recipients.length <= 0"></div>

    <div v-else>
        <v-avatar
            v-for="recipient in recipients.slice(0, MAX_RECIPIENTS_VISIBLE)"
            :key="recipient"
            :color="getRandomColor()"
            class="text-white"
        >
            <span>{{ getNameInitial(recipient.name[0]) }}</span>

            <v-tooltip activator="parent" location="start">
                {{ recipient.email }}
            </v-tooltip>
        </v-avatar>

        <v-avatar
            v-if="recipients.length > 2"
            class="text-white bg-neutral-200"
        >
            +{{ recipients.length }}
        </v-avatar>
    </div>
</template>
