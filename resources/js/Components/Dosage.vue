<script setup>
    import {useForm} from "@inertiajs/inertia-vue3";

    const props = defineProps({
        take: Object,
        dosage: Object
    })

    const form = useForm({
        dosage_id: props.dosage.id,
        taken_id: props.take?.id
    })

    const takeDose = () => {
        form.post(route('doses.take', form.dosage_id), {

        })
    }

    const removeDose = () => {
        form.delete(route('doses.untake', form.taken_id))
    }
</script>

<template>
    <div class="my-4 inline-flex text-center justify-center items-center center mr-4">
        <div v-if="take !== undefined">
            <button class="bg-teal-500 text-white px-2 py-1 block rounded-md" @click="removeDose">Undo</button>
            <span class="text-gray-500 text-sm"> Taken at {{new Date(take.taken_at*1000).toLocaleTimeString()}}</span>
        </div>
        <form @submit.prevent="takeDose" v-else>
            <button class="bg-green-500 text-white px-2 py-1 block rounded-md">Take Dose</button>
        </form>
    </div>

</template>
