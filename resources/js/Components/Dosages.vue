<script setup>
    import Dosage from "./Dosage.vue";

    const props = defineProps({
        dosages: Array
    })

</script>

<template>
    <div>
        <div v-for="dosage in dosages">
            <div>{{dosage.medication.name}} <span class="text-sm text-teal-500"> (<a :href="route('dosage.edit', dosage.id)">Edit</a>)</span> </div>
            <div class="uppercase">
                Take {{dosage.multiplier}}x/{{dosage.amount}} {{dosage.interval}}
                <span v-if="dosage.interval === 'weekly'">
                    On
                    <span v-for="d in dosage.dotw.split('')">
                        {{d}}
                    </span>
                </span>
            </div>
            <div v-if="dosage.instructions" class="text-sm text-gray-600">
                Instructions: {{dosage.instructions}}
            </div>
            <template v-if="dosage.interval === 'daily'">

                <template v-for="take in dosage.takes">
                    <Dosage :dosage="dosage" :take="take"></Dosage>
                </template>
                <template v-for="i in new Array(dosage.multiplier - dosage.takes.length)">
                    <Dosage :dosage="dosage"></Dosage>
                </template>
            </template>
        </div>
    </div>

</template>
