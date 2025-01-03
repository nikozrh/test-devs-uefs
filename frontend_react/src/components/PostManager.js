import React, { useState, useEffect } from 'react';
import PostService from '../services/PostService';
import UsuarioService from '../services/UsuarioService'; // Serviço para obter usuários
import TagService from '../services/TagService'; // Serviço para obter tags
import Modal from './Modal';

function PostManager() {
  const [posts, setPosts] = useState([]);
  const [usuarios, setUsuarios] = useState([]); // Lista de usuários
  const [tags, setTags] = useState([]); // Lista de tags
  const [editingPost, setEditingPost] = useState(null);
  const [newPost, setNewPost] = useState({ title: '', content: '', usuario_id: '', tags: [] });
  const [showModal, setShowModal] = useState(false);
  const [error, setError] = useState('');

  useEffect(() => {
    // Carregar posts, usuários e tags
    PostService.getAll()
      .then(data => setPosts(data))
      .catch(error => setError('Error fetching posts:', error.message));

    UsuarioService.getAll()
      .then(data => setUsuarios(data))
      .catch(error => console.error('Error fetching usuários:', error));

    TagService.getAll()
      .then(data => setTags(data))
      .catch(error => console.error('Error fetching tags:', error));
  }, []);

  useEffect(() => {
    if (editingPost) {
      setNewPost({
        title: editingPost.title,
        content: editingPost.content,
        usuario_id: editingPost.usuario?.id || '',
        tags: editingPost.tags?.map(tag => tag.id) || [],
      });
    } else {
      setNewPost({ title: '', content: '', usuario_id: '', tags: [] });
    }
  }, [editingPost]);

  const handleDeletePost = (postId) => {
    PostService.delete(postId)
      .then(() => setPosts(posts.filter(post => post.id !== postId)))
      .catch(error => console.error('Error deleting post:', error));
  };

  const handlePostSubmit = (e) => {
    e.preventDefault();
    if (!newPost.title || !newPost.content || !newPost.usuario_id || newPost.tags.length === 0) {
      setError('Título, conteúdo, autor e tags são obrigatórios!');
      return;
    }
    const action = editingPost
      ? PostService.update(editingPost.id, newPost)
      : PostService.create(newPost);

    action
      .then(data => {
        if (editingPost) {
          setPosts(posts.map(post => (post.id === editingPost.id ? data : post)));
        } else {
          setPosts([...posts, data]);
        }
        setEditingPost(null);
        setNewPost({ title: '', content: '', usuario_id: '', tags: [] });
        setError('');
        setShowModal(false);
      })
      .catch(error => console.error('Error submitting post:', error));
  };

  return (
    <div>
      <table className="table">
        <thead>
          <tr>
            <th>Título</th>
            <th>Conteúdo</th>
            <th>Autor</th>
            <th>Tags</th>
            <th className="actions-column">Ações</th>
          </tr>
        </thead>
        <tbody>
          {posts.map(post => (
            <tr key={post.id}>
              <td>{post.title}</td>
              <td>{post.content}</td>
              <td>{post.usuario?.name}</td>
              <td>{post.tags.map(tag => tag.name).join(', ')}</td>
              <td className="table-actions">
                <button
                  className="button edit"
                  onClick={() => {
                    UsuarioService.getAll()
                      .then(data => setUsuarios(data))
                      .catch(error => console.error('Error fetching usuários:', error));

                    TagService.getAll()
                      .then(data => setTags(data))
                      .catch(error => console.error('Error fetching tags:', error));

                    PostService.getAll()
                      .then(data => setPosts(data))
                      .catch(error => setError('Error fetching posts:', error.message));
                    
                    setEditingPost(post);
                  }}
                >
                  Editar
                </button>
                <button
                  className="button delete"
                  onClick={() => handleDeletePost(post.id)}
                >
                  Excluir
                </button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
      <button onClick={() => {
        // Carregar posts, usuários e tags
      UsuarioService.getAll()
        .then(data => setUsuarios(data))
        .catch(error => console.error('Error fetching usuários:', error));

      TagService.getAll()
        .then(data => setTags(data))
        .catch(error => console.error('Error fetching tags:', error));
      
      PostService.getAll()
        .then(data => setPosts(data))
        .catch(error => setError('Error fetching posts:', error.message));
          
      setEditingPost(null);
      setNewPost({ title: '', content: '', usuario_id: '', tags: [] });
      setShowModal(true);
      }}
      disabled={usuarios.length === 0 || tags.length === 0}
      style={{
        opacity: usuarios.length === 0 || tags.length === 0 ? 0.5 : 1,
        cursor: usuarios.length === 0 || tags.length === 0 ? 'not-allowed' : 'pointer',
      }}
    >Adicionar Novo Post</button>
      <p style={{ color: 'red', display: usuarios.length === 0 || tags.length === 0 ? 'block' : 'none' }}>
        Botão será habilitador após cadastrar usuário(s) e tag(s). Pressione F5.
      </p>
      <br></br>

      <Modal show={!!editingPost || showModal } onClose={() => {
        setEditingPost(null);
        setNewPost({ title: '', content: '', usuario_id: '', tags: [] });
        setShowModal(false);
      }} title={editingPost ? 'Editar Post' : 'Adicionar Novo Post'}>
        <form onSubmit={handlePostSubmit}>
          <input
            type="text"
            placeholder="Título"
            value={newPost.title}
            onChange={(e) => setNewPost({ ...newPost, title: e.target.value })}
          />
          <textarea
            placeholder="Conteúdo"
            value={newPost.content}
            onChange={(e) => setNewPost({ ...newPost, content: e.target.value })}
          />
          <select
            value={newPost.usuario_id}
            onChange={(e) => setNewPost({ ...newPost, usuario_id: e.target.value })}
          >
            <option value="">Selecione um Autor</option>
            {usuarios.map(usuario => (
              <option key={usuario.id} value={usuario.id}>
                {usuario.name}
              </option>
            ))}
          </select>
          Selecione tag(s):
          <select
            multiple
            value={newPost.tags}
            onChange={(e) => setNewPost({
              ...newPost,
              tags: Array.from(e.target.selectedOptions, option => option.value),
            })}
          >
            {tags.map(tag => (
              <option key={tag.id} value={tag.id}>
                {tag.name}
              </option>
            ))}
          </select>
          {error && <p className="error-message">{error}</p>} {/* Mostra erro se existir */}
          <button type="submit">Salvar</button>
        </form>
      </Modal>
      <p>JSON de api/posts:</p>
      {!posts && !error ? (
        <p>Carregando...</p>
      ) : (
        <pre style={styles.json}>{JSON.stringify(posts, null, 2)}</pre>
      )}
    </div>
  );
}

const styles = {
  json: {
    backgroundColor: '#f4f4f4', // Fundo suave
    padding: '10px',            // Espaçamento interno
    borderRadius: '8px',        // Bordas arredondadas
    fontFamily: 'monospace',     // Fonte monoespaçada para alinhamento
    whiteSpace: 'pre-wrap',      // Quebra de linha automática
    overflowWrap: 'break-word',  // Evita palavras longas fora da área
    color: '#008000',              // Cor de texto
    border: '1px solid #ccc',   // Borda suave
    maxHeight: '400px',         // Limite de altura
    overflowY: 'auto',          // Barra de rolagem se necessário
    textAlign: 'left'           // Alinha o texto à esquerda
  },
};

export default PostManager;
