FROM php:8.0

# Instalar extensões PDO e PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copiar os arquivos do código-fonte do backend para o contêiner
COPY . /var/www/html

# Definir o diretório de trabalho no contêiner
WORKDIR /var/www/html

# Instalar o cliente PostgreSQL para executar comandos SQL
RUN apt-get update && apt-get install -y postgresql-client

# Expor a porta 8000 do contêiner (opcional, apenas se você quiser expor a porta durante a execução)
EXPOSE 8000

# Comando para iniciar o servidor PHP embutido
 
CMD ["php", "-S", "0.0.0.0:8000"]
