# yandex-reviews-demo-app

Тестовое приложение для демонстрации получения отзывов по компаниям

## Стек технологий

### Backend

- [PHP](https://www.php.net/) 8.3
- [Laravel](https://laravel.com/docs/10.x) 10
- [Composer](https://getcomposer.org/) 2.9.5
- [MariaDB](https://mariadb.org/) 10.3

### Frontend

- [Node.js](https://nodejs.org/) 16
- [Vue.js](https://v2.vuejs.org/) 2.6
- [Vue CLI](https://cli.vuejs.org/ru/guide/) 4

## Развертывание и запуск

### Первоначальная настройка

Для работы с Docker предварительно потребуется:

- Установить [Docker](https://www.docker.com/)
- Установить [Docker Compose](https://docs.docker.com/compose/)
- [Предоставить права непривилегированному пользователю на работу с Docker](https://docs.docker.com/engine/install/linux-postinstall/#manage-docker-as-a-non-root-user)

1. `git clone git@github.com:mikhailmatveev/yandex-reviews-demo-app.git`
2. `cp .env.example .env`
3. Настроить `.env`
4. `docker-compose build php`
5. `./deploy.sh -d`

С настройками `.env` по-умолчанию frontend будет доступен по адресу http://127.0.0.1:9000 , backend - http://127.0.0.1:8081.

Порт, на котором работает frontend, настраивается через параметр `WEBPACK_DEV_SERVER_PORT` в конфиге `.env` (пригодится, когда локальный порт по-умолчанию `9000` уже занят), например:

```
FRONTEND_PORT=9001
```

Порт, на котором работает backend, настраивается через параметр `BACKEND_PORT` в конфиге `.env` (пригодится, когда локальный порт по-умолчанию `8080` уже занят), например:

```
BACKEND_PORT=8888
```

С настройками `.env` по-умолчанию frontend будет доступен по адресу http://127.0.0.1:9000 , backend - http://127.0.0.1:8081.

Порт, на котором работает frontend, настраивается через параметр `WEBPACK_DEV_SERVER_PORT` в конфиге `.env` (пригодится, когда локальный порт по-умолчанию `9000` уже занят), например:

```
APP_HOST=127.0.0.1
FRONTEND_PORT=9001
WEBPACK_DEV_SERVER_PORT=${APP_HOST}:${FRONTEND_PORT}
```

Порт, на котором работает backend, настраивается через параметр `APP_PORT` в конфиге `.env` (пригодится, когда локальный порт по-умолчанию `8080` уже занят), например:

```
APP_HOST=127.0.0.1
BACKEND_PORT=8888
APP_PORT=${APP_HOST}:${BACKEND_PORT}
```

### На боевой

1. `adduser app` (создать пользователя и залогиниться под ним)
2. `git clone git@github.com:mikhailmatveev/yandex-reviews-demo-app.git`
3. `cp .env.example .env`
4. Настроить `.env`
5. `docker-compose build php`
6. `./deploy.sh -p`

Если сайт работает на HTTPS-протоколе, то для корректного формирования ссылок необходимо в конфиге `docker/nginx/default.conf` раскомментировать строку:

```
fastcgi_param HTTPS on;
```

и применить новую конфигурацию `nginx` командой:

```
docker-compose exec nginx nginx -s reload
``` 

## Админ

В приложении существует единственный пользователь, которому доступна авторизация (admin)

В `.env` это следующие параметры (на боевом меняем на свои)

```
ADMIN_NAME="John Smith"
ADMIN_EMAIL="admin@example.com"
ADMIN_PASSWORD=password
```

## Yandex API

Токен для API Яндекса указывается здесь:

```
YANDEX_API_KEY=<Ваш API key>
```

## Telescope

В проекте имеется мониторинг запросов, ответов, ошибок и т.д. с помощью Telescope, который доступен по-умолчанию по адресу `http://127.0.0.1:8081/telescope`

Так же его необходимо включить в `.env`
```
TELESCOPE_ENABLED=true
```

## Open API Docs

Также в проекте имеется инструмент автогенерации документации по API методам в бекенд части и доступен по-умолчанию по адресу `http://127.0.0.1:8081/api/documentation`
