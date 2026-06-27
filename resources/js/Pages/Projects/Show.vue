<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { ArrowLeft, Plus, Pencil } from 'lucide-vue-next'
import AppLayout from '@/Layouts/AppLayout.vue'
import Card from '@/components/ui/Card.vue'
import Button from '@/components/ui/Button.vue'
import Badge from '@/components/ui/Badge.vue'

defineProps({
    project: { type: Object, required: true },
    tasks: { type: Array, default: () => [] },
})

const projectStatus = { active: 'Active', completed: 'Completed', on_hold: 'On Hold' }
const projectVariant = { active: 'info', completed: 'success', on_hold: 'warning' }
const taskStatus = { todo: 'To Do', in_progress: 'In Progress', done: 'Done' }
const taskVariant = { todo: 'secondary', in_progress: 'info', done: 'success' }
const priorityVariant = { low: 'secondary', medium: 'warning', high: 'destructive' }
</script>

<template>
    <Head :title="project.name" />
    <AppLayout>
        <Link href="/projects" class="mb-4 inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground">
            <ArrowLeft class="size-4" /> Back to projects
        </Link>

        <div class="mb-6 flex items-start justify-between">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-bold tracking-tight">{{ project.name }}</h1>
                    <Badge :variant="projectVariant[project.status]">{{ projectStatus[project.status] }}</Badge>
                </div>
                <p v-if="project.description" class="mt-1 max-w-2xl text-sm text-muted-foreground">
                    {{ project.description }}
                </p>
            </div>
            <Link :href="`/projects/${project.id}/edit`">
                <Button variant="outline"><Pencil /> Edit</Button>
            </Link>
        </div>

        <div class="mb-3 flex items-center justify-between">
            <h2 class="text-lg font-semibold">Tasks ({{ tasks.length }})</h2>
            <Link href="/tasks/create">
                <Button size="sm"><Plus /> Add Task</Button>
            </Link>
        </div>

        <Card v-if="tasks.length === 0" class="p-10 text-center">
            <p class="text-muted-foreground">No tasks for this project yet.</p>
        </Card>

        <Card v-else class="overflow-hidden">
            <table class="w-full text-sm">
                <thead class="border-b bg-muted/50 text-left text-muted-foreground">
                    <tr>
                        <th class="px-4 py-3 font-medium">Title</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                        <th class="px-4 py-3 font-medium">Priority</th>
                        <th class="px-4 py-3 font-medium">Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="task in tasks" :key="task.id" class="border-b last:border-0 hover:bg-muted/30">
                        <td class="px-4 py-3 font-medium">{{ task.title }}</td>
                        <td class="px-4 py-3"><Badge :variant="taskVariant[task.status]">{{ taskStatus[task.status] }}</Badge></td>
                        <td class="px-4 py-3"><Badge :variant="priorityVariant[task.priority]">{{ task.priority }}</Badge></td>
                        <td class="px-4 py-3 text-muted-foreground">{{ task.due_date ?? '—' }}</td>
                    </tr>
                </tbody>
            </table>
        </Card>
    </AppLayout>
</template>
