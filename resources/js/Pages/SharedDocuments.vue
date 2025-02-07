<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import FilePreview from '@/Components/FilePreview.vue';

const props = defineProps({
    sharedDocuments: Object,
});

const headers = [
    { title: 'Title', key: 'document.title' },
    { title: 'File', key: 'document.file_path' },
    { title: 'Type', key: 'document.file_type' },
    { title: 'Owner Name', key: 'document.user.name' },
    { title: 'Action', key: 'action' },
];

// Pagination state
const options = ref({
    page: props.sharedDocuments.current_page,
    itemsPerPage: props.sharedDocuments.per_page,
    sortBy: [],
});

// Watch for pagination and sorting changes
const handleUpdateOptions = (newOptions) => {
    options.value.page = newOptions.page;
    options.value.itemsPerPage = newOptions.itemsPerPage;
    options.value.sortBy = newOptions.sortBy;

    // Send request to Laravel with pagination & sorting params
    router.get(
        '/documents/shared',
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
    <Head title="Shared Documents" />
    <AuthenticatedLayout>
        <template #header>
            <div class="w-full">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Shared Documents
                </h2>
            </div>
        </template>

        <div class="p-4">
            <v-data-table-server
                :items-per-page="sharedDocuments.per_page"
                :headers="headers"
                :items="sharedDocuments.data"
                :items-length="sharedDocuments.total"
                @update:options="handleUpdateOptions"
                class="shadow min-h-96"
            >
                <template v-slot:item.document.file_path="{ item }">
                    <FilePreview
                        :file-path="item.document.file_path"
                        :file-type="item.document.file_type"
                    />
                </template>

                <!-- Action Buttons -->
                <template v-slot:item.action="{ item }">
                    <a
                        :download="item.document.title"
                        :href="item.document.file_path"
                    >
                        <v-btn
                            icon="mdi-file-download"
                            size="small"
                            variant="text"
                        />
                    </a>

                    <a :href="`/${item.document.file_path}`" target="_blank">
                        <v-btn
                            icon="mdi-open-in-new"
                            size="small"
                            variant="text"
                            color="primary"
                        />
                    </a>
                </template>
            </v-data-table-server>
        </div>
    </AuthenticatedLayout>
</template>
