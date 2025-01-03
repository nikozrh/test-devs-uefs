# Imagem base com Node.js
FROM node:16-alpine

# Diretório de trabalho dentro do contêiner
WORKDIR /usr/src/app

# Copiar o package.json e o package-lock.json para o contêiner
COPY package*.json ./

# Instalar as dependências
RUN npm install

# Copiar o restante do código do frontend para o contêiner
COPY . .

# Expor a porta 3000
EXPOSE 3000

# Comando para rodar o frontend React
CMD ["npm", "start"]
