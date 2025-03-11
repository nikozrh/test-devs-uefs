<template>
    <div class="forum-container">
        <h1 class="forum-title">Fórum de Postagens</h1>

        <!-- Exibe Carregando... enquanto os dados são buscados -->
        <div v-if="loading" class="loading">Carregando postagens...</div>

        <div v-else>
            <!-- Loop para exibir os posts paginados -->
            <div class="post-card" v-for="post in paginatedPosts" :key="post.id">
                <div class="user-info">
                    <img :src="'https://ui-avatars.com/api/?name=' + post.user.name + '&background=random&size=40'"
                        alt="Avatar do Usuário" class="user-avatar" />
                    <div class="user-details">
                        <p class="user-name">{{ post.user.name }}</p>
                        <p class="post-date">Publicado em {{ new Date(post.created_at).toLocaleDateString() }}</p>
                    </div>
                </div>
                <h2 class="post-title">{{ post.title }}</h2>
                <p class="post-content">{{ post.content }}</p>
                <div class="post-tags">
                    <span v-for="tag in post.tags" :key="tag.id" class="tag">{{ tag.name }}</span>
                </div>
            </div>

            <!-- Controles de Paginação -->
            <div class="pagination">
                <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1">Anterior</button>
                <span>Página {{ currentPage }} de {{ totalPages }}</span>
                <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages">Próxima</button>
            </div>
        </div>
    </div>
</template>

<script>
import api from "../services/api"; // Importa o serviço de API configurado

export default {
    name: "Forum",
    data() {
        return {
            posts: [], // Todas as postagens recebidas da API
            currentPage: 1, // Página atual
            postsPerPage: 2, // Número de posts exibidos por página
            loading: true, // Indicador de carregamento
        };
    },
    computed: {
        // Retorna os posts da página atual
        paginatedPosts() {
            const start = (this.currentPage - 1) * this.postsPerPage;
            const end = start + this.postsPerPage;
            return this.posts.slice(start, end); // Faz o corte baseado nos índices
        },
        // Calcula o total de páginas
        totalPages() {
            return Math.ceil(this.posts.length / this.postsPerPage);
        },
    },
    methods: {
        // Método para buscar todas as postagens
        async fetchPosts() {
            try {
                // Faz a requisição GET para a API (sem paginação no backend)
                const response = await api.get("/posts");
                this.posts = response.data; // Carrega todas as postagens
            } catch (error) {
                console.error("Erro ao buscar postagens:", error);
            } finally {
                this.loading = false; // Finaliza o carregamento
            }
        },
        // Muda a página
        changePage(page) {
            if (page > 0 && page <= this.totalPages) {
                this.currentPage = page; // Atualiza a página atual
            }
        },
    },
    mounted() {
        this.fetchPosts(); // Carrega os dados ao montar o componente
    },
};
</script>



<style scoped>
.forum-container {
    max-width: 700px;
    /* Define largura máxima da página */
    margin: 0 auto;
    padding: 20px;
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    /* Fundo claro */
}

.forum-title {
    text-align: center;
    font-size: 2rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
}

.post-card {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 10px;
    margin-bottom: 20px;
    /* Espaçamento entre os cartões */
    padding: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    /* Sombra suave */
}

.user-info {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    /* Espaço abaixo das informações do usuário */
}

.user-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    /* Torna o avatar circular */
    margin-right: 15px;
    /* Espaço entre avatar e nome */
    border: 2px solid #007bff;
    /* Borda azul */
}

.user-details {
    display: flex;
    flex-direction: column;
    /* Nome e data em linhas separadas */
}

.user-name {
    font-weight: bold;
    color: #333;
    font-size: 1rem;
}

.post-date {
    font-size: 0.85rem;
    color: #666;
}

.post-title {
    font-size: 1.4rem;
    color: #007bff;
    margin: 10px 0;
    font-weight: bold;
}

.post-content {
    font-size: 1rem;
    color: #555;
    line-height: 1.5;
    margin-bottom: 10px;
}

.post-tags {
    margin-top: 10px;
    /* Espaço entre conteúdo e tags */
}

.tag {
    display: inline-block;
    background: #e9ecef;
    color: #495057;
    padding: 5px 10px;
    margin-right: 5px;
    border-radius: 5px;
    font-size: 0.85rem;
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
    /* Distância da seção anterior */
}

.pagination button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 8px 16px;
    margin: 0 5px;
    border-radius: 5px;
    font-size: 0.9rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

.pagination button:hover {
    background-color: #0056b3;
    /* Azul mais escuro no hover */
}

.pagination button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

.pagination span {
    font-size: 1rem;
    font-weight: bold;
    margin: 0 10px;
    color: #333;
}
</style>
