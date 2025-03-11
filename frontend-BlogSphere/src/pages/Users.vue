<template>
	<div class="container mt-5 p-4 bg-white shadow rounded">
		<!-- Mensagem de Erro ao Buscar Usuários -->
		<div v-if="error" class="alert alert-danger" role="alert">
			<strong>Erro!</strong> Ocorreu um erro ao buscar os usuários.
		</div>

		<!-- Mensagem de Sucesso -->
		<div v-if="notification" class="alert alert-success" role="alert">
			{{ notification }}
		</div>

		<!-- Cabeçalho -->
		<div class="d-flex justify-content-between align-items-center mb-4">
			<h1 class="h4 text-primary fw-bold">Gerenciamento de Usuários</h1>
			<button @click="openModal" class="btn btn-primary">
				Novo Usuário
			</button>
		</div>

		<!-- Campo de Filtro por ID -->
		<div class="mb-3">
			<label for="filterId" class="form-label">Filtrar por ID</label>
			<input v-model="filterId" type="number" class="form-control" id="filterId"
				placeholder="Digite o ID do usuário" @input="filterUsersById" />
		</div>

		<!-- Tabela de Usuários -->
		<table class="table table-bordered table-hover">
			<thead class="table-light">
				<tr>
					<th scope="col">ID</th>
					<th scope="col">Nome</th>
					<th scope="col">Email</th>
					<th scope="col" class="text-center">Ações</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="user in filteredUsers" :key="user.id">
					<td class="text-center">{{ user.id }}</td>
					<td>{{ user.name }}</td>
					<td>{{ user.email }}</td>
					<td class="text-center">
						<button @click="editUser(user)" class="btn btn-warning btn-sm me-2">
							Editar
						</button>
						<button @click="deleteUser(user.id)" class="btn btn-danger btn-sm">
							Excluir
						</button>
					</td>
				</tr>
			</tbody>

		</table>

		<!-- Modal -->
		<Modal :isOpen="isModalOpen" @close="closeModal">
			<form @submit.prevent="saveUser">
				<!-- Exibir mensagens de erro no formulário -->
				<div v-if="formError" class="alert alert-danger">
					{{ formError }}
				</div>

				<!-- Campo de Nome -->
				<div class="mb-3">
					<label for="name" class="form-label">Nome</label>
					<input v-model="form.name" type="text" class="form-control" id="name" required />
				</div>

				<!-- Campo de Email -->
				<div class="mb-3">
					<label for="email" class="form-label">Email</label>
					<input v-model="form.email" type="email" class="form-control" id="email" required />
				</div>
				<!-- Campo de Senha -->
				<div class="mb-3">
					<label for="password" class="form-label">Senha (preencha apenas se quiser alterar)</label>
					<input v-model="form.password" type="password" class="form-control" id="password" />
				</div>
				<!-- Botões -->
				<div class="d-flex justify-content-end gap-3 mt-4">
					<button type="button" @click="closeModal" class="btn btn-secondary">
						Fechar
					</button>
					<button type="submit" class="btn btn-primary">
						{{ form.id ? "Salvar Alterações" : "Criar Usuário" }}
					</button>
				</div>
			</form>
		</Modal>
	</div>
</template>

<script>
import Modal from "../components/Modal.vue";
import api from "../services/api";

export default {
	name: "Users",
	components: { Modal },
	data() {
		return {
			users: [], // Lista de usuários
			filteredUsers: [], // Lista de usuários filtrados
			isModalOpen: false, // Controla a exibição do modal
			form: { id: null, name: "", email: "", password: "" }, // Dados do formulário
			notification: "", // Mensagem de sucesso
			error: false, // Indica erro ao buscar usuários
			formError: "", // Para mensagens de erro no modal
			filterId: "", // Armazena o valor digitado no campo de filtro
		};
	},
	methods: {
		// Busca os usuários
		async fetchUsers() {
			try {
				const response = await api.get("/users"); // Chamada à API
				this.users = response.data; // Atualiza a lista completa
				this.filteredUsers = this.users; // Inicializa a lista filtrada com todos os usuários
				this.error = false; // Remove o alerta de erro
			} catch (error) {
				console.error("Erro ao buscar usuários:", error);
				this.error = true; // Ativa o alerta de erro
			}
		},

		// Abre o modal (editar ou criar)
		openModal(user = { id: null, name: "", email: "", password: "" }) {
			this.form = { ...user, password: "" }; // Reseta o campo password
			this.formError = ""; // Limpa mensagens de erro
			this.isModalOpen = true; // Abre o modal
		},

		// Fecha o modal
		closeModal() {
			this.isModalOpen = false; // Fecha o modal
		},

		// Método para editar um usuário (reutiliza openModal)
		editUser(user) {
			this.openModal(user); // Abre o modal com os dados do usuário
		},

		// Salva (cria ou edita) um usuário
		async saveUser() {
			try {
				// Remove o campo password se estiver vazio
				const dataToSend = { ...this.form };
				if (!dataToSend.password) {
					delete dataToSend.password;
				}

				if (this.form.id) {
					await api.put(`/users/${this.form.id}`, dataToSend);
				} else {
					await api.post("/users", dataToSend);
				}
				this.notification = "Usuário salvo com sucesso!";
				setTimeout(() => (this.notification = ""), 3000);
				this.formError = ""; // Limpa mensagens de erro
				this.closeModal();
				this.fetchUsers(); // Atualiza a tabela de usuários
			} catch (error) {
				console.error("Erro ao salvar o usuário:", error);

				if (error.response && error.response.data) {
					const { message, errors } = error.response.data;

					if (errors) {
						this.formError = Object.values(errors).flat().join(" ");
					} else if (message) {
						this.formError = message;
					} else {
						this.formError = "Houve um problema ao salvar o usuário. Tente novamente.";
					}
				} else {
					this.formError = "Houve um problema ao salvar o usuário. Tente novamente.";
				}
			}
		},

		// Exclui um usuário
		async deleteUser(id) {
			try {
				await api.delete(`/users/${id}`);
				this.notification = "Usuário excluído com sucesso!"; // Mensagem de sucesso
				setTimeout(() => (this.notification = ""), 3000); // Remove a mensagem após 3 segundos
				this.fetchUsers(); // Atualiza a tabela
			} catch (error) {
				console.error("Erro ao excluir usuário:", error);
				alert("Não foi possível excluir o usuário. Tente novamente.");
			}
		},

		filterUsersById() {
			if (this.filterId === "") {
				// Se o campo estiver vazio, exibe todos os usuários
				this.filteredUsers = this.users;
			} else {
				// Filtra os usuários pelo ID informado
				this.filteredUsers = this.users.filter(user => user.id === Number(this.filterId));
			}
		}

	},
	mounted() {
		this.fetchUsers(); // Carrega a lista de usuários ao iniciar
	},
};
</script>