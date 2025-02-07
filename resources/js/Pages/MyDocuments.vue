<script setup>
import DocumentShareBtn from '@/Components/DocumentShareBtn.vue';
import FilePreview from '@/Components/FilePreview.vue';
import RecipientList from '@/Components/RecipientList.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    documents: Object,
    userEmails: Array,
});

const headers = [
    { title: 'Title', key: 'title' },
    { title: 'File', key: 'file_path' },
    { title: 'Type', key: 'file_type' },
    { title: 'Owner Name', key: 'user.name' },
    { title: 'Recipients', key: 'shared_users' },
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
                class="shadow min-h-96"
            >
                <template v-slot:item.file_path="{ item }">
                    <FilePreview
                        :file-type="item.file_type"
                        :file-path="item.file_path"
                    />
                </template>

                <template v-slot:item.shared_users="{ item }">
                    <RecipientList :recipients="item.shared_users" />
                </template>

                <!-- Action Buttons -->
                <template v-slot:item.action="{ item }">
                    <a :download="item.title" :href="item.file_path">
                        <v-btn
                            icon="mdi-file-download"
                            size="small"
                            variant="text"
                        />
                    </a>

                    <a :href="`/${item.file_path}`" target="_blank">
                        <v-btn
                            icon="mdi-open-in-new"
                            size="small"
                            variant="text"
                            color="primary"
                        />
                    </a>

                    <DocumentShareBtn
                        :documentId="item.id"
                        :userEmails="userEmails"
                    />

                    <Link
                        :href="route('document.softDestroy', { id: item.id })"
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
