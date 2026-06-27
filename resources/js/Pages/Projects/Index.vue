<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import { Plus, Pencil, Trash2, Eye } from 'lucide-vue-next'
import AppLayout from '@/Layouts/AppLayout.vue'
import Button from '@/components/ui/Button.vue'
import Card from '@/components/ui/Card.vue'
import Badge from '@/components/ui/Badge.vue'
import ConfirmDialog from '@/components/ConfirmDialog.vue'

defineProps({
    projects: { type: Array, default: () => [] },
})

const statusVariant = { active: 'info', completed: 'success', on_hold: 'warning' }
const statusLabel = { active: 'Active', completed: 'Completed', on_hold: 'On Hold' }

function destroy(id) {
    router.delete(`/projects/${id}`, { preserveScroll: true })
}
</script>

<template>
    <Head title="Projects" />
    <AppLayout>
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Projects</h1>
                <p class="text-sm text-muted-foreground">Manage your projects and their tasks.</p>
            </div>
            <Link href="/projects/create">
                <Button><Plus /> New Project</Button>
            </Link>
        </div>

        <Card v-if="projects.length === 0" class="p-12 text-center">
            <p class="text-muted-foreground">No projects yet. Create your first one.</p>
        </Card>

        <Card v-else class="overflow-hidden">
            <table class="w-full text-sm">
                <thead class="border-b bg-muted/50 text-left text-muted-foreground">
                    <tr>
                        <th class="px-4 py-3 font-medium">Name</th>
                        <th class="px-4 py-3 font-medium">Status</th>
                        <th class="px-4 py-3 font-medium">Tasks</th>
                        <th class="px-4 py-3 text-right font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="project in projects" :key="project.id" class="border-b last:border-0 hover:bg-muted/30">
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ project.name }}</div>
                            <div v-if="project.description" class="line-clamp-1 text-xs text-muted-foreground">
                                {{ project.description }}
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <Badge :variant="statusVariant[project.status]">{{ statusLabel[project.status] }}</Badge>
                        </td>
                        <td class="px-4 py-3">{{ project.tasks_count }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-1">
                                <Link :href="`/projects/${project.id}`">
                                    <Button variant="ghost" size="icon"><Eye /></Button>
                                </Link>
                                <Link :href="`/projects/${project.id}/edit`">
                                    <Button variant="ghost" size="icon"><Pencil /></Button>
                                </Link>
                                <ConfirmDialog
                                    title="Delete project?"
                                    description="This will permanently delete the project and all its tasks."
                                    @confirm="destroy(project.id)"
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
