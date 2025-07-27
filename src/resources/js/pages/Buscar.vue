<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Card, CardContent } from '@/components/ui/card'
import { ref, onMounted, onBeforeUnmount } from 'vue'

const nome = ref('')

const buscarDeputado = () => {
  if (nome.value.trim()) {
    router.get('/buscar', { nome: nome.value }, { preserveState: true })
  }
}

// Event listener para Enter no input
const onKeyDown = (event: KeyboardEvent) => {
  if (event.key === 'Enter') {
    buscarDeputado()
  }
}

onMounted(() => {
  window.addEventListener('keydown', onKeyDown)
})

onBeforeUnmount(() => {
  window.removeEventListener('keydown', onKeyDown)
})
</script>

<template>
  <Head title="De Olho no Voto" />

  <!-- Toolbar -->
  <header class="fixed top-0 left-0 right-0 bg-white shadow-sm border-b border-gray-200 z-50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center">
      <a href="/" class="text-xl font-bold text-gray-800 hover:text-indigo-600 transition-colors">
        De Olho no Voto
      </a>
    </div>
  </header>

  <!-- Conteúdo -->
  <main class="flex flex-col items-center justify-center min-h-screen px-4 space-y-6 bg-gray-50 pt-16">
    <Card class="w-full max-w-md">
      <CardContent class="p-6 space-y-4">
        <h2 class="text-lg font-semibold">Buscar Deputado</h2>
        <div class="flex flex-col gap-3">
          <Input
            v-model="nome"
            type="text"
            placeholder="Digite o nome do Deputado"
            autocomplete="off"
          />
          <Button @click="buscarDeputado">Buscar</Button>
        </div>
      </CardContent>
    </Card>
  </main>
</template>
