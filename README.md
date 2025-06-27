# 🔗 Mini Projeto de Integração com Múltiplos Sistemas (PHP 8.1+)

Este projeto simula um sistema que integra um **Pedido** com **dois sistemas externos**:  
1. Sistema de **CRM**  
2. Sistema de **Faturamento**

O projeto aplica princípios de boas práticas como:
- DTOs com propriedades `readonly`
- Injeção de dependência
- Interface comum para integradores
- Testes unitários com PHPUnit

---

## 📁 Estrutura


---

## 🚀 Requisitos

- PHP 8.1 ou superior
- Composer

---

## 📦 Instalação

```bash
composer install
```

## Executar exemplo

php index.php

## Saída esperada

[CRM] Registrando cliente José da Silva no CRM
[Faturamento] Emitindo nota para o pedido #101 no valor de R$ 129.99

- Salva na tabela pedidos no MySQL

## Rodar testes

vendor/bin/phpunit tests

# Como Rodar com Docker

## Buildar o container

docker compose build

## Rodar o projeto

docker compose up

## Executa a index manualmente para debug

docker exec -it integrador-app php index.php

## Executar testes

docker compose run --rm app vendor/bin/phpunit tests




