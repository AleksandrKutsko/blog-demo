# Тестовый блог на чистом PHP

Простой блог на чистом PHP с использованием MySQL и Smarty, запускаемый в Docker.

## 🚀 Быстрый старт

### Требования
- Docker
- Docker Compose
- Git

### Установка

1. **Клонировать репозиторий**
   ```bash
   git clone <url-вашего-репозитория>
   cd <имя-папки-проекта>

2. **Запустить Docker контейнеры**

    ```bash
    docker-compose up -d --build

3. **Установить зависимости через Composer**

    ```bash
    docker-compose exec php composer install
   
4. **Настроить права на папки**

    ```bash
    docker-compose exec php chmod -R 777 templates_c/
    docker-compose exec php mkdir -p public/uploads
    docker-compose exec php chmod -R 777 public/uploads

5. **Заполнить базу тестовыми данными (сидинг)**

    ```bash
    docker-compose exec php php seed.php