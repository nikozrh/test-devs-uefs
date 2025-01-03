import axios from 'axios';

const API_URL = 'http://localhost:8000/api/posts';

const PostService = {
  getAll: async () => {
    const response = await axios.get(API_URL);
    return response.data;
  },

  create: async (post) => {
    const response = await axios.post(API_URL, post);
    return response.data;
  },

  update: async (id, post) => {
    const response = await axios.put(`${API_URL}/${id}`, post);
    return response.data;
  },

  delete: async (id) => {
    await axios.delete(`${API_URL}/${id}`);
  },
};

export default PostService;