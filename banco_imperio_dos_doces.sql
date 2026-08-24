CREATE DATABASE IF NOT EXISTS imperiodosdoces;

USE imperiodosdoces;

CREATE TABLE IF NOT EXISTS produtos (
    id_produto INT AUTO_INCREMENT PRIMARY KEY,
    nm_produto VARCHAR(100) NOT NULL,
    ds_produto TEXT NOT NULL,
    vl_preco DECIMAL(10,2) NOT NULL,
    img_produto VARCHAR(100) NOT NULL,
    nm_categoria VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    nm_cliente VARCHAR(100) NOT NULL,
    nr_telefone VARCHAR(20) NOT NULL,
    ds_endereco VARCHAR(255) NOT NULL,
    dt_pedido DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    vl_total DECIMAL(10,2) NOT NULL,
    st_pedido VARCHAR(30) NOT NULL DEFAULT 'Recebido'
);

CREATE TABLE IF NOT EXISTS itens_pedido (
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
SELECT 'Brownie', 'Brownie macio, chocolatudo e com casquinha crocante.', 8.00, 'Brownie.jpeg', 'Chocolate'
WHERE NOT EXISTS (SELECT 1 FROM produtos WHERE nm_produto = 'Brownie');

INSERT INTO produtos
(nm_produto, ds_produto, vl_preco, img_produto, nm_categoria)
SELECT 'Palha Italiana Dois Amores', 'Palha italiana com chocolate branco e chocolate preto.', 7.50, 'Palha-Italiana.jpeg', 'Chocolate'
WHERE NOT EXISTS (SELECT 1 FROM produtos WHERE nm_produto = 'Palha Italiana Dois Amores');

INSERT INTO produtos
(nm_produto, ds_produto, vl_preco, img_produto, nm_categoria)
SELECT 'Palha Italiana de Oreo', 'Palha italiana cremosa feita com chocolate e pedacos crocantes de Oreo.', 8.50, 'Palha-Italiana-Oreo.jpeg', 'Chocolate'
WHERE NOT EXISTS (SELECT 1 FROM produtos WHERE nm_produto = 'Palha Italiana de Oreo');

INSERT INTO produtos
(nm_produto, ds_produto, vl_preco, img_produto, nm_categoria)
SELECT 'Beijinho Gourmet', 'Doce de coco com textura cremosa e sabor delicado.', 4.00, 'beijinho.jpeg', 'Festa'
WHERE NOT EXISTS (SELECT 1 FROM produtos WHERE nm_produto = 'Beijinho Gourmet');

INSERT INTO produtos
(nm_produto, ds_produto, vl_preco, img_produto, nm_categoria)
SELECT 'Copo da Felicidade', 'Camadas de creme, chocolate, bolo e recheios especiais.', 15.00, 'copo-felicidade.jpeg', 'Especial'
WHERE NOT EXISTS (SELECT 1 FROM produtos WHERE nm_produto = 'Copo da Felicidade');

CREATE OR REPLACE VIEW vw_resumo_pedidos AS
SELECT
    p.id_pedido,
    p.nm_cliente,
    p.dt_pedido,
    p.vl_total,
    p.st_pedido,
    COUNT(i.id_item) AS qt_itens,
    SUM(i.qt_produto) AS qt_produtos
FROM pedidos p
LEFT JOIN itens_pedido i ON i.id_pedido = p.id_pedido
GROUP BY
    p.id_pedido,
    p.nm_cliente,
    p.dt_pedido,
    p.vl_total,
    p.st_pedido;

DROP TRIGGER IF EXISTS trg_produto_preco_positivo;

DELIMITER $$

CREATE TRIGGER trg_produto_preco_positivo
BEFORE UPDATE ON produtos
FOR EACH ROW
BEGIN
    IF NEW.vl_preco < 0 THEN
        SET NEW.vl_preco = ABS(NEW.vl_preco);
    END IF;
END$$

DELIMITER ;

WITH vendas_produtos AS (
    SELECT
        pr.id_produto,
        pr.nm_produto,
        SUM(ip.qt_produto) AS total_vendido,
        SUM(ip.vl_subtotal) AS total_faturado
    FROM produtos pr
    LEFT JOIN itens_pedido ip ON ip.id_produto = pr.id_produto
    GROUP BY pr.id_produto, pr.nm_produto
)
SELECT *
FROM vendas_produtos
ORDER BY total_faturado DESC;
