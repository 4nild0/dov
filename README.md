# 📊 DOV - De Olho no Voto

**DOV (De Olho no Voto)** é uma aplicação web desenvolvida com Laravel + Vue 3, cujo objetivo é permitir que cidadãos consultem e comparem os gastos de deputados federais, utilizando dados da API da Câmara dos Deputados.

Este repositório contém toda a infraestrutura do projeto, configurada via Docker, incluindo ambiente PHP, MySQL, queue worker e servidor Nginx.

---

## ⚙️ Tecnologias

- PHP 8.x + Laravel
- Vue 3 + Vite
- Tailwind CSS + shadcn/ui
- MySQL 8
- Docker + Docker Compose
- Nginx (Alpine)
- Worker para jobs com `queue:work`

---

## 🚀 Subindo o Projeto

### Pré-requisitos

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/)

### Instruções

1. Clone o repositório:

```bash
git clone https://github.com/4nild0/dov.git
cd dov
