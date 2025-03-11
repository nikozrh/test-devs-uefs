<template>
  <div class="bg-white shadow-md rounded p-6">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">Gerenciamento de Tags</h1>
      <button @click="openModal" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Nova tag.
      </button>
    </div>
    <table class="table-auto w-full border-collapse border border-gray-300">
      <thead>
        <tr class="bg-gray-100">
          <th class="border px-4 py-2">ID</th>
          <th class="border px-4 py-2">Nome</th>
          <th class="border px-4 py-2">Email</th>
          <th class="border px-4 py-2">Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td class="border px-4 py-2 text-center">{{ user.id }}</td>
          <td class="border px-4 py-2">{{ user.name }}</td>
          <td class="border px-4 py-2">{{ user.email }}</td>
          <td class="border px-4 py-2 text-center">
            <button @click="editUser(user)" class="text-yellow-500 hover:underline">Editar</button>
            <button @click="deleteUser(user.id)" class="text-red-500 hover:underline ml-2">Excluir</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal -->
    <Modal :isOpen="isModalOpen" @close="closeModal">
      <form @submit.prevent="saveUser">
        <label class="block mb-2">Nome</label>
        <input v-model="form.name" type="text" class="w-full border px-3 py-2 rounded" required />

        <label class="block mb-2 mt-4">Email</label>
        <input v-model="form.email" type="email" class="w-full border px-3 py-2 rounded" required />

        <div class="flex justify-end mt-4">
          <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Salvar
          </button>
        </div>
      </form>
    </Modal>
  </div>
</template>

<script>
import Modal from '../components/Modal.vue';

export default {
  name: 'Users',
  components: { Modal },
  data() {
    return {
      users: [], // Lista de usuários
      isModalOpen: false,
      form: { id: null, name: '', email: '' },
    };
  },
  methods: {
    async fetchUsers() {
      const response = await this.$http.get('/users'); // Chamada para a API
      this.users = response.data;
    },
    openModal(user = { id: null, name: '', email: '' }) {
      this.form = { ...user };
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
    },
    async saveUser() {
      if (this.form.id) {
        await this.$http.put(`/users/${this.form.id}`, this.form);
      } else {
        await this.$http.post('/users', this.form);
      }
      this.closeModal();
      this.fetchUsers();
    },
    async deleteUser(id) {
      await this.$http.delete(`/users/${id}`);
      this.fetchUsers();
    },
  },
  mounted() {
    this.fetchUsers(); // Busca inicial dos dados
  },
};
</script>
