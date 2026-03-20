# API Documentation - E-commerce Backend

## Base URL
```
http://localhost:8080
```

## Autenticação
A maioria dos endpoints requer autenticação via JWT token no header:
```
Authorization: Bearer <token>
```

## Endpoints

### 1. Autenticação

#### Login
```http
POST /api/usuarios/login
Content-Type: application/json

{
  "username": "usuario123",
  "senha": "senha123"
}
```

**Resposta:**
```json
{
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
  "id": 1,
  "nome": "João Silva"
}
```

#### Registro
```http
POST /api/usuarios/registrar
Content-Type: application/json

{
  "nome": "João Silva",
  "username": "joao123",
  "email": "joao@email.com",
  "senha": "senha123"
}
```

### 2. Usuário (Autenticado)

#### Perfil
```http
GET /api/usuarios/perfil
Authorization: Bearer <token>
```

#### Atualizar Dados
```http
PUT /api/usuarios
Authorization: Bearer <token>
Content-Type: application/json

{
  "nome": "João Silva Atualizado",
  "email": "joao.novo@email.com"
}
```

### 3. Produtos

#### Listar Produtos
```http
GET /api/produtos
```

#### Buscar com Filtros
```http
GET /api/produtos/buscar?categoriaId=1&min=100&max=500&q=celular
```

#### Detalhes do Produto
```http
GET /api/produtos/{id}
```

#### Criar Produto (Funcionário/Admin)
```http
POST /api/produtos
Authorization: Bearer <token>
Content-Type: application/json

{
  "nome": "Produto Exemplo",
  "valor": 99.99,
  "categoria": {"id": 1},
  "fornecedor": {"id": 1},
  "ativo": true
}
```

### 4. Carrinho (Autenticado)

#### Ver Carrinho
```http
GET /api/carrinho
Authorization: Bearer <token>
```

#### Adicionar ao Carrinho
```http
POST /api/carrinho
Authorization: Bearer <token>
Content-Type: application/json

{
  "produtoId": 1,
  "quantidade": 2
}
```

### 5. Pedidos (Autenticado)

#### Ver Pedidos
```http
GET /api/pedidos
Authorization: Bearer <token>
```

#### Criar Pedido
```http
POST /api/pedidos
Authorization: Bearer <token>
Content-Type: application/json

{
  "itens": [
    {
      "produtoId": 1,
      "quantidade": 2
    }
  ]
}
```

### 6. Home (Público)

#### Produtos em Destaque
```http
GET /api/home
```

## Códigos de Status

- `200` - Sucesso
- `201` - Criado
- `400` - Requisição inválida
- `401` - Não autorizado
- `403` - Proibido
- `404` - Não encontrado
- `500` - Erro interno

## Validações

- **Nome**: 2-150 caracteres
- **Username**: 3-100 caracteres
- **Email**: Formato válido
- **Senha**: Mínimo 6 caracteres

## Roles de Usuário

- `cliente` - Acesso básico
- `funcionario` - Gestão de produtos
- `admin` - Acesso completo</content>
<parameter name="filePath">C:\projetos\Java\ecommerce-backend\API.md
