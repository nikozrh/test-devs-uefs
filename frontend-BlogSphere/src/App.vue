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
