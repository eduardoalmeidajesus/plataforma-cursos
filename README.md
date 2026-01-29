# Plataforma de Venda de Cursos

Projeto desenvolvido em **PHP com Laravel** para a disciplina **Desenvolvimento Web Back-End 2**, com o objetivo de implementar uma **API REST** integrada a uma interface web.

---

## 📚 Descrição do Projeto

O sistema **Plataforma de Cursos** tem como objetivo oferecer uma solução para o gerenciamento de cursos online, permitindo o controle básico de **clientes, professores, categorias, cursos e vendas**.

O backend da aplicação foi desenvolvido utilizando o **framework Laravel**, expondo uma **API REST** responsável por processar as requisições e fornecer os dados em formato **JSON**. A interface web (client) foi construída separadamente com **HTML, CSS e JavaScript**, consumindo os endpoints da API por meio de requisições HTTP.

A aplicação utiliza **banco de dados MySQL**, com estrutura criada e versionada por meio de **migrations do Laravel**, garantindo padronização e facilidade de configuração do ambiente.

A interface administrativa substitui as views tradicionais da aplicação, sendo totalmente desacoplada do backend.

### Funcionalidades do sistema:

- ✅ Gerenciamento de clientes (CRUD)  
- ✅ Gerenciamento de professores (CRUD)  
- ✅ Gerenciamento de categorias de cursos (CRUD)  
- ✅ Cadastro e manutenção de cursos  
- ✅ Registro de vendas de cursos (à vista ou parcelado)  
- ✅ Geração de relatórios de vendas com filtro por data  
- ✅ Exportação de relatórios em PDF ou CSV  
- ✅ Integração entre interface web e API REST  

A interface inicia em uma **página principal** (index.html), que fornece acesso às telas administrativas do sistema.

---

## 🛠️ Tecnologias Utilizadas

- PHP 8+  
- Laravel  
- MySQL  
- HTML5  
- CSS3  
- JavaScript (Fetch API)  
- XAMPP  

---

## ▶️ Como Executar o Projeto

### Pré-requisitos

- PHP 8 ou superior  
- Composer  
- MySQL  
- XAMPP  

---

### Passos para execução

1. Clonar o repositório:
   ```bash
   git clone https://github.com/eduardoalmeidajesus/plataforma-cursos

2. Copiar a pasta do projeto para o diretório htdocs do XAMPP:
   ```bash
   C:\xampp\htdocs\plataforma-cursos

3. Iniciar os serviços Apache e MySQL no painel do XAMPP.

4. Criar um banco de dados MySQL com o nome:
   ```bash
   plataforma_cursos

5. Acessar a pasta do backend (API):
   ```bash
   cd plataforma-cursos/api

6. Executar as migrations para criação das tabelas:
   ```bash
   php artisan migrate

7. Iniciar o servidor do backend:
   ```bash
   php artisan serve

8. Acessar a interface web (client) no navegador:
   ```bash
   http://localhost/plataforma-cursos

---

## 🧠 Observações

O backend (API REST) é executado separadamente por meio do comando php artisan serve.

A interface web (client) é servida pelo Apache do XAMPP, a partir da pasta htdocs.

A comunicação entre client e servidor ocorre exclusivamente por meio de requisições HTTP, utilizando JSON.

