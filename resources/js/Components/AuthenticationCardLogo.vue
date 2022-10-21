<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
</script>

<template>
    <Link :href="'/'">
       <ApplicationLogo style="width: 50px;"/>
    </Link>
</template>
