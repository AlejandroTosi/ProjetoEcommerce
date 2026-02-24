-- =========================
-- CATEGORIA
-- =========================
CREATE TABLE categorias (
    id BIGSERIAL PRIMARY KEY,
    tipo VARCHAR(100) NOT NULL UNIQUE
);

-- =========================
-- DESCRICAO
-- =========================
CREATE TABLE descricoes (
    id BIGSERIAL PRIMARY KEY,
    texto TEXT,
    tecnica TEXT
);

-- =========================
-- FORNECEDOR
-- =========================
CREATE TABLE fornecedores (
    id BIGSERIAL PRIMARY KEY,
    cnpj VARCHAR(14) UNIQUE,
    razao_social VARCHAR(150),
    email_contato VARCHAR(150),
    numero_contato VARCHAR(20)
);

-- =========================
-- PRODUTO
-- =========================
CREATE TABLE produtos (
    id BIGSERIAL PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    categoria_id BIGINT,
    descricao_id BIGINT,
    valor NUMERIC(10,2) NOT NULL,
    fornecedor_id BIGINT,
    ativo BOOLEAN NOT NULL DEFAULT true,

    CONSTRAINT fk_produto_categoria
        FOREIGN KEY (categoria_id) REFERENCES categorias(id),

    CONSTRAINT fk_produto_descricao
        FOREIGN KEY (descricao_id) REFERENCES descricoes(id),

    CONSTRAINT fk_produto_fornecedor
        FOREIGN KEY (fornecedor_id) REFERENCES fornecedores(id)
);

-- =========================
-- ESTOQUE
-- =========================
CREATE TABLE estoque (
    produto_id BIGINT PRIMARY KEY,
    quantidade INT NOT NULL,

    CONSTRAINT fk_estoque_produto
        FOREIGN KEY (produto_id) REFERENCES produtos(id)
);

-- =========================
-- IMAGENS
-- =========================
CREATE TYPE imagem_tipo AS ENUM ('capa', 'normal', 'fim');

CREATE TABLE imagens (
    id BIGSERIAL PRIMARY KEY,
    produto_id BIGINT NOT NULL,
    tipo imagem_tipo,
    endereco TEXT NOT NULL,

    CONSTRAINT fk_imagem_produto
        FOREIGN KEY (produto_id) REFERENCES produtos(id)
);

-- =========================
-- TIPO DE CONTA
-- =========================
CREATE TABLE tipos_de_conta (
    id BIGSERIAL PRIMARY KEY,
    descricao VARCHAR(100) NOT NULL UNIQUE
);

-- =========================
-- USUARIO
-- =========================
CREATE TABLE usuarios (
    id BIGSERIAL PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha_hash TEXT NOT NULL,
    tipo_de_conta_id BIGINT NOT NULL,

    CONSTRAINT fk_usuario_tipo_conta
        FOREIGN KEY (tipo_de_conta_id) REFERENCES tipos_de_conta(id)
);

-- =========================
-- ENDERECOS
-- =========================
CREATE TABLE enderecos (
    id BIGSERIAL PRIMARY KEY,
    usuario_id BIGINT NOT NULL,
    rua VARCHAR(200) NOT NULL,
    numero VARCHAR(20),
    cidade VARCHAR(100),
    estado VARCHAR(2),
    cep VARCHAR(10),

    CONSTRAINT fk_endereco_usuario
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- =========================
-- PEDIDOS
-- =========================
CREATE TABLE pedidos (
    id BIGSERIAL PRIMARY KEY,
    usuario_id BIGINT NOT NULL,
    status VARCHAR(30) NOT NULL,
    data_criacao TIMESTAMP NOT NULL DEFAULT now(),
    valor_total NUMERIC(12,2) NOT NULL,

    CONSTRAINT fk_pedido_usuario
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- =========================
-- ITENS DO PEDIDO
-- =========================
CREATE TABLE itens_pedido (
    id BIGSERIAL PRIMARY KEY,
    pedido_id BIGINT NOT NULL,
    produto_id BIGINT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario NUMERIC(10,2) NOT NULL,

    CONSTRAINT fk_item_pedido
        FOREIGN KEY (pedido_id) REFERENCES pedidos(id),

    CONSTRAINT fk_item_produto
        FOREIGN KEY (produto_id) REFERENCES produtos(id)
);

-- =========================
-- CARRINHO
-- =========================
CREATE TABLE carrinho (
    id BIGSERIAL PRIMARY KEY,
    usuario_id BIGINT NOT NULL,
    produto_id BIGINT NOT NULL,
    quantidade INT NOT NULL,

    CONSTRAINT fk_carrinho_usuario
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id),

    CONSTRAINT fk_carrinho_produto
        FOREIGN KEY (produto_id) REFERENCES produtos(id)
);

-- =========================
-- home
-- =========================
CREATE TABLE home (
    id INT PRIMARY KEY DEFAULT 1,
    produtos JSON NOT NULL,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
