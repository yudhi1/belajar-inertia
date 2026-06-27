<script setup>
import { cn } from '@/lib/utils'
const props = defineProps({
    for: { type: String, default: undefined },
    class: { type: null, default: '' },
})
</script>

<template>
    <label :for="props.for" :class="cn('text-sm font-medium leading-none mb-1.5 block', props.class)">
        <slot />
    </label>
</template>
