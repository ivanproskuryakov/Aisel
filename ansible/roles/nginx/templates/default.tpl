upstream phpfcgi {
    server unix://var/run/php5-fpm.sock;
}

server {
    listen   80;
    server_name  api.aisel.dev;
    root {{app_path}}/web;
    server_tokens off;
    client_max_body_size 25M;

    access_log  {{app_path}}/api.access.log;
    error_log  {{app_path}}/api.error.log;

    # doe app.php weg als ie er staat
    rewrite ^/app_dev\.php/?(.*)$ /$1 permanent;

    location / {
        index app_dev.php;

        try_files $uri @rewriteapp;
    }

    location @rewriteapp {
        rewrite ^(.*)$ /app_dev.php/$1 last;
    }

    location ~ ^/(app|apc|app_dev)\.php(/|$) {
        fastcgi_pass phpfcgi;
        fastcgi_param  SERVER_NAME    $host;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;
        fastcgi_param  SCRIPT_FILENAME    $document_root$fastcgi_script_name;
        fastcgi_param  HTTPS              off;
        fastcgi_read_timeout              120;
    }
}

server {
    listen 80;
    server_name aisel.dev;
    sendfile off;

    root {{app_path}}/frontend/web;
    error_log  {{app_path}}/frontend.error.log;
    access_log {{app_path}}/frontend.access.log;

    location / {
        try_files $uri $uri/index_dev.html index_dev.html;
        if (!-e $request_filename){
            rewrite $ /index_dev.html$1 break;
        }
    }
}

server {
    listen 80;
    server_name admin.aisel.dev;
    sendfile off;

    root {{app_path}}/backend/web;
    error_log  {{app_path}}/backend.error.log;
    access_log {{app_path}}/backend.access.log;

    location / {
        try_files $uri $uri/index.html index.html;
        if (!-e $request_filename){
            rewrite $ /index.html$1 break;
        }
    }
}



