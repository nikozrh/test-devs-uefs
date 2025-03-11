<template>
    <div class="container mt-5 p-4 bg-white shadow rounded">
      <!-- Cabeçalho -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 text-primary fw-bold">Gerenciamento de Postagens</h1>
        <button @click="openModal" class="btn btn-primary">
          Nova Postagem
        </button>
      </div>
  
      <!-- Campo de Filtro por ID -->
      <div class="mb-3">
        <label for="filterPostId" class="form-label">Filtrar por ID</label>
        <input
          v-model="filterId"
          type="number"
          class="form-control"
          id="filterPostId"
          placeholder="Digite o ID da postagem"
          @input="filterPostsById"
        />
      </div>
  
      <!-- Tabela de Postagens -->
      <table class="table table-bordered table-hover">
        <thead class="table-light">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Usuário</th>
            <th scope="col">Título</th>
            <th scope="col">Tags</th>
            <th scope="col" class="text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="post in filteredPosts" :key="post.id">
            <td class="text-center">{{ post.id }}</td>
            <td>{{ post.user.name }}</td>
            <td>{{ post.title }}</td>
            <td>
              <span v-for="tag in post.tags" :key="tag.id" class="badge bg-secondary me-1">
                {{ tag.name }}
              </span>
            </td>
            <td class="text-center">
              <button
                @click="editPost(post)"
                class="btn btn-warning btn-sm me-2"
              >
                Editar
              </button>
              <button
                @click="deletePost(post.id)"
                class="btn btn-danger btn-sm"
              >
                Excluir
              </button>
            </td>
          </tr>
        </tbody>
      </table>
  
      <!-- Modal -->
      <Modal :isOpen="isModalOpen" @close="closeModal">
        <form @submit.prevent="savePost">
          <!-- Exibir mensagens de erro no formulário -->
          <div v-if="formError" class="alert alert-danger">
            {{ formError }}
          </div>
  
          <!-- Campo de Usuário -->
          <div class="mb-3">
            <label for="user" class="form-label">Selecione o Usuário</label>
            <select
              v-model="form.user_id"
              class="form-control"
              id="user"
              required
            >
              <option v-for="user in users" :key="user.id" :value="user.id">
                {{ user.name }}
              </option>
            </select>
          </div>
  
          <!-- Campo de Título -->
          <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input
              v-model="form.title"
              type="text"
              class="form-control"
              id="title"
              required
            />
          </div>
  
          <!-- Campo de Conteúdo -->
          <div class="mb-3">
            <label for="content" class="form-label">Conteúdo</label>
            <textarea
              v-model="form.content"
              class="form-control"
              id="content"
              rows="4"
              required
            ></textarea>
          </div>
  
          <!-- Campo de Tags -->
          <div class="mb-3">
            <label for="tags" class="form-label">Selecione as Tags</label>
            <select
              v-model="form.tags"
              class="form-control"
              id="tags"
              multiple
              required
            >
              <option v-for="tag in tags" :key="tag.id" :value="tag.id">
                {{ tag.name }}
              </option>
            </select>
          </div>
  
          <!-- Botões -->
          <div class="d-flex justify-content-end gap-3 mt-4">
            <button
              type="button"
              @click="closeModal"
              class="btn btn-secondary"
            >
              Fechar
            </button>
            <button
              type="submit"
              class="btn btn-primary"
            >
              {{ form.id ? "Salvar Alterações" : "Criar Postagem" }}
            </button>
          </div>
        </form>
      </Modal>
  
      <!-- Mensagem de Sucesso -->
      <div v-if="notification" class="alert alert-success mt-4">
        {{ notification }}
      </div>
    </div>
  </template>
  

<script>
import Modal from "../components/Modal.vue";
import api from "../services/api";

export default {
    name: "Posts",
    components: { Modal },
    data() {
        return {
            posts: [], // Lista completa de postagens
            filteredPosts: [], // Lista de postagens filtradas
            users: [], // Lista de usuários cadastrados
            tags: [], // Lista de tags cadastradas
            isModalOpen: false, // Controle do modal
            form: { id: null, user_id: null, title: "", content: "", tags: [] }, // Dados do formulário
            notification: "", // Mensagens de sucesso
            formError: "", // Mensagens de erro no formulário
            filterId: "", // ID digitado no filtro
        };
    },
    methods: {
        // Busca todas as postagens
        async fetchPosts() {
            try {
                const response = await api.get("/posts");
                this.posts = response.data; // Atualiza a lista de postagens
                this.filteredPosts = this.posts; // Inicializa a lista filtrada
            } catch (error) {
                console.error("Erro ao buscar postagens:", error);
            }
        },

        // Busca usuários cadastrados
        async fetchUsers() {
            try {
                const response = await api.get("/users");
                this.users = response.data; // Atualiza a lista de usuários
            } catch (error) {
                console.error("Erro ao buscar usuários:", error);
            }
        },

        // Busca tags cadastradas
        async fetchTags() {
            try {
                const response = await api.get("/tags");
                this.tags = response.data; // Atualiza a lista de tags
            } catch (error) {
                console.error("Erro ao buscar tags:", error);
            }
        },

        // Filtra as postagens pelo ID
        filterPostsById() {
            if (this.filterId === "") {
                this.filteredPosts = this.posts; // Mostra todas as postagens se o filtro estiver vazio
            } else {
                const id = Number(this.filterId); // Converte para número
                this.filteredPosts = this.posts.filter(post => post.id === id); // Filtra pelo ID
            }
        },

        // Abre o modal (criar ou editar)
        openModal(post = { id: null, user_id: null, title: "", content: "", tags: [] }) {
            this.form = {
                ...post,
                tags: post.tags ? post.tags.map(tag => tag.id) : [] // Extrai apenas os IDs das tags
            };
            this.isModalOpen = true;
            this.formError = ""; // Limpa mensagens de erro
        },

        // Fecha o modal
        closeModal() {
            this.isModalOpen = false; // Fecha o modal
        },

        // Método para editar uma postagem
        editPost(post) {
            this.openModal(post); // Abre o modal com os dados da postagem
        },

        // Salva uma nova postagem ou edita uma existente
        async savePost() {
            try {
                const payload = {
                    user_id: this.form.user_id,
                    title: this.form.title,
                    content: this.form.content,
                    tags: this.form.tags // Apenas IDs
                };

                if (this.form.id) {
                    await api.put(`/posts/${this.form.id}`, payload);
                } else {
                    await api.post("/posts", payload);
                }

                this.notification = "Postagem salva com sucesso!";
                setTimeout(() => (this.notification = ""), 3000);
                this.closeModal();
                this.fetchPosts(); // Atualiza a lista de postagens
            } catch (error) {
                console.error("Erro ao salvar postagem:", error);

                // Tratamento para mensagens específicas da API
                if (error.response && error.response.data) {
                    const { message, errors } = error.response.data;

                    if (errors) {
                        this.formError = Object.values(errors).flat().join(" "); // Exibe mensagens específicas
                    } else if (message) {
                        this.formError = message; // Exibe mensagem genérica da API
                    } else {
                        this.formError = "Erro ao salvar a postagem. Tente novamente.";
                    }
                } else {
                    this.formError = "Erro ao salvar a postagem. Tente novamente.";
                }
            }
        },


        // Exclui uma postagem
        async deletePost(id) {
            try {
                await api.delete(`/posts/${id}`);
                this.notification = "Postagem excluída com sucesso!";
                setTimeout(() => (this.notification = ""), 3000); // Remove
            } catch (error) {
                console.error("Erro ao excluir postagem:", error);
                this.notification = "Erro ao excluir a postagem. Tente novamente.";
            } finally {
                this.fetchPosts(); // Atualiza a lista
            }
        },
    },
    mounted() {
        this.fetchPosts(); // Busca postagens
        this.fetchUsers(); // Busca usuários
        this.fetchTags(); // Busca tags
    },
};
</script>