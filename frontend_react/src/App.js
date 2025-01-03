import React from 'react';
import UsuarioManager from './components/UsuarioManager';
import TagManager from './components/TagManager';
import PostManager from './components/PostManager';

function App() {
  return (
    <div style={appStyle}>
      <header style={headerStyle}>
        <h1>Gerenciador de Usuários, Tags e Posts</h1>
      </header>
      <main style={mainStyle}>
        <section style={usuarioManagerStyle}>
          <h2>Gerenciar Usuários</h2>
          <UsuarioManager />
        </section>
        <section style={tagManagerStyle}>
          <h2>Gerenciar Tags</h2>
          <TagManager />
        </section>
        <section style={postManagerStyle}>
          <h2>Gerenciar Posts</h2>
          <PostManager />
        </section>
      </main>
    </div>
  );
}

const appStyle = {
  fontFamily: 'Arial, sans-serif',
  textAlign: 'center',
};

const headerStyle = {
  backgroundColor: '#282c34',
  padding: '20px',
  color: '#FFF',
};

const mainStyle = {
  display: 'flex',
  flexDirection: 'row', // Coloca as seções lado a lado
  flexWrap: 'wrap', // Permite que as seções se movam para a linha seguinte se necessário
  gap: '20px',
  padding: '20px',
  justifyContent: 'center', // Centraliza as seções na tela
};

const usuarioManagerStyle = {
  flex: 2, // A seção UsuarioManager ocupa 2 vezes o espaço da TagManager
  padding: '10px',
  border: '1px solid #ddd',
  borderRadius: '5px',
  boxShadow: '0 2px 4px rgba(0, 0, 0, 0.1)',
};

const tagManagerStyle = {
  flex: 1, // A seção TagManager ocupa 1 vez o espaço
  padding: '10px',
  border: '1px solid #ddd',
  borderRadius: '5px',
  boxShadow: '0 2px 4px rgba(0, 0, 0, 0.1)',
};

const postManagerStyle = {
  width: '100%', // A seção PostManager ocupa toda a largura disponível
  padding: '10px',
  border: '1px solid #ddd',
  borderRadius: '5px',
  boxShadow: '0 2px 4px rgba(0, 0, 0, 0.1)',
};


export default App;
