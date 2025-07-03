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
  <a href="#-como-rodar-o-laboratório">Como Rodar</a> •
  <a href="#-exemplo-de-exploração">Exemplo Prático</a> •
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
git clone [https://github.com/vrsmarcos26/Lab-Command-Injection.git](https://github.com/vrsmarcos26/Lab-Command-Injection.git)
cd Lab-Command-Injection
```

#### **3. Inicie o Servidor Local**
Use o servidor embutido do PHP. Abra o terminal no diretório do projeto e execute:
```bash
php -S 0.0.0.0:8080 -t .
````

#### **4. Acesse o Laboratório**

Abra seu navegador e acesse a URL: `http://localhost:8080` (ou o IP da sua máquina na porta 8080).

-----

### 🎬 Exemplo de Exploração

Abaixo, um passo a passo de como a vulnerabilidade pode ser explorada na prática.

**1. Iniciando o Servidor**
No seu terminal, dentro da pasta do projeto, o servidor é iniciado.

```
PS C:\Users\Marcos\Desktop\Lab-Command-Injection> php -S 0.0.0.0:8080 -t .
[Thu Jul  3 17:42:00 2025] PHP 8.2.12 Development Server ([http://0.0.0.0:8080](http://0.0.0.0:8080)) started
```

**2. Acessando a Página**
No navegador, a aplicação exibe a interface simples para executar o comando `ping`.

**3. Injetando o Comando**
Em vez de um IP válido, inserimos um payload que utiliza o separador de comandos `&` do Windows para adicionar um segundo comando (`dir`) após o `ping`.

**Payload:** `127.0.0.1 & dir`

**4. Analisando o Resultado**
A aplicação executa o `ping` normalmente, mas, logo em seguida, executa o comando `dir` que foi injetado, listando o conteúdo do diretório do servidor diretamente na página.

```
Executando comando: ping 127.0.0.1 & dir

Disparando 127.0.0.1 com 32 bytes de dados:
Resposta de 127.0.0.1: bytes=32 tempo<1ms TTL=128
Resposta de 127.0.0.1: bytes=32 tempo<1ms TTL=128
Resposta de 127.0.0.1: bytes=32 tempo<1ms TTL=128
Resposta de 127.0.0.1: bytes=32 tempo<1ms TTL=128

Estatísticas do Ping para 127.0.0.1:
    Pacotes: Enviados = 4, Recebidos = 4, Perdidos = 0 (0% de
perda),
Aproximar um número redondo de vezes em milissegundos:
    Mínimo = 0ms, Máximo = 0ms, Média = 0ms
 O volume na unidade C não tem nome.
 O Número de Série do Volume é XXXX-XXXX

 Pasta de C:\Users\Marcos\Desktop\Lab-Command-Injection

03/07/2025  17:30    <DIR>          .
03/07/2025  17:30    <DIR>          ..
03/07/2025  17:30    <DIR>          documentos
03/07/2025  17:30    <DIR>          imagens
03/07/2025  17:30    <DIR>          videos
03/07/2025  17:30             1.884 index.php
               1 arquivo(s)          1.884 bytes
               5 pasta(s)   XXX.XXX.XXX.XXX bytes livres
```

A exploração foi bem-sucedida\!

\<details\>
\<summary\>\<strong\>💡 Análise Técnica da Falha (Write-up)\</strong\>\</summary\>

\<br\>

A vulnerabilidade ocorre na linha `system("powershell -Command \"ping -n 4 $ip\"")` do arquivo `index.php`.

1.  **Entrada do Usuário:** A variável `$ip` recebe diretamente o valor do parâmetro `GET` da URL, sem qualquer tipo de validação, filtragem ou escape de caracteres especiais.
2.  **Concatenação Insegura:** Esse valor é então concatenado diretamente em uma string que será executada como um comando no shell do sistema (`powershell`).
3.  **Execução do Comando:** A função `system()` do PHP executa a string final. Quando um payload como `127.0.0.1 & dir` é inserido, o shell interpreta o `&` como um separador que permite a execução de um segundo comando (`dir`) logo após a finalização do primeiro (`ping`). É isso que caracteriza a falha de **Command Injection**.

\</details\>

-----

### 🙌 Créditos

Este projeto foi inspirado e baseado nos conceitos e laboratórios práticos do **Hacking Club**, uma excelente comunidade para o estudo de segurança da informação.

-----

### 📝 Licença

Este projeto está sob a licença MIT. Sinta-se à vontade para usar e modificar o código para seus estudos.

\<hr\>

\<p align="center"\>
Desenvolvido por \<b\>vrsmarcos26\</b\>
\</p\>
