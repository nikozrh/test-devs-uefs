<template>
	<div class="container mt-5 p-4 bg-white shadow rounded">
	  <!-- Cabeçalho -->
	  <div class="d-flex justify-content-between align-items-center mb-4">
		<h1 class="h4 text-primary fw-bold">Gerenciamento de Tags</h1>
		<button @click="openModal" class="btn btn-primary">
		  Nova Tag
		</button>
	  </div>
  
	  <!-- Campo de Filtro por ID -->
	  <div class="mb-3">
		<label for="filterTagId" class="form-label">Filtrar por ID</label>
		<input
		  v-model="filterId"
		  type="number"
		  class="form-control"
		  id="filterTagId"
		  placeholder="Digite o ID da tag"
		  @input="filterTagsById"
		/>
	  </div>
  
	  <!-- Tabela de Tags -->
	  <table class="table table-bordered table-hover">
		<thead class="table-light">
		  <tr>
			<th scope="col">ID</th>
			<th scope="col">Nome</th>
			<th scope="col" class="text-center">Ações</th>
		  </tr>
		</thead>
		<tbody>
		  <tr v-for="tag in filteredTags" :key="tag.id">
			<td class="text-center">{{ tag.id }}</td>
			<td>{{ tag.name }}</td>
			<td class="text-center">
			  <button
				@click="editTag(tag)"
				class="btn btn-warning btn-sm me-2"
			  >
				Editar
			  </button>
			  <button
				@click="deleteTag(tag.id)"
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
		<form @submit.prevent="saveTag">
		  <!-- Exibir mensagens de erro no formulário -->
		  <div v-if="formError" class="alert alert-danger">
			{{ formError }}
		  </div>
		  <!-- Campo de Nome -->
		  <div class="mb-3">
			<label for="name" class="form-label">Nome da Tag</label>
			<input
			  v-model="form.name"
			  type="text"
			  class="form-control"
			  id="name"
			  required
			/>
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
			  {{ form.id ? "Salvar Alterações" : "Criar Tag" }}
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
	name: "Tags",
	components: { Modal },
	data() {
	  return {
		tags: [], // Lista completa de tags
		filteredTags: [], // Lista de tags filtradas
		isModalOpen: false, // Controle do modal
		form: { id: null, name: "" }, // Dados do formulário
		notification: "", // Mensagens de sucesso
		formError: "", // Mensagens de erro no formulário
		filterId: "", // ID digitado no filtro
	  };
	},
	methods: {
	  // Busca todas as tags
	  async fetchTags() {
		try {
		  const response = await api.get("/tags");
		  this.tags = response.data; // Atualiza a lista de tags
		  this.filteredTags = this.tags; // Inicializa a lista filtrada
		} catch (error) {
		  console.error("Erro ao buscar tags:", error);
		}
	  },
  
	  // Filtra as tags pelo ID
	  filterTagsById() {
		if (this.filterId === "") {
		  this.filteredTags = this.tags; // Mostra todas as tags se o filtro estiver vazio
		} else {
		  const id = Number(this.filterId); // Converte para número
		  this.filteredTags = this.tags.filter(tag => tag.id === id); // Filtra pelo ID
		}
	  },
  
	  // Abre o modal (criar ou editar)
	  openModal(tag = { id: null, name: "" }) {
		this.form = { ...tag }; // Preenche o formulário com os dados
		this.isModalOpen = true; // Abre o modal
		this.formError = ""; // Limpa mensagens de erro
	  },
  
	  // Fecha o modal
	  closeModal() {
		this.isModalOpen = false;
	  },
  
	  // Método para editar uma tag
	  editTag(tag) {
		this.openModal(tag); // Abre o modal com os dados da tag
	  },
  
	  // Salva uma nova tag ou edita uma existente
	  async saveTag() {
		try {
		  if (this.form.id) {
			await api.put(`/tags/${this.form.id}`, this.form);
		  } else {
			await api.post("/tags", this.form);
		  }
		  this.notification = "Tag salva com sucesso!";
		  setTimeout(() => (this.notification = ""), 3000); // Limpa após 3 segundos
		  this.closeModal();
		  this.fetchTags(); // Atualiza a lista
		} catch (error) {
		  console.error("Erro ao salvar tag:", error);
  
		  // Tratamento para mensagens específicas da API
		  if (error.response && error.response.data) {
			const { message, errors } = error.response.data;
  
			if (errors) {
			  // Concatena mensagens de erro da API
			  this.formError = Object.values(errors).flat().join(" ");
			} else if (message) {
			  this.formError = message; // Exibe mensagem genérica da API
			} else {
			  this.formError = "Erro ao salvar a tag. Tente novamente.";
			}
		  } else {
			this.formError = "Erro ao salvar a tag. Tente novamente.";
		  }
		}
	  },
  
	  // Exclui uma tag
	  async deleteTag(id) {
		try {
		  await api.delete(`/tags/${id}`);
		  this.notification = "Tag excluída com sucesso!";
		  setTimeout(() => (this.notification = ""), 3000); // Remove a mensagem após 3 segundos
		  this.fetchTags(); // Atualiza a lista
		} catch (error) {
		  console.error("Erro ao excluir tag:", error);
		}
	  },
	},
	mounted() {
	  this.fetchTags(); // Busca as tags ao iniciar
	},
  };
  </script>
  