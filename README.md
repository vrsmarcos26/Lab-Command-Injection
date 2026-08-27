<div align="center">
  <h1>
    Laboratório de XSS Refletido (CTF Edition) 🛒🛡️
  </h1>
</div>

<p align="center">
  <img alt="Linguagem Principal" src="https://img.shields.io/github/languages/top/vrsmarcos26/Lab-XSS-Reflected-Pr-tica-Educacional?style=for-the-badge&color=777BB4">
  <img alt="Licença" src="https://img.shields.io/github/license/vrsmarcos26/Lab-XSS-Reflected-Pr-tica-Educacional?style=for-the-badge&color=blue">
  <img alt="Último Commit" src="https://img.shields.io/github/last-commit/vrsmarcos26/Lab-XSS-Reflected-Pr-tica-Educacional?style=for-the-badge&color=green">
</p>

<p align="center">
  Uma plataforma de E-commerce (Aegis Pet Market) intencionalmente vulnerável a Cross-Site Scripting (XSS) Refletido, estruturada como uma máquina de CTF em 3 estágios.
</p>

<p align="center">
  <a href="#-aviso-importante">Aviso</a> •
  <a href="#-objetivos-de-aprendizagem">Objetivos</a> •
  <a href="#-tecnologias-utilizadas">Tecnologias</a> •
  <a href="#-como-acessar-o-laboratório">Como Acessar</a> •
  <a href="#-jornada-de-exploração-ctf">Exploração (CTF)</a> •
  <a href="#-créditos">Créditos</a>
</p>

---

### ⚠️ Aviso Importante

> **Este projeto é intencionalmente vulnerável.** Ele foi criado para fins estritamente educacionais e demonstração de falhas web em ambientes controlados. **NÃO FAÇA O DEPLOY DA VERSÃO DOCKER EM UM SERVIDOR PÚBLICO OU DE PRODUÇÃO.**

---

### 🎯 Objetivos de Aprendizagem

Este laboratório foi projetado para demonstrar vulnerabilidades no lado do cliente (Client-Side) originadas por falhas no processamento do Back-end. Você aprenderá:

-   A mecânica do **XSS Refletido**, onde entradas maliciosas são devolvidas na resposta HTTP (HTML) sem a devida sanitização.
-   Técnicas de **Evasão de WAF** focadas no bloqueio de tags explícitas de script.
-   Ataques de **Roubo de Sessão (Cookie Stealing)** via execução de JavaScript arbitrário.
-   O uso de XSS para **Phishing e Defacement**, injetando formulários falsos para capturar credenciais de clientes.

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

Este laboratório possui duas formas de execução, permitindo que você estude da maneira mais conveniente:

#### **Opção 1: Simulador Web (Estudo Básico)**
Uma versão interativa e 100% hospedada no GitHub Pages. Ideal para testar payloads básicos diretamente no navegador.
🔗 **[Acesse o simulador aqui](https://vrsmarcos26.github.io/Lab-XSS-Reflected-Pr-tica-Educacional/simulador/)** *(Não esqueça de ajustar o link para o seu repositório)*

#### **Opção 2: Servidor Real PHP (CTF Completo - Via Docker)**
A experiência ofensiva autêntica. O Back-end em PHP gerencia os cookies de sessão reais e os filtros de segurança.
1. Clone o Repositório:
```bash
git clone [https://github.com/vrsmarcos26/Lab-XSS-Reflected-Pr-tica-Educacional.git](https://github.com/vrsmarcos26/Lab-XSS-Reflected-Pr-tica-Educacional.git)
cd Lab-XSS-Reflected-Pr-tica-Educacional
```
2. Construa e suba o ambiente através do Docker:

```bash
sudo docker-compose up --build -d
```

3. Acesse a aplicação no seu navegador: http://localhost:8080

### 🎬 Jornada de Exploração (CTF)

A barra de busca do E-commerce sofre de uma vulnerabilidade clássica. Sua missão é completar os 3 níveis de exploração.

#### 🚩 Nível 1: Evasão de WAF
O servidor possui um filtro básico que bloqueia qualquer tentativa de usar a tag `<script>`.
Você deve conseguir a execução de código através de atributos baseados em eventos HTML, como `onerror`, `onload` ou `onmouseover`.
**Exemplo de Payload:** `<img src=x onerror=alert(1)>`

#### 🚩 Nível 2: Cookie Stealing (Roubo de Sessão)
XSS é muito mais que exibir caixas de alerta. O administrador logou na loja e um cookie de sessão foi gerado. Sua missão é injetar um payload que leia a propriedade do navegador que armazena esses dados.
**Exemplo de Payload:** `<svg onload=alert(document.cookie)>`

#### 🚩 Nível 3: Defacement / Phishing
Os clientes confiam no layout da loja. Para obter a última flag, injete um campo de captura de senha diretamente no meio da página de resultados. Modificar o DOM para enganar usuários é uma tática comum e letal do XSS.
**Exemplo de Payload:** `<input type="password" placeholder="Confirme sua senha para continuar">`

<details>
<summary><strong>💡 Análise Técnica da Falha (Write-up)</strong></summary>

<br>

A vulnerabilidade se encontra no arquivo `index.php` do Back-end, que lida com o parâmetro `search`.

1.  **A Origem (Source):** O sistema recebe a entrada do usuário através da superglobal `$_GET['search']`.
2.  **O Destino (Sink):** O PHP imprime diretamente esse valor no meio da estrutura HTML utilizando um simples bloco de `echo`. 
3.  **A Falha:** Como o desenvolvedor não utilizou funções de escape e higienização como o `htmlspecialchars()` ou o `htmlentities()`, os caracteres especiais de HTML (`<`, `>`, `"`, `'`) enviados pelo usuário não são convertidos em entidades seguras. O navegador da vítima entende que o código injetado faz parte do código-fonte original da página e o processa ativamente.

</details>

-----

### 🙌 Créditos

Este projeto foi inspirado nos conceitos práticos de segurança ofensiva do **Hacking Club**, sendo estruturado para o aprimoramento em testes de invasão e pesquisa de vulnerabilidades web.

-----

### 📝 Licença

Este projeto está sob a licença MIT. Veja o arquivo LICENSE para mais detalhes.

<hr>

<p align="center">
Desenvolvido por <b>vrsmarcos26</b>
</p>