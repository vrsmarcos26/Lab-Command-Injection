<div align="center">
  <h1>
    <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Animated-Fluent-Emojis/master/Emojis/Objects/Bomb.png" alt="Bomba" width="45" height="45" />
    Laboratório de Command Injection
    <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Animated-Fluent-Emojis/master/Emojis/Objects/Computer.png" alt="Computador" width="45" height="45" />
  </h1>
</div>

<p align="center">
  <img alt="Linguagem Principal" src="https://img.shields.io/github/languages/top/vrsmarcos26/Lab-Command-Injection?style=for-the-badge&color=777BB4">
  <img alt="Licença" src="https://img.shields.io/github/license/vrsmarcos26/Lab-Command-Injection?style=for-the-badge&color=blue">
  <img alt="Último Commit" src="https://img.shields.io/github/last-commit/vrsmarcos26/Lab-Command-Injection?style=for-the-badge&color=green">
</p>

<p align="center">
  Uma aplicação web simples e vulnerável a Command Injection, criada para fins educacionais e baseada nos estudos do HackingClub.
</p>

<p align="center">
  <a href="#-aviso-importante">Aviso</a> •
  <a href="#-objetivos-de-aprendizagem">Objetivos</a> •
  <a href="#-tecnologias-utilizadas">Tecnologias</a> •
  <a href="#-como-rodar-o-laboratório">Como Rodar</a> •
  <a href="#-créditos">Créditos</a> •
  <a href="#-licença">Licença</a>
</p>

---

### ⚠️ Aviso Importante

> **Este projeto é intencionalmente vulnerável.** Ele foi criado para fins estritamente educacionais. **NÃO FAÇA O DEPLOY DESTA APLICAÇÃO EM UM SERVIDOR PÚBLICO OU DE PRODUÇÃO.** Use-o apenas em um ambiente local e controlado.
>
> **Nota:** Este laboratório foi projetado para rodar em um ambiente **Windows**, pois utiliza o `powershell` para executar os comandos.

---

### 🎯 Objetivos de Aprendizagem

Este laboratório foi projetado para demonstrar na prática:

-   O que é uma vulnerabilidade de **Injeção de Comandos (Command Injection)**.
-   Como a concatenação de entradas do usuário em comandos de sistema pode ser explorada.
-   O perigo de utilizar funções como `system()`, `exec()`, `passthru()` e `shell_exec()` em PHP com dados não sanitizados.
-   A importância de validar e sanitizar todas as entradas do usuário antes de processá-las.

---

### 🛠️ Tecnologias Utilizadas

Este ambiente de laboratório é construído com tecnologias web básicas:

<p align="center">
  <a href="https://www.php.net/"><img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP"></a>
  <a href="#"><img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white" alt="HTML5"></a>
</p>

---

### ⚙️ Como Rodar o Laboratório

Para executar o laboratório, você precisará dos seguintes pré-requisitos:

#### **1. Pré-requisitos**
-   **Sistema Operacional Windows:** Essencial, pois o script invoca o `powershell`.
-   **PHP instalado:** Necessário para executar o servidor web local.

#### **2. Clone o Repositório**
```bash
# Lembre-se de nomear seu repositório como 'Lab-Command-Injection' ou ajuste o comando
git clone [https://github.com/vrsmarcos26/Lab-Command-Injection.git](https://github.com/vrsmarcos26/Lab-Command-Injection.git)
cd Lab-Command-Injection
