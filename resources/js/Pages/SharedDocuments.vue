<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Shared Documents" />

    <AuthenticatedLayout>
        <template #header>
            <div class="w-full">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Shared Documents
                </h2>
            </div>
        </template>
    </AuthenticatedLayout>
</template>
