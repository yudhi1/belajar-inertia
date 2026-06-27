<script setup>
import { computed, ref, watch } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { LayoutGrid, FolderKanban, ListChecks, CheckCircle2 } from 'lucide-vue-next'

const page = usePage()
const flash = computed(() => page.props.flash ?? {})

const showToast = ref(false)
watch(
    () => flash.value.success,
    (msg) => {
        if (msg) {
            showToast.value = true
            setTimeout(() => (showToast.value = false), 3000)
        }
    },
    { immediate: true },
)

const nav = [
    { name: 'Projects', href: '/projects', icon: FolderKanban, match: '/projects' },
    { name: 'Tasks', href: '/tasks', icon: ListChecks, match: '/tasks' },
]

const currentPath = computed(() => page.url)
</script>

<template>
    <div class="min-h-screen bg-muted/30">
        <header class="border-b bg-card">
            <div class="mx-auto flex h-14 max-w-6xl items-center gap-6 px-4">
                <Link href="/projects" class="flex items-center gap-2 font-semibold">
                    <LayoutGrid class="size-5" />
                    <span>ProjectFlow</span>
                </Link>
                <nav class="flex items-center gap-1">
                    <Link
                        v-for="item in nav"
                        :key="item.href"
                        :href="item.href"
                        :class="[
                            'flex items-center gap-2 rounded-md px-3 py-1.5 text-sm font-medium transition-colors',
                            currentPath.startsWith(item.match)
                                ? 'bg-accent text-accent-foreground'
                                : 'text-muted-foreground hover:text-foreground',
                        ]"
                    >
                        <component :is="item.icon" class="size-4" />
                        {{ item.name }}
                    </Link>
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-4 py-8">
            <slot />
        </main>

        <Transition
            enter-active-class="transition duration-200"
            enter-from-class="translate-y-2 opacity-0"
            leave-active-class="transition duration-200"
            leave-to-class="translate-y-2 opacity-0"
        >
            <div
                v-if="showToast"
                class="fixed bottom-6 right-6 z-50 flex items-center gap-2 rounded-lg border bg-card px-4 py-3 text-sm shadow-lg"
            >
                <CheckCircle2 class="size-4 text-emerald-600" />
                {{ flash.success }}
            </div>
        </Transition>
    </div>
</template>
