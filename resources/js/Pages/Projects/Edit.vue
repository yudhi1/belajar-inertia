<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import { ArrowLeft } from 'lucide-vue-next'
import AppLayout from '@/Layouts/AppLayout.vue'
import Card from '@/components/ui/Card.vue'
import Button from '@/components/ui/Button.vue'
import Input from '@/components/ui/Input.vue'
import Textarea from '@/components/ui/Textarea.vue'
import Label from '@/components/ui/Label.vue'
import Select from '@/components/ui/Select.vue'

const props = defineProps({
    project: { type: Object, required: true },
})

const form = useForm({
    name: props.project.name,
    description: props.project.description ?? '',
    status: props.project.status,
})

function submit() {
    form.put(`/projects/${props.project.id}`)
}
</script>

<template>
    <Head title="Edit Project" />
    <AppLayout>
        <Link href="/projects" class="mb-4 inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground">
            <ArrowLeft class="size-4" /> Back to projects
        </Link>
        <h1 class="mb-6 text-2xl font-bold tracking-tight">Edit Project</h1>

        <Card class="max-w-2xl p-6">
            <form class="space-y-5" @submit.prevent="submit">
                <div>
                    <Label for="name">Name</Label>
                    <Input id="name" v-model="form.name" />
                    <p v-if="form.errors.name" class="mt-1 text-xs text-destructive">{{ form.errors.name }}</p>
                </div>
                <div>
                    <Label for="description">Description</Label>
                    <Textarea id="description" v-model="form.description" />
                    <p v-if="form.errors.description" class="mt-1 text-xs text-destructive">{{ form.errors.description }}</p>
                </div>
                <div>
                    <Label for="status">Status</Label>
                    <Select id="status" v-model="form.status">
                        <option value="active">Active</option>
                        <option value="completed">Completed</option>
                        <option value="on_hold">On Hold</option>
                    </Select>
                    <p v-if="form.errors.status" class="mt-1 text-xs text-destructive">{{ form.errors.status }}</p>
                </div>
                <div class="flex gap-2">
                    <Button type="submit" :disabled="form.processing">Save Changes</Button>
                    <Link href="/projects"><Button variant="outline" type="button">Cancel</Button></Link>
                </div>
            </form>
        </Card>
    </AppLayout>
</template>
