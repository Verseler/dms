<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    trash_documents: Object,
});

const headers = [
    { title: 'Title', key: 'title' },
    { title: 'File', key: 'file_path' },
    { title: 'Type', key: 'file_type' },
    { title: 'Owner Name', key: 'user.name' },
    { title: 'Action', key: 'action' },
];
</script>

<template>
    <Head title="Trash Documents" />

    <AuthenticatedLayout>
        <template #header>
            <div class="w-full">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Trash
                </h2>
            </div>
        </template>

        <div class="p-4">
            <v-data-table-server
                :items-per-page="trash_documents.per_page"
                :headers="headers"
                :items="trash_documents.data"
                :items-length="trash_documents.total"
                class="min-h-96 shadow"
            >
                <!-- File Preview -->
                <template v-slot:item.file_path="{ item }">
                    <!-- show image preview if file is an image or else show file path  -->
                    <img
                        v-if="/image/i.test(item.file_type)"
                        class="aspect-square h-full p-1"
                        :src="`/${item.file_path}`"
                    />
                    <img
                        v-else-if="/pdf/i.test(item.file_type)"
                        class="aspect-square h-full p-1"
                        src="https://res-academy.cache.wpscdn.com/images/seo_posts/20230705/8588d8f345b737b64a61e53b2a9c8128.png"
                    />
                    <img
                        v-else-if="/html/i.test(item.file_type)"
                        class="aspect-square h-full p-1"
                        src="https://cdn4.iconfinder.com/data/icons/file-extension-names-vol-5-1/512/38-512.png"
                    />

                    <div v-else>{{ item.file_path }}</div>
                </template>

                <!-- Action Buttons -->
                <template v-slot:item.action="{ item }">
                    <Link :href="route('document.restore', { id: item.id })">
                        <v-btn
                            icon="mdi-restore"
                            size="small"
                            variant="text"
                            color="green"
                        />
                    </Link>

                    <Link
                        :href="
                            route('document.permanentDestroy', { id: item.id })
                        "
                        method="delete"
                        as="button"
                        type="button"
                    >
                        <v-btn
                            icon="mdi-delete-forever"
                            size="small"
                            variant="text"
                            color="#ef4444"
                        />
                    </Link>
                </template>
            </v-data-table-server>
        </div>
    </AuthenticatedLayout>
</template>
