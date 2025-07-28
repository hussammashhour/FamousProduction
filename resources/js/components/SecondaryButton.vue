<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center rounded-md border border-secondary-200 bg-secondary-100 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-secondary-500 shadow-sm transition duration-150 ease-in-out hover:bg-secondary-200 focus:outline-none focus:ring-2 focus:ring-secondary-200 focus:ring-offset-2 disabled:opacity-25"
    >
        <slot />
    </button>
</template>
