<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <!-- Nome do Blog -->
            <router-link class="navbar-brand" to="/">BlogSphere</router-link>

            <!-- Botão Responsivo -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegação">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Links do Navbar -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Botão Home -->
                    <li class="nav-item">
                        <router-link class="nav-link active-link" to="/" active-class="active">
                            Home
                        </router-link>
                    </li>
                    <!-- Botão Usuários -->
                    <li class="nav-item">
                        <router-link class="nav-link" :to="userExists ? '/users' : '#'"
                            :class="{ 'active-link': userExists, 'disabled-link': !userExists }"
                            aria-disabled="!userExists">
                            Usuários
                        </router-link>
                    </li>
                    <!-- Botão Tags -->
                    <li class="nav-item">
                        <router-link class="nav-link" :to="userExists ? '/tags' : '#'"
                            :class="{ 'active-link': userExists, 'disabled-link': !userExists }"
                            aria-disabled="!userExists">
                            Tags
                        </router-link>
                    </li>
                    <!-- Botão Postagens -->
                    <li class="nav-item">
                        <router-link class="nav-link" :to="userExists && tagsExist ? '/posts' : '#'"
                            :class="{ 'active-link': userExists && tagsExist, 'disabled-link': !userExists || !tagsExist }"
                            aria-disabled="!userExists || !tagsExist">
                            Postagens
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import api from "../services/api";

export default {
    name: "Navbar",
    data() {
        return {
            userExists: false, // Indica se há pelo menos um usuário no banco
            tagsExist: false, // Indica se há pelo menos uma tag no banco
        };
    },
    methods: {
        async updateState() {
            try {
                const usersResponse = await api.get("/users");
                this.userExists = usersResponse.data.length > 0;

                const tagsResponse = await api.get("/tags");
                this.tagsExist = tagsResponse.data.length > 0;

                console.log("Estado atualizado:", {
                    userExists: this.userExists,
                    tagsExist: this.tagsExist,
                });
            } catch (error) {
                console.error("Erro ao atualizar estado do Navbar:", error);
            }
        },
    },
    mounted() {
        this.updateState(); // Atualiza os estados ao carregar
    },
};
</script>

<style scoped>
/* Links ativos (acessíveis) */
.active-link {
    color: #ffffff;
    /* Branco para links ativos */
    font-weight: bold;
}

/* Links desativados (não acessíveis) */
.disabled-link {
    pointer-events: none;
    /* Remove interatividade */
    color: #aaa;
    /* Cinza para indicar desativado */
    opacity: 0.7;
}

/* Mensagem adicional para o botão de Tags */
.link-message {
    color: #f8d7da;
    /* Vermelho suave para a mensagem */
    font-size: 0.85rem;
    /* Texto menor */
    margin-top: 4px;
    font-style: italic;
    /* Texto em itálico para chamar atenção */
}
</style>
