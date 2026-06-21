CREATE DATABASE IF NOT EXISTS imperiodosdoces;

USE imperiodosdoces;

CREATE TABLE produtos (
    id_produto INT AUTO_INCREMENT PRIMARY KEY,
    nm_produto VARCHAR(100) NOT NULL,
    ds_produto TEXT NOT NULL,
    vl_preco DECIMAL(10,2) NOT NULL,
    img_produto VARCHAR(100) NOT NULL,
    nm_categoria VARCHAR(50) NOT NULL
);

CREATE TABLE pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    nm_cliente VARCHAR(100) NOT NULL,
    nr_telefone VARCHAR(20) NOT NULL,
    ds_endereco VARCHAR(255) NOT NULL,
    dt_pedido DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    vl_total DECIMAL(10,2) NOT NULL,
    st_pedido VARCHAR(30) NOT NULL DEFAULT 'Recebido'
);

CREATE TABLE itens_pedido (
    id_item INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT NOT NULL,
    id_produto INT NOT NULL,
    qt_produto INT NOT NULL,
    vl_preco_unitario DECIMAL(10,2) NOT NULL,
    vl_subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido),
    FOREIGN KEY (id_produto) REFERENCES produtos(id_produto)
);

INSERT INTO produtos
(nm_produto, ds_produto, vl_preco, img_produto, nm_categoria)
VALUES
('Brownie', 'Brownie macio, chocolatudo e com casquinha crocante.', 8.00, 'Brownie.jpeg', 'Chocolate'),
('Palha Italiana Dois Amores', 'Palha italiana com chocolate branco e chocolate preto.', 7.50, 'Palha-Italiana.jpeg', 'Chocolate'),
('Palha Italiana de Oreo', 'Palha italiana cremosa feita com chocolate e pedacos crocantes de Oreo.', 8.50, 'Palha-Italiana-Oreo.jpeg', 'Chocolate'),
('Beijinho Gourmet', 'Doce de coco com textura cremosa e sabor delicado.', 4.00, 'beijinho.jpeg', 'Festa'),
('Copo da Felicidade', 'Camadas de creme, chocolate, bolo e recheios especiais.', 15.00, 'copo-felicidade.jpeg', 'Especial');