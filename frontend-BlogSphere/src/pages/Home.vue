<template>
	<div class="container mt-5 p-4 bg-white shadow rounded">
		<h1 class="h4 text-primary fw-bold">Bem-vindo ao BlogSphere</h1>
		<p class="mt-3">
			Siga os passos abaixo para começar a usar o blog:
		</p>

		<!-- Passo 1: Cadastro de Usuário -->
		<div class="card mb-3">
			<div class="card-body">
				<h5 class="card-title">1. Cadastre um Usuário</h5>
				<p class="card-text">
					Clique no botão abaixo para acessar o gerenciamento de usuários e cadastrar o primeiro usuário.
				</p>
				<button @click="goToUsers" class="btn btn-primary">
					Gerenciar Usuários
				</button>
				<p v-if="!userExists" class="mt-2 text-danger">
					Nenhum usuário cadastrado. Esta etapa é obrigatória.
				</p>
				<p v-else class="mt-2 text-success">
					Temos usuário cadastrado! ✅
				</p>
			</div>
		</div>

		<!-- Passo 2: Criação de Tags -->
		<div class="card mb-3">
			<div class="card-body">
				<h5 class="card-title">2. Crie Tags</h5>
				<p class="card-text">
					Clique no botão abaixo para acessar o gerenciamento de tags e criar as categorias para seus posts.
				</p>
				<button @click="goToTags" class="btn btn-primary" :disabled="!userExists">
					Gerenciar Tags
				</button>
				<p v-if="!tagsExist" class="mt-2 text-danger">
					Nenhuma tag criada. Esta etapa é obrigatória.
				</p>
				<p v-else class="mt-2 text-success">
					Temos ags criadas! ✅
				</p>
			</div>
		</div>

		<!-- Passo 3: Criação de Postagens -->
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">3. Crie Postagens</h5>
				<p class="card-text">
					Clique no botão abaixo para acessar o gerenciamento de postagens e começar a publicar no blog.
				</p>
				<button @click="goToPosts" class="btn btn-primary" :disabled="!userExists || !tagsExist">
					Gerenciar Postagens
				</button>
				<p v-if="!userExists || !tagsExist" class="mt-2 text-danger">
					Esta etapa só estará disponível após as etapas anteriores serem concluídas.
				</p>
				<p v-else class="mt-2 text-success">
					Tudo pronto! Você já pode criar postagens! ✅
				</p>
			</div>
		</div>
	</div>
</template>

<script>
import api from "../services/api";

export default {
	name: "Home",
	data() {
		return {
			userExists: false, // Indica se há usuários cadastrados
			tagsExist: false, // Indica se há tags cadastradas
		};
	},
	methods: {
		// Verifica se existem usuários cadastrados
		async checkUsers() {
			try {
				const response = await api.get("/users");
				this.userExists = response.data.length > 0; // True se houver usuários
			} catch (error) {
				console.error("Erro ao verificar usuários:", error);
				this.userExists = false;
			}
		},

		// Verifica se existem tags cadastradas
		async checkTags() {
			try {
				const response = await api.get("/tags");
				this.tagsExist = response.data.length > 0; // True se houver tags
			} catch (error) {
				console.error("Erro ao verificar tags:", error);
				this.tagsExist = false;
			}
		},

		// Navegar para a página de usuários
		goToUsers() {
			this.$router.push("/users");
		},

		// Navegar para a página de tags
		goToTags() {
			this.$router.push("/tags");
		},

		// Navegar para a página de postagens
		goToPosts() {
			this.$router.push("/posts");
		},
	},
	mounted() {
		this.checkUsers(); // Verifica usuários ao carregar
		this.checkTags(); // Verifica tags ao carregar
	},
};
</script>

<style scoped>
.card {
	border: 1px solid #ddd;
}

.card-title {
	color: #0d6efd;
}
</style>
