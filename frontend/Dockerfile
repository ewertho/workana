FROM node:14

# Definir o diretório de trabalho no contêiner
WORKDIR /app

# Copiar os arquivos do código-fonte do frontend para o contêiner
COPY . .

# Instalar as dependências do frontend usando o Yarn
RUN yarn install

# Construir o aplicativo React
RUN yarn build

# Expor a porta 3000 do contêiner (opcional, apenas se você quiser expor a porta durante a execução)
EXPOSE 3000

# Comando para iniciar o aplicativo React com Vite usando o Yarn
CMD ["yarn", "start"]
