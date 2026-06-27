<script setup>
import {
    AlertDialogRoot,
    AlertDialogTrigger,
    AlertDialogPortal,
    AlertDialogOverlay,
    AlertDialogContent,
    AlertDialogTitle,
    AlertDialogDescription,
    AlertDialogCancel,
    AlertDialogAction,
} from 'reka-ui'
import Button from '@/components/ui/Button.vue'

defineProps({
    title: { type: String, default: 'Are you sure?' },
    description: { type: String, default: 'This action cannot be undone.' },
})
const emit = defineEmits(['confirm'])
</script>

<template>
    <AlertDialogRoot>
        <AlertDialogTrigger as-child>
            <slot name="trigger" />
        </AlertDialogTrigger>
        <AlertDialogPortal>
            <AlertDialogOverlay class="fixed inset-0 z-50 bg-black/50 data-[state=open]:animate-in data-[state=open]:fade-in-0" />
            <AlertDialogContent
                class="fixed left-1/2 top-1/2 z-50 w-full max-w-md -translate-x-1/2 -translate-y-1/2 rounded-xl border bg-card p-6 shadow-lg data-[state=open]:animate-in data-[state=open]:fade-in-0 data-[state=open]:zoom-in-95"
            >
                <AlertDialogTitle class="text-lg font-semibold">{{ title }}</AlertDialogTitle>
                <AlertDialogDescription class="mt-2 text-sm text-muted-foreground">
                    {{ description }}
                </AlertDialogDescription>
                <div class="mt-6 flex justify-end gap-2">
                    <AlertDialogCancel as-child>
                        <Button variant="outline">Cancel</Button>
                    </AlertDialogCancel>
                    <AlertDialogAction as-child>
                        <Button variant="destructive" @click="emit('confirm')">Delete</Button>
                    </AlertDialogAction>
                </div>
            </AlertDialogContent>
        </AlertDialogPortal>
    </AlertDialogRoot>
</template>
