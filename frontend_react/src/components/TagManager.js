import React, { useState, useEffect } from 'react';
import TagService from '../services/TagService';
import Modal from './Modal';

function TagManager() {
  const [tags, setTags] = useState([]);
  const [editingTag, setEditingTag] = useState(null);
  const [newTag, setNewTag] = useState({ name: '' });
  const [showModal, setShowModal] = useState(false);
  const [error, setError] = useState('');

  useEffect(() => {
    TagService.getAll()
      .then(data => setTags(data))
      .catch(error => console.error('Error fetching tags:', error));
  }, []);

   useEffect(() => {
      if (editingTag) {
        setNewTag(editingTag);
      } else {
        setNewTag({ name: '' });
      }
    }, [editingTag]);

  const handleDeleteTag = (tagId) => {
    TagService.delete(tagId)
      .then(() => setTags(tags.filter(tag => tag.id !== tagId)))
      .catch(error => console.error('Error deleting tag:', error));
  };

  const handleTagSubmit = (e) => {
    e.preventDefault();
    if (!newTag.name) {
      setError('O nome da tag é obrigatório!');
      return;
    }

    const action = editingTag
      ? TagService.update(editingTag.id, newTag)
      : TagService.create(newTag);

    action
      .then(data => {
        if (editingTag) {
          setTags(tags.map(tag => (tag.id === editingTag.id ? data : tag)));
        } else {
          setTags([...tags, data]);
        }
        setEditingTag(null);
        setNewTag({ name: '' });
        setError('');
        setShowModal(false);
      })
      .catch(error => console.error('Error submitting tag:', error));
  };

  return (
    <div>
      <table className="table">
  <thead>
    <tr>
      <th>Tag</th>
      <th className="actions-column">Ações</th>
    </tr>
  </thead>
  <tbody>
    {tags.map(tag => (
      <tr key={tag.id}>
        <td>{tag.name}</td>
        <td className="table-actions">
          <button
            className="button edit"
            onClick={() => setEditingTag(tag)}
          >
            Editar
          </button>
          <button
            className="button delete"
            onClick={() => handleDeleteTag(tag.id)}
          >
            Excluir
          </button>
        </td>
      </tr>
    ))}
  </tbody>
</table>
<button onClick={() => {
  setEditingTag(null);
  setNewTag({ name: '' });
  setShowModal(true);
}}>Adicionar Nova Tag</button>
<br></br>
      <Modal show={!!editingTag || showModal } onClose={() => {
        setEditingTag(null);
        setNewTag({ name: '' });
        setShowModal(false);
      }} title={editingTag ? 'Editar Tag' : 'Adicionar Nova Tag'}>
        <form onSubmit={handleTagSubmit}>
          <input
            type="text"
            placeholder="Nome da Tag"
            value={newTag.name}
            onChange={(e) => setNewTag({ ...newTag, name: e.target.value })}
          />
          {error && <p className="error-message">{error}</p>} {/* Mostra erro se existir */}
          <button type="submit">Salvar</button>
        </form>
      </Modal>
      <p>JSON de api/tags:</p>
      {!tags && !error ? (
        <p>Carregando...</p>
      ) : (
        <pre style={styles.json}>{JSON.stringify(tags, null, 2)}</pre>
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

export default TagManager;
