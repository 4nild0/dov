<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Card, CardContent } from '@/components/ui/card'

// Dados simulados
const avatarUrl = 'https://via.placeholder.com/150'
</script>

<template>
  <Head title="Início" />

  <!-- Header -->
  <header class="w-full flex justify-between items-center px-6 py-4 bg-gray-100 border-b shadow-sm">
    <h1 class="text-xl font-bold text-gray-800">De Olho no Voto</h1>
    <div class="flex gap-2">
      <Button variant="outline">Opção 1</Button>
      <Button variant="outline">Opção 2</Button>
      <Button variant="outline">Opção 3</Button>
    </div>
  </header>

  <!-- Conteúdo central -->
  <main class="flex flex-col items-center mt-10 px-4 space-y-6">
    
    <!-- Imagem circular dinâmica -->
    <div class="w-40 h-40 rounded-full overflow-hidden shadow-md border">
      <img
        :src="avatarUrl"
        alt="Foto"
        class="w-full h-full object-cover"
      />
    </div>

    <!-- Caixa de pesquisa -->
    <Input type="text" placeholder="Digite o nome do Deputado" class="max-w-md w-full" />
  </main>

  <!-- Seção de dados -->
  <section class="mt-10 px-4 max-w-5xl mx-auto w-full">
    <Card>
      <CardContent class="p-6 space-y-4">
        <h2 class="text-xl font-semibold">Lista de Despesas</h2>
        <ul class="list-disc list-inside text-gray-700">
          <li>Nome: João da Silva</li>
          <li>Email: joao@email.com</li>
          <li>Cadastro: 12/04/2023</li>
          <li>Status: Ativo</li>
        </ul>
      </CardContent>
    </Card>
  </section>
</template>
