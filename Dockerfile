# Usa a imagem oficial do PHP com Apache
FROM php:8.2-apache

# Instala ferramentas essenciais para o servidor e para o atacante (netcat, python)
RUN apt-get update && apt-get install -y \
    iputils-ping \
    netcat-traditional \
    python3 \
    sudo \
    && rm -rf /var/lib/apt/lists/*

# ---------------------------------------------------------
# FLAG 1: Acesso Web (Requer Bypass de WAF)
# ---------------------------------------------------------
RUN mkdir -p /var/www/html/assets_secretos
RUN echo "FLAG{1_w4f_byp4ss_m4st3r}" > /var/www/html/assets_secretos/flag_01.txt
RUN chown -R www-data:www-data /var/www/html/assets_secretos

# ---------------------------------------------------------
# FLAG 2: Movimentação Lateral (Requer Reverse Shell)
# ---------------------------------------------------------
RUN useradd -m aegis_admin
RUN echo "FLAG{2_r3v3rs3_sh3ll_1ns1d3r}" > /home/aegis_admin/flag_02.txt
# Apenas o usuário aegis_admin e o root podem ler este arquivo
RUN chown root:aegis_admin /home/aegis_admin/flag_02.txt
RUN chmod 640 /home/aegis_admin/flag_02.txt

# ---------------------------------------------------------
# FLAG 3: Escalonamento de Privilégios (Root)
# ---------------------------------------------------------
RUN echo "FLAG{3_r00t_pr1v3sc_c0mm4nd_1nj3ct10n}" > /root/flag_03.txt
RUN chown root:root /root/flag_03.txt
RUN chmod 600 /root/flag_03.txt

# Cria a vulnerabilidade de PrivEsc: 
# Permite que o usuário do servidor web (www-data) rode o comando 'awk' como root sem pedir senha!
RUN echo "www-data ALL=(root) NOPASSWD: /usr/bin/awk" >> /etc/sudoers

# Copia a aplicação web
COPY index.php /var/www/html/index.php
RUN chown www-data:www-data /var/www/html/index.php