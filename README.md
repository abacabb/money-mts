Тестовое задание
============================

### Развертывание проекта

Создать БД

~~~
CREATE DATABASE money;
~~~

Перейти в каталог проекта:

~~~
cd money-mts
~~~

Запустить composer

~~~
composer install
~~~

Запустить миграции

~~~
./yii migrate
~~~

### Доступное API

#### Пополнить баланс

~~~
POST http://domain/api/v1/wallets/add-funds
{
    "targetWalletId": 1,
    "currencyId": 1,
    "amount": 100
}
~~~
Параметры:
* targetWalletId - кошелек назначения
* currencyId - валютав пополнения
* amount - сумма пополнения

Ответ:

~~~
{
    "id": 4,
    "user_wallet_id": 1,
    "document_id": 23,
    "amount": 100,
    "created_at": "2017-05-15 16:29:23"
}
~~~

#### Получит баланс

~~~
GET http://domain/api/v1/wallets/<id>
~~~
Параметры:
* id - идентификатор кошелька

Ответ:

~~~
{
    "id": 1,
    "user_id": 1,
    "wallet_id": 1,
    "balance": 540.24
}
~~~

#### Получит историю транзакций

~~~
GET http://domain/api/v1/wallets/<id>/history
~~~
Параметры:
* id - идентификатор кошелька

Ответ:

~~~
[
  {
    "id": 18,
    "user_wallet_id": 1,
    "document_id": 23,
    "amount": 100,
    "created_at": "2017-05-15 16:29:23",
    "status": "completed"
  },
  {
    "id": 17,
    "user_wallet_id": 1,
    "document_id": 22,
    "amount": 20,
    "created_at": "2017-05-15 15:37:16",
    "status": "completed"
  },
  {
    "id": 15,
    "user_wallet_id": 1,
    "document_id": 21,
    "amount": -30,
    "created_at": "2017-05-15 15:37:11",
    "status": "completed"
  }
]
~~~

#### Перевод с кошелька на кошелек

~~~
POST http://domain/api/v1/wallets/transfer
{
    "sourceWalletId": 1,
    "targetWalletId": 2,
    "amount": 30
}
~~~
Параметры:
* sourceWalletId - кошелек списания
* targetWalletId - кошелек назначения
* amount - сумма списания/пополнения

Ответ:

~~~
[
  {
    "id": 15,
    "user_wallet_id": 1,
    "document_id": 21,
    "amount": -30,
    "created_at": "2017-05-15 15:37:11"
  },
  {
    "id": 16,
    "user_wallet_id": 2,
    "document_id": 21,
    "amount": 360,
    "created_at": "2017-05-15 15:37:11"
  }
]
~~~
