CREATE TABLE pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cliente VARCHAR(100) NOT NULL,
  valor DECIMAL(10,2) NOT NULL,
  descricao TEXT,
  desconto_aplicado BOOLEAN DEFAULT FALSE
);

