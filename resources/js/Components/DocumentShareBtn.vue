<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { computed } from 'vue';

const props = defineProps({
    documentId: Number,
    userEmails: Array,
});

const recommendationEmails = computed(() =>
    props.userEmails.map((user) => user['email']),
);

const form = useForm({
    documentId: props.documentId,
    recipientEmail: null,
});

// const search = debounce((value) => {
//     console.log(value);
//     router.get(route('recipient.search', { search: value }));
// }, 500);

function submitShare() {
    form.post(route('document.share'));
}
</script>

<template>
    <v-dialog max-width="500">
        <template v-slot:activator="{ props: activatorProps }">
            <v-btn
                v-bind="activatorProps"
                icon="mdi-share-variant"
                size="small"
                variant="text"
                color="#22c55e"
            />
        </template>

        <!-- Content -->
        <template v-slot:default="{ isActive }">
            <form @submit.prevent="submitShare">
                <v-card rounded="lg">
                    <v-card-title
                        class="d-flex justify-space-between align-center"
                    >
                        <div class="text-h5 text-medium-emphasis ps-2">
                            Share Document
                        </div>

                        <v-btn
                            icon="mdi-close"
                            variant="text"
                            @click="isActive.value = false"
                        ></v-btn>
                    </v-card-title>

                    <v-divider class="mb-4"></v-divider>

                    <v-card-text>
                        <div class="mb-4 text-medium-emphasis">
                            Share documents to your collaborators by providing
                            their email.
                        </div>

                        <div class="mb-2">Recipient</div>
                        <v-autocomplete
                            v-model="form.recipientEmail"
                            :items="recommendationEmails"
                            placeholder="Email"
                            prepend-inner-icon="mdi-email"
                            variant="outlined"
                            density="comfortable"
                            no-data-text="Email not found."
                            auto-select-first
                        />
                        <!-- v-on:update:search="search" -->
                    </v-card-text>

                    <v-divider class="mt-2"></v-divider>

                    <v-card-actions class="justify-end my-2 d-flex">
                        <v-btn
                            class="text-none"
                            rounded="xl"
                            text="Cancel"
                            @click="isActive.value = false"
                        ></v-btn>

                        <v-btn
                            class="text-none"
                            color="primary"
                            rounded="xl"
                            text="Send"
                            variant="flat"
                            type="submit"
                            @click="isActive.value = false"
                        ></v-btn>
                    </v-card-actions>
                </v-card>
            </form>
        </template>
    </v-dialog>
</template>
