# Тестовое задание для Laravel 5.6+

## Описание

Задача создать API приложение для личного бухгалтерского учета. Приложение даст возможность авторизованному пользователю создавать записи о поступлениях и расходах, получать список этих записей, итоговую сумму по расходу, поступлениям и всего.

В этом проекте используются принципы SOLID в макро-масштабе на уровне архитектуры системы.

В коде используется PHPDoc в виде многострочных комментариев в стиле C, используемых для документирования блока кода. Комментарии начинаются с `/**` и имеют звездочку в начале каждой строки. Например в файле 
`App\Http\Controllers\TransactionController.php`

В данном проекте используется типизация, где необходимо.

Используется модуль laravel-request-docs для документирования API. API документация вызывается командой: `/request-docs`

Проект построен на основе стандартных решений **Laravel** и, где необходимо, используется типизация.

Проект соответствует **PSR** стандартам.

Код проекта полностью адаптирован для повторного использования.

В проект добавлен класс **TransactionControllerTest** для использования в юнит-тестах.

Все изменения и добавления в исходный код можно посмотреть на странице:
<https://github.com/mail4github/test_task_laravel2/commits/main/>

## Реализованные команды API:

#### 1. Register a new user

Endpoint: POST /api/register

Description: Register a new user
```
Request:
  Request Body:
    {
      "name": "John Doe",
      "email": "john.doe@example.com",
      "password": "password123",
      "password_confirmation": "password123"
    }

Response:
  - Status Code: 201
  - Response Body:
    {
      "message": "User registered successfully"
    }
```
#### 2. Authenticate and get an access token

Endpoint: POST /api/login

Description: Authenticate and get an access token
```
Request:
  Request Body:
    {
      "email": "john.doe@example.com",
      "password": "password123"
    }

Response:
  - Status Code: 200
  - Response Body:
    {
      "token": "your_access_token"
    }
```
#### 3. Logout the authenticated user

Endpoint: POST /api/logout

Description: Logout the authenticated user (requires token)
```
Request:
  Headers:
    Authorization: Bearer your_access_token

Response:
  - Status Code: 200
  - Response Body:
    {
      "message": "Successfully logged out"
    }
```
#### 4. Add a new transaction

Endpoint: POST /api/transactions

Description: Add a new transaction
```
Request:
  Headers:
    Authorization: Bearer your_access_token
  Request Body:
    {
      "title": "Sample Transaction",
      "amount": 100
    }

Response:
  - Status Code: 201
  - Response Body:
    {
      "id": 1,
      "title": "Sample Transaction",
      "amount": 100,
      "author_id": 1,
      "created_at": "2024-01-01T12:00:00Z",
      "updated_at": "2024-01-01T12:00:00Z"
    }
```
#### 5. Get a list of transactions with optional filters

Endpoint: GET /api/transactions

Description: Get a list of transactions with optional filters
```
Request:
  Headers:
    Authorization: Bearer your_access_token
  Query Parameters:
    - debit: Filter by negative amount (boolean)
    - credit: Filter by positive amount (boolean)
    - min_amount: Minimum transaction amount (integer)
    - max_amount: Maximum transaction amount (integer)
    - created_at: Filter by created date (YYYY-MM-DD)

Response:
  - Status Code: 200
  - Response Body:
    [
      {
        "id": 1,
        "title": "Sample Transaction 1",
        "amount": 100,
        "author_id": 1,
        "created_at": "2024-01-01T12:00:00Z",
        "updated_at": "2024-01-01T12:00:00Z"
      },
      {
        "id": 2,
        "title": "Sample Transaction 2",
        "amount": -50,
        "author_id": 1,
        "created_at": "2024-01-02T12:00:00Z",
        "updated_at": "2024-01-02T12:00:00Z"
      }
    ]
```
#### 6. Get details of a specific transaction

Endpoint: GET /api/transactions/{id}

Description: Get details of a specific transaction
```
Request:
  Headers:
    Authorization: Bearer your_access_token
  Path Parameter:
    - id: Transaction ID (integer)

Response:
  - Status Code: 200
  - Response Body:
    {
      "id": 1,
      "title": "Sample Transaction",
      "amount": 100,
      "author_id": 1,
      "created_at": "2024-01-01T12:00:00Z",
      "updated_at": "2024-01-01T12:00:00Z"
    }
  - Status Code: 404 (Transaction not found)
```
#### 7. Delete a specific transaction

Endpoint: DELETE /api/transactions/{id}

Description: Delete a specific transaction
```
Request:
  Headers:
    Authorization: Bearer your_access_token
  Path Parameter:
    - id: Transaction ID (integer)

Response:
  - Status Code: 204 (Transaction deleted successfully)
  - Status Code: 404 (Transaction not found)
```


