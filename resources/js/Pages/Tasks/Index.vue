<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import { Plus, Pencil, Trash2 } from 'lucide-vue-next'
import AppLayout from '@/Layouts/AppLayout.vue'
import Card from '@/components/ui/Card.vue'
import Button from '@/components/ui/Button.vue'
import Badge from '@/components/ui/Badge.vue'
import ConfirmDialog from '@/components/ConfirmDialog.vue'

defineProps({
    tasks: { type: Array, default: () => [] },
})

const taskStatus = { todo: 'To Do', in_progress: 'In Progress', done: 'Done' }
const taskVariant = { todo: 'secondary', in_progress: 'info', done: 'success' }
const priorityVariant = { low: 'secondary', medium: 'warning', high: 'destructive' }

function destroy(id) {
    router.delete(`/tasks/${id}`, { preserveScroll: true })
}
</script>

<template>
    <Head title="Tasks" />
    <AppLayout>
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Tasks</h1>
                <p class="text-sm text-muted-foreground">All tasks across your projects.</p>
            </div>
            <Link href="/tasks/create">
                <Button><Plus /> New Task</Button>
            </Link>
        </div>

        <Card v-if="tasks.length === 0" class="p-12 text-center">
            <p class="text-muted-foreground">No tasks yet. Create your first one.</p>
        </Card>

        <Card v-else class="overflow-hidden">
            <table class="w-full text-sm">
                <thead class="border-b bg-muted/50 text-left text-muted-foreground">
                    <tr>
                        <th class="px-4 py-3 font-medium">Title</th>
                        <th class="px-4 py-3 font-medium">Project</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                        <th class="px-4 py-3 font-medium">Priority</th>
                        <th class="px-4 py-3 font-medium">Due Date</th>
                        <th class="px-4 py-3 text-right font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="task in tasks" :key="task.id" class="border-b last:border-0 hover:bg-muted/30">
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ task.title }}</div>
                            <div v-if="task.description" class="line-clamp-1 text-xs text-muted-foreground">
                                {{ task.description }}
                            </div>
                        </td>
                        <td class="px-4 py-3 text-muted-foreground">{{ task.project?.name ?? '—' }}</td>
                        <td class="px-4 py-3"><Badge :variant="taskVariant[task.status]">{{ taskStatus[task.status] }}</Badge></td>
                        <td class="px-4 py-3"><Badge :variant="priorityVariant[task.priority]">{{ task.priority }}</Badge></td>
                        <td class="px-4 py-3 text-muted-foreground">{{ task.due_date ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-1">
                                <Link :href="`/tasks/${task.id}/edit`">
                                    <Button variant="ghost" size="icon"><Pencil /></Button>
                                </Link>
                                <ConfirmDialog
                                    title="Delete task?"
                                    description="This will permanently delete this task."
                                    @confirm="destroy(task.id)"
                                >
                                    <template #trigger>
                                        <Button variant="ghost" size="icon"><Trash2 class="text-destructive" /></Button>
                                    </template>
                                </ConfirmDialog>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </Card>
    </AppLayout>
</template>
