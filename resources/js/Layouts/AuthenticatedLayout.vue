<script setup>
import { ref } from 'vue';
import SideBar from '@/Components/SideBar.vue';
import { useForm } from '@inertiajs/vue3';

defineProps({
    hideSearch: Boolean,
    hideUpload: Boolean,
});

const showSidebar = ref(true);

const uploadForm = useForm({ documents: [] });
const searchForm = useForm({ query: null });

function handleSearch() {
    console.log(searchForm.query);
}

function handleUpload() {
    uploadForm.post(route('document.store'), {
        forceFormData: true,
        onSuccess: () => {
            uploadForm.reset('documents');
        },
    });
}
</script>

<template>
    <div>
        <SideBar :show="showSidebar" />

        <div class="min-h-screen bg-gray-100 ms-80">
            <header
                class="flex items-center h-16 px-4 bg-white border-b shadow-sm"
                v-if="$slots.header"
            >
                <!-- Hamburger (Mobile Screen) -->
                <!-- <div class="flex items-center sm:hidden">
                    <button
                        @click="showSidebar = !showSidebar"
                        class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                    >
                        //TODO: Change to vuetify icon later
                        <svg
                            class="w-6 h-6"
                            stroke="currentColor"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <path
                                :class="{
                                    hidden: showSidebar,
                                    'inline-flex': !showSidebar,
                                }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path
                                :class="{
                                    hidden: !showSidebar,
                                    'inline-flex': showSidebar,
                                }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div> -->

                <!-- Page Heading -->
                <slot name="header" />

                <div class="flex items-center gap-x-4">
                    <!-- Search Document -->
                    <v-text-field
                        v-if="!hideSearch"
                        v-model="searchForm.query"
                        width="300"
                        density="compact"
                        label="Search"
                        variant="outlined"
                        hide-details
                        single-line
                        append-inner-icon="mdi-magnify"
                        type:append-inner="submit"
                        @click:append-inner="handleSearch"
                    />

                    <!-- Upload Documents -->
                    <v-dialog max-width="700" v-if="!hideUpload">
                        <template v-slot:activator="{ props: activatorProps }">
                            <v-btn
                                v-bind="activatorProps"
                                prepend-icon="mdi-plus"
                                color="primary"
                            >
                                Upload
                            </v-btn>
                        </template>

                        <!-- Dialog Content -->
                        <template v-slot:default="{ isActive }">
                            <form @submit.prevent="handleUpload">
                                <v-card title="Upload Documents">
                                    <v-card-text>
                                        <v-file-upload
                                            v-model="uploadForm.documents"
                                            clearable
                                            density="default"
                                            multiple
                                        ></v-file-upload>
                                    </v-card-text>

                                    <v-card-actions>
                                        <v-btn
                                            variant="text"
                                            type="button"
                                            @click="isActive.value = false"
                                        >
                                            close
                                        </v-btn>
                                        <v-btn
                                            color="primary"
                                            variant="elevated"
                                            type="submit"
                                            @click="isActive.value = false"
                                        >
                                            upload
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </form>
                        </template>
                    </v-dialog>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
