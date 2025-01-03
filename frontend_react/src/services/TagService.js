import axios from 'axios';

const API_URL = 'http://localhost:8000/api/tags';

const TagService = {
  getAll: async () => {
    const response = await axios.get(API_URL);
    return response.data;
  },

  create: async (tag) => {
    const response = await axios.post(API_URL, tag);
    return response.data;
  },

  update: async (id, tag) => {
    const response = await axios.put(`${API_URL}/${id}`, tag);
    return response.data;
  },

  delete: async (id) => {
    await axios.delete(`${API_URL}/${id}`);
  },
};

export default TagService;