<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <!-- Nome do Blog no Lado Esquerdo -->
            <router-link class="navbar-brand" to="/">BlogSphere</router-link>

            <!-- Botão para navegação colapsada (responsivo) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegação">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu de Navegação -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <!-- Links de Navegação Dinâmicos -->
                    <li class="nav-item" v-for="link in links" :key="link.name">
                        <router-link class="nav-link" :to="link.path" active-class="active" aria-current="page">
                            {{ link.name }}
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: "Navbar",
    data() {
        return {
            // Links dinâmicos de navegação
            links: [
                { name: "Home", path: "/" },
                { name: "Usuários", path: "/users" },
                { name: "Tags", path: "/tags" },
                { name: "Postagem", path: "/posts" },
            ],
        };
    },
};
</script>

<style scoped>
/* Estilo do Navbar */
.navbar {
    background-color: #007bff;
    /* Azul vibrante */
}

.navbar .navbar-brand {
    font-weight: bold;
    color: #fff;
    /* Branco para o texto */
}

.navbar .navbar-brand:hover {
    color: #dfe6f1;
    /* Branco mais claro no hover */
}

.navbar .nav-link {
    color: #fff;
    /* Branco para os links */
    transition: color 0.2s ease-in-out;
}

.navbar .nav-link:hover {
    color: #d31414;
    /* Branco mais claro no hover */
}

/* Estilo para o link ativo */
.active {
    font-weight: bold;
    color: #2edee4 !important;
    /* Amarelo destaque */
}
</style>