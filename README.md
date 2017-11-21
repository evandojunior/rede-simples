# Pacote WorkFlow

# Installation

* Crie um host no NGINX/APACHE
* Direciona a para pasta web do projeto
* Aplique permissões de escrita nas pastas <root-path>/database e <root-path>/web/datafiles => Permissão recursiva
* Restaure o banco de dados em um database de sua preferência
* Ajuste as tabelas: bbp_adm_aplicacao e pol_aplicacao para responder pelo mesmo host configurado no seu apache/nginx
* Ajuste as configurações de conexão em <root-path>/database/globalConfig.php

# Exemplo de configuração NGINX

```sh
server {
	listen 0.0.0.0:80;
	server_name redesimples.prod;

	access_log  /var/log/nginx/redesimples-access.log;
	error_log   /var/log/nginx/redesimples-error.log;

	root /var/www/projeto01/web;

	location / {
		index index.php;
	}

    location ~ ^/api/?(.*)$ {
        try_files $uri $uri/ =404;
        if (-f $request_filename) {
            break;
        }
        rewrite ^(.*) /app.php last;
    }

	location ~ \.php$ {
		fastcgi_pass  phphost:9000;
		fastcgi_intercept_errors on;
		fastcgi_index index.php;
		fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
		include       /etc/nginx/fastcgi_params;
	}
}
```

Banco de dados
----------------------------------------------
* Importar aquivo de banco de dados
```sh
1. Descompactar rede-simples.sql.tar.gz localizado em https://github.com/tilongevo/banco-zerado-urbem3.0
2. mysql -u root -p -h mysqlhost project_rede_simples < rede_simples.sql
```
