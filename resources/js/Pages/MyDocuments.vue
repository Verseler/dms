<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    documents: Object,
});

const headers = [
    { title: 'Title', key: 'title' },
    { title: 'File', key: 'file_path' },
    { title: 'Type', key: 'file_type' },
    { title: 'Owner Name', key: 'user.name' },
    { title: 'Action', key: 'action' },
];

// Pagination state
const options = ref({
    page: props.documents.current_page,
    itemsPerPage: props.documents.per_page,
    sortBy: [],
});

// Watch for pagination and sorting changes
const handleUpdateOptions = (newOptions) => {
    options.value.page = newOptions.page;
    options.value.itemsPerPage = newOptions.itemsPerPage;
    options.value.sortBy = newOptions.sortBy;

    // Send request to Laravel with pagination & sorting params
    router.get(
        '/documents/owned',
        {
            page: options.value.page,
            per_page: options.value.itemsPerPage,
            sortBy: options.value.sortBy.length
                ? options.value.sortBy[0].key
                : null,
            sortOrder: options.value.sortBy.length
                ? options.value.sortBy[0].order === 'desc'
                    ? 'desc'
                    : 'asc'
                : null,
        },
        {
            preserveState: true,
            replace: true,
        },
    );
};
</script>

<template>
    <Head title="My Documents" />
    <AuthenticatedLayout>
        <template #header>
            <div class="w-full">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    My Documents
                </h2>
            </div>
        </template>

        <div class="p-4">
            <v-data-table-server
                :items-per-page="documents.per_page"
                :headers="headers"
                :items="documents.data"
                :items-length="documents.total"
                @update:options="handleUpdateOptions"
                class="min-h-96 shadow"
            >
                <!-- Action Buttons -->
                <template v-slot:item.action="{ item }">
                    <a :download="item.title" :href="item.file_type">
                        <v-btn
                            icon="mdi-file-download"
                            size="small"
                            variant="text"
                        />
                    </a>

                    <Link
                        :href="route('document.destroy', { id: item.id })"
                        method="delete"
                        as="button"
                        type="button"
                    >
                        <v-btn
                            icon="mdi-delete"
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
