<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import Dosages from "@/Components/Dosages.vue";

const props = defineProps({
    'dosages': Array
})
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Welcome v-if="dosages.length === 0" />
                    <Dosages class="p-4" :dosages="dosages"/>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
