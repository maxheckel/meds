<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import DangerButton from "./DangerButton.vue";

const form = useForm({
    name: '',
    dosage: '',
    instructions: '',
    interval: '',
    dotw: [],
    startDate: new Date().toDateString(),
    noEndDate: false,
    endDate: undefined,
    multiplier: '1',
});

const props = defineProps({
    medication: Object
})

if (props.medication !== undefined){

    form.name = props.medication.name
    form.dosage = props.medication.dosage.amount;
    form.interval = props.medication.dosage.interval;
    form.dotw = props.medication.dosage.dotw;
    form.instructions = props.medication.dosage.instructions;
    form.startDate = props.medication.dosage.start;
    form.endDate = props.medication.dosage.end;
    if (form.endDate == null){
        form.noEndDate = true;
    }
    form.multiplier = ''+props.medication.dosage.multiplier;
}

const deleteMeds = () => {
    const deleteForm = useForm()
    deleteForm.delete(route('dosage.destroy', props.medication.dosage.id))
}
const submit = () => {
    if (props.medication?.id > 0){
        form.put(route('dosage.update', props.medication.dosage.id))
    } else {
        form.post(route('meds.store'), );
    }

};
</script>

<template>
    <form @submit.prevent="submit" class="text-md">
        <div v-if="medication == undefined">
            <InputLabel class="text-md" for="email" value="Medication Name" />
            <TextInput
                id="name"
                v-model="form.name"
                type="text"
                class="mt-1 block w-full"
                required
            />
            <InputError class="mt-2" :message="form.errors.name" />
        </div>
        <div v-else>
            Updating {{medication.name}}
        </div>
        <div class="mt-4">
            <InputLabel class="text-md" for="email" value="Dosage" />
            <TextInput
                id="dosage"
                v-model="form.dosage"
                type="text"
                class="mt-1 block w-full"
                required
            />
            <InputError class="mt-2" :message="form.errors.dosage" />
        </div>
        <div class="mt-4" >
            <InputLabel class="text-md" for="email" value="Start Date" />
            <TextInput
                id="startDate"
                v-model="form.startDate"
                type="date"
                class="mt-1 block w-full"
                required
            />
            <InputError class="mt-2" :message="form.errors.startDate" />
        </div>
        <div class="mt-4" v-if="!form.noEndDate">
            <InputLabel class="text-md" for="email" value="End Date" />
            <TextInput
                id="endDate"
                v-model="form.endDate"
                type="date"
                class="mt-1 block w-full"
                required
            />
            <InputError class="mt-2" :message="form.errors.endDate" />
        </div>
        <div class="mt-4">
            <input type="checkbox" class="inline-block mr-2" name="noEndDate" v-model="form.noEndDate">
            <InputLabel class="text-md inline" value="No End Date" for="noEndDate"></InputLabel>
        </div>





        <div class="mt-4">
            <InputLabel class="text-md" for="interval" value="How Often" />
            <select v-model="form.interval" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full">
                <option value="daily">Daily</option>
                <option value="weekly">Weekly</option>
                <option value="monthly">Monthly</option>
            </select>
            <InputError class="mt-2" :message="form.errors.interval" />
        </div>


        <div class="mt-4" v-if="form.interval === 'weekly'">
            <InputLabel class="text-md" for="email" value="Which Days?" />
            <div class="block" v-for="(day, index) in ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']">
                <input type="checkbox" class="inline-block mr-2" :id="'dotw'+index" v-model="form.dotw" :value="'' + index">
                <InputLabel class="text-md inline" :for="'dotw'+index" :value="day"></InputLabel>
            </div>
            <InputError class="mt-2" :message="form.errors.dotw" />
        </div>


        <div class="mt-4">
            <InputLabel class="text-md" for="multiplier" value="How many doses?" />

            <TextInput
                id="multiplier"
                v-model="form.multiplier"
                type="number"
                class="mt-1 block w-full"
                required
            />
            <InputError class="mt-2" :message="form.errors.multiplier" />
        </div>

        <div class="mt-4">
            <InputLabel class="text-md" for="multiplier" value="Instructions?" />

            <textarea
                id="multiplier"
                v-model="form.instructions"
                type="number"
                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full mt-1"
            />
            <InputError class="mt-2" :message="form.errors.instructions" />
        </div>


        <div class="flex items-center justify-end mt-4">
            <DangerButton @click="deleteMeds" v-if="medication !== undefined">
                Remove
            </DangerButton>
            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Submit
            </PrimaryButton>

        </div>
    </form>


</template>
