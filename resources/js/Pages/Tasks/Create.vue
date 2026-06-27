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
    projects: { type: Array, default: () => [] },
})

const form = useForm({
    project_id: props.projects[0]?.id ?? '',
    title: '',
    description: '',
    status: 'todo',
    priority: 'medium',
    due_date: '',
})

function submit() {
    form.post('/tasks')
}
</script>

<template>
    <Head title="New Task" />
    <AppLayout>
        <Link href="/tasks" class="mb-4 inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground">
            <ArrowLeft class="size-4" /> Back to tasks
        </Link>
        <h1 class="mb-6 text-2xl font-bold tracking-tight">New Task</h1>

        <Card class="max-w-2xl p-6">
            <form class="space-y-5" @submit.prevent="submit">
                <div>
                    <Label for="project_id">Project</Label>
                    <Select id="project_id" v-model="form.project_id">
                        <option v-if="projects.length === 0" value="">No projects available</option>
                        <option v-for="p in projects" :key="p.id" :value="p.id">{{ p.name }}</option>
                    </Select>
                    <p v-if="form.errors.project_id" class="mt-1 text-xs text-destructive">{{ form.errors.project_id }}</p>
                </div>
                <div>
                    <Label for="title">Title</Label>
                    <Input id="title" v-model="form.title" placeholder="Design the homepage" />
                    <p v-if="form.errors.title" class="mt-1 text-xs text-destructive">{{ form.errors.title }}</p>
                </div>
                <div>
                    <Label for="description">Description</Label>
                    <Textarea id="description" v-model="form.description" />
                    <p v-if="form.errors.description" class="mt-1 text-xs text-destructive">{{ form.errors.description }}</p>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div>
                        <Label for="status">Status</Label>
                        <Select id="status" v-model="form.status">
                            <option value="todo">To Do</option>
                            <option value="in_progress">In Progress</option>
                            <option value="done">Done</option>
                        </Select>
                    </div>
                    <div>
                        <Label for="priority">Priority</Label>
                        <Select id="priority" v-model="form.priority">
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </Select>
                    </div>
                    <div>
                        <Label for="due_date">Due Date</Label>
                        <Input id="due_date" v-model="form.due_date" type="date" />
                    </div>
                </div>
                <div class="flex gap-2">
                    <Button type="submit" :disabled="form.processing">Create Task</Button>
                    <Link href="/tasks"><Button variant="outline" type="button">Cancel</Button></Link>
                </div>
            </form>
        </Card>
    </AppLayout>
</template>
