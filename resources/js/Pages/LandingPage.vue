<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="FileSync" />
    <div class="min-h-screen bg-gray-50 text-black">
        <header
            class="container mx-auto flex h-16 items-center justify-between"
        >
            <ApplicationLogo class="h-10" show-app-name />
            <nav v-if="canLogin">
                <Link v-if="$page.props.auth.user" :href="route('dashboard')">
                    <v-btn color="primary" variant="flat">Dashboard</v-btn>
                </Link>

                <template v-else>
                    <div class="space-x-2">
                        <Link :href="route('login')">
                            <v-btn color="primary" variant="flat" width="100"
                                >Log in</v-btn
                            >
                        </Link>

                        <Link v-if="canRegister" :href="route('register')">
                            <v-btn
                                color="primary"
                                variant="outlined"
                                width="100"
                                >Register</v-btn
                            >
                        </Link>
                    </div>
                </template>
            </nav>
        </header>

        <main class="container mx-auto mt-16 py-10">
            <p
                class="mx-auto mb-4 mt-20 text-center text-6xl font-bold leading-snug"
            >
                Drag, Drop, Done. Managing Documents
                <span class="block"> Has Never Been This Easy.</span>
            </p>
            <p
                class="mx-auto mb-24 max-w-4xl text-center text-2xl text-neutral-500"
            >
                Access your files whenever and wherever you need them. Our
                platform makes it easy to stay connected to your information,
                and share it with others.
            </p>
            <div class="mx-auto aspect-[12.6/6] h-[32rem] rounded-lg border">
                <img
                    src="/hero_cover.png"
                    class="size-full rounded-lg object-cover"
                />
            </div>
        </main>
    </div>
</template>
