<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from '@/Components/NavLink.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    show: Boolean,
});
</script>

<template>
    <!-- Primary Navigation Menu -->
    <div
        :class="{ hidden: !show, flex: show }"
        class="fixed flex-col justify-between min-h-screen shadow-sm w-60 border-e sm:w-80"
    >
        <nav class="p-4">
            <!-- Logo -->
            <Link :href="route('dashboard')">
                <ApplicationLogo class="h-12 mx-auto mb-4" />
            </Link>

            <v-divider></v-divider>

            <!-- Navigation Links -->
            <v-list class="flex flex-col gap-y-1">
                <NavLink
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                    prepend-icon="mdi-view-dashboard-outline"
                >
                    Dashboard
                </NavLink>
                <NavLink
                    :href="route('document.owned')"
                    :active="route().current('document.owned')"
                    prepend-icon="mdi-folder-account-outline"
                >
                    My Documents
                </NavLink>
                <NavLink
                    :href="route('document.shared')"
                    :active="route().current('document.shared')"
                    prepend-icon="mdi-folder-arrow-right-outline"
                >
                    Shared Documents
                </NavLink>
                <NavLink
                    :href="route('document.trash')"
                    :active="route().current('document.trash')"
                    prepend-icon="mdi-delete-outline"
                >
                    Trash
                </NavLink>
            </v-list>
        </nav>

        <!-- User Profile Dropdown -->
        <div class="flex items-center gap-x-2.5 border-t p-2">
            <Link
                :href="route('profile.edit')"
                class="flex w-full cursor-pointer items-center gap-x-2.5 text-start transition-transform active:scale-95"
            >
                <v-avatar color="primary">
                    {{ $page.props.auth.user.name[0].toUpperCase() }}
                </v-avatar>
                <!-- user name and role -->
                <div>
                    <p class="leading-5 text-neutral-900">
                        {{ $page.props.auth.user.name }}
                    </p>
                    <p class="text-sm leading-none text-neutral-500">Admin</p>
                </div>
            </Link>

            <!-- Logout Button -->
            <Link
                :href="route('logout')"
                method="post"
                as="button"
                type="button"
            >
                <v-icon
                    icon="mdi-logout"
                    class="px-4 transition-all opacity-70 hover:opacity-100 active:text-red-500"
                />
            </Link>
        </div>
    </div>
</template>
