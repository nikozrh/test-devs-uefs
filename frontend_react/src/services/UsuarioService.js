import axios from 'axios';

const API_URL = 'http://localhost:8000/api/usuarios';

const UsuarioService = {
  getAll: async () => {
    const response = await axios.get(API_URL);
    return response.data;
  },

  create: async (usuario) => {
    const response = await axios.post(API_URL, usuario);
    return response.data;
  },

  update: async (id, usuario) => {
    const response = await axios.put(`${API_URL}/${id}`, usuario);
    return response.data;
  },

  delete: async (id) => {
    await axios.delete(`${API_URL}/${id}`);
  },
};

export default UsuarioService;