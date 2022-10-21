<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import CreateMedication from "@/Components/CreateMedication.vue";

const props = defineProps({
    medication: Object
})
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <template v-if="props.medication !== undefined">
                    Update Medication
                </template>
                <template v-else>
                    Create Medication
                </template>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                    <CreateMedication :medication="props.medication"/>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
