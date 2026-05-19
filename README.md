
# Laravel проект: API-парсер, динамическая форма, счётчик посещений со статистикой

## 🌐 Демо проекта

Проект уже запущен и доступен для проверки по адресу:  
👉 **[https://gc94sqdt-8000.euw.devtunnels.ms/](https://gc94sqdt-8000.euw.devtunnels.ms/)**

Вы можете сразу перейти по ссылке и протестировать функционал.

---

## 📋 Что реализовано

### Обязательные задания

1. **Консольная команда** `fetch:api-data`  
   - Получает данные из публичного API SpaceX (Crew Dragon) каждые 5 минут.  
   - Сохраняет результат в таблицу `api_records`.

2. **API endpoint** `GET /api/records`  
   - Возвращает все записи из таблицы `api_records` в формате JSON.

3. **JavaScript динамическая форма**  
   - Скрипт `dynamic-form.js` подключается к странице `http://test.amopoint-dev.ru/testzz/testlist.html`.  
   - Показывает только те поля (`input`, `button`), в атрибуте `name` которых есть суффикс `_<выбранное число>` (например, `input_1` для типа 1).

### Дополнительное задание (счётчик посещений)

- **Клиентский скрипт** `statistics.js` собирает IP, город и тип устройства, отправляет данные на сервер.  
- **Бэкенд** сохраняет информацию в таблицу `visits`.  
- **Страница статистики** `/statistics` доступна после авторизации (пароль `secret123`).  
  - Линейный график уникальных посещений по часам (за 7 дней).  
  - Круговая диаграмма разбивки по городам.  
  - Для графиков используется Chart.js.

---

## 🚀 Локальный запуск (для разработки)

### Требования

- PHP >= 8.1
- Composer
- SQLite (расширения `pdo_sqlite` и `sqlite3`)

### Установка

```bash
# 1. Клонируйте репозиторий
git clone <url-репозитория> laravel-project
cd laravel-project

# 2. Установите зависимости
composer install

# 3. Создайте файл базы данных
touch database/database.sqlite

# 4. Настройте .env
#    DB_CONNECTION=sqlite
#    DB_DATABASE=/абсолютный/путь/к/database/database.sqlite

# 5. Сгенерируйте ключ приложения
php artisan key:generate

# 6. Выполните миграции
php artisan migrate

# 7. Запустите сервер
php artisan serve
```

После этого проект будет доступен по адресу `http://127.0.0.1:8000`.


## 📁 Структура ключевых файлов

```
app/
├── Console/Commands/FetchApiData.php          # консольная команда
├── Http/Controllers/
│   ├── ApiRecordsController.php               # API
│   └── StatisticsController.php               # статистика, авторизация
├── Http/Middleware/Authenticate.php           # защита статистики
├── Models/ApiRecord.php
└── Models/Visit.php

database/migrations/
├── ..._create_api_records_table.php
└── ..._create_visits_table.php

public/
├── dynamic-form.js                            # JS для фильтрации полей
└── statistics.js                              # JS сборщик данных

resources/views/
├── welcome.blade.php                          # пример формы (опционально)
├── login.blade.php
└── statistics.blade.php

routes/web.php
```

