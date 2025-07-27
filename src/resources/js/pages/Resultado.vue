<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { Card, CardContent } from '@/components/ui/card'
import { CircleUser } from 'lucide-vue-next'

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
  fonte?: string
}>()
</script>

<template>
  <Head title="Resultado da Busca" />

  <!-- Toolbar -->
  <header class="fixed top-0 left-0 right-0 bg-white shadow-sm border-b border-gray-200 z-50">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
      <a href="/" class="text-xl font-bold text-gray-800 hover:text-indigo-600 transition-colors">
        De Olho no Voto
      </a>
      <a
        href="/"
        class="px-3 py-1 text-gray-700 bg-gray-200 rounded hover:bg-gray-300 transition"
      >
        Nova Busca
      </a>
    </div>
  </header>

  <!-- Conteúdo -->
  <main class="flex flex-col items-center mt-10 px-4 space-y-6 pt-16">
    <h1 class="text-2xl font-bold text-gray-800">Resultado da Busca</h1>

    <div v-if="erro" class="text-red-600 text-lg font-semibold">
      {{ erro }}
    </div>

    <div v-if="deputado" class="w-40 h-40 rounded-full overflow-hidden shadow-md border flex items-center justify-center bg-white">
      <img v-if="deputado.foto_url" :src="deputado.foto_url" alt="Foto" class="w-full h-full object-cover" />
      <CircleUser v-else class="w-24 h-24 text-gray-400" />
    </div>

    <div v-if="deputado" class="text-center">
      <h2 class="text-xl font-bold">{{ deputado.nome }}</h2>
      <p class="text-gray-600">{{ deputado.partido }} - {{ deputado.uf }}</p>
      <p class="text-sm text-gray-400 italic">Fonte: {{ fonte }}</p>
    </div>

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
                  <p class="text-green-700 font-bold">
                    R$ {{ Number(d.valor).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }}
                  </p>
                  <p class="text-xs text-gray-400">{{ new Date(d.data).toLocaleDateString() }}</p>
                </div>
              </div>
            </li>
          </ul>
        </CardContent>
      </Card>
    </section>
  </main>
</template>
