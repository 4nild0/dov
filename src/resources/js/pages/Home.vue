<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Card, CardContent } from '@/components/ui/card'
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { CircleUser } from 'lucide-vue-next'

// Props recebidas do backend
defineProps<{
  deputado?: {
    id: number
    nome: string
    partido: string
    uf: string
    foto_url: string
    despesas?: Array<{
      data: string
      tipo_despesa: string
      valor: number
      fornecedor?: string
    }>
  }
  erro?: string
  source?: string
}>()

const nome = ref('')
const buscarDeputado = () => {
  if (nome.value.trim()) {
    router.get('/deputados/buscar', { nome: nome.value }, { preserveState: true })
  }
}
</script>

<template>
  <Head title="De Olho no Voto" />

  <!-- Header -->
  <header class="w-full flex justify-between items-center px-6 py-4 bg-gray-100 border-b shadow-sm">
    <h1 class="text-xl font-bold text-gray-800">De Olho no Voto</h1>
    <div class="flex gap-2">
      <Button variant="outline">Ranking</Button>
      <Button variant="outline">Comparar</Button>
      <Button variant="outline">Sobre</Button>
    </div>
  </header>

  <!-- Conteúdo principal -->
  <main class="flex flex-col items-center mt-10 px-4 space-y-6">

    <!-- Foto ou ícone -->
    <div class="w-40 h-40 rounded-full overflow-hidden shadow-md border flex items-center justify-center bg-white">
      <img
        v-if="deputado?.foto_url"
        :src="deputado.foto_url"
        alt="Foto"
        class="w-full h-full object-cover"
      />
      <CircleUser v-else class="w-24 h-24 text-gray-400" />
    </div>

    <!-- Card de busca -->
    <Card class="w-full max-w-md">
      <CardContent class="p-6 space-y-4">
        <h2 class="text-lg font-semibold">Buscar Deputado</h2>
        <div class="flex flex-col gap-3">
          <Input v-model="nome" type="text" placeholder="Digite o nome do Deputado" />
          <Button @click="buscarDeputado">Buscar</Button>
        </div>
        <p v-if="erro" class="text-red-600 text-sm font-medium">{{ erro }}</p>
      </CardContent>
    </Card>

    <!-- Info do deputado -->
    <div v-if="deputado" class="text-center">
      <h2 class="text-xl font-bold">{{ deputado.nome }}</h2>
      <p class="text-gray-600">{{ deputado.partido }} - {{ deputado.uf }}</p>
      <p class="text-sm text-gray-400 italic">Fonte: {{ source }}</p>
    </div>
  </main>

  <!-- Lista de Despesas -->
  <section v-if="deputado?.despesas?.length" class="mt-10 px-4 max-w-5xl mx-auto w-full">
    <Card>
      <CardContent class="p-6 space-y-4">
        <h2 class="text-xl font-semibold">Despesas Registradas</h2>
        <ul class="divide-y divide-gray-200">
          <li v-for="(d, index) in deputado.despesas" :key="index" class="py-2">
            <div class="flex justify-between items-start">
              <div>
                <p class="font-medium text-gray-800">{{ d.tipo_despesa }}</p>
                <p class="text-sm text-gray-500">{{ d.fornecedor || 'Fornecedor não informado' }}</p>
              </div>
              <div class="text-right">
                <p class="text-green-700 font-bold">R$ {{ d.valor.toFixed(2) }}</p>
                <p class="text-xs text-gray-400">{{ new Date(d.data).toLocaleDateString() }}</p>
              </div>
            </div>
          </li>
        </ul>
      </CardContent>
    </Card>
  </section>
</template>
