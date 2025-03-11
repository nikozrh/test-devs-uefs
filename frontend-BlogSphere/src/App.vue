<template>
    <div class="d-flex flex-column min-vh-100 bg-gray-100">
        <Navbar />
        <!-- Conteúdo principal -->
        <main class="flex-grow-1 p-6">
            <router-view />
        </main>

        <footer class="bg-primary text-light text-center py-3 mt-auto">
            © 2025 BlogSphere - Teste prático UEFS - Avansys/ACP Group.
        </footer>

        <!-- Botão Flutuante para o Fórum -->
        <button @click="$router.push('/forum')" class="floating-btn">
            Fórum
        </button>
    </div>
</template>

<script>
import Navbar from './components/Navbar.vue';

export default {
    name: 'App',
    components: {
        Navbar,
    },
};
</script>
<style>
    .floating-btn {
        position: fixed;
        bottom: 80px; /* Elevado para ficar mais visível */
        right: 20px;
        background-color: #343a40; /* Cinza escuro elegante */
        color: #ffffff; /* Texto branco para contraste */
        border: none;
        border-radius: 50%;
        width: 50px; /* Tamanho reduzido */
        height: 50px; /* Tamanho reduzido */
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 0.9rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra suave */
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .floating-btn:hover {
        background-color: #495057; /* Tom mais claro no hover */
        transform: scale(1.1); /* Efeito leve de aumento */
    }

</style>