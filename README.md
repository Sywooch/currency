Yii 2 Модуль
-------------------
Необходимо написать модуль для yii2. 

Требуемая функциональность:
•   Возможность забирать и сохранять курсы доллара и евро с сайта цб 
(http://www.cbr.ru/scripts/XML_daily.asp?date_req=01/01/2016) 
(этот пункт должен легко принимать новые валюты без изменения схемы базы данных) 
(в миграции нужно заполнить историю валют за последние 45 дней)
•   Трейт или бихейвор, который можно навесить на любую модель, которая содержит информацию по работе с деньгами (сделать тестовые модели заказа, товара и баланса клиента)
Трейт должен уметь форматировать стоимость в человекопонятный вид, принимать отформатированный ввод и сохранять в бд, конвертировать из любой валюты в любую.

-------------------
Для демонстрации приложение состоит из нескольких страниц

1. Страницы с товаром
1.1. Добавление товара
1.2. просмотр товара (вывод цены прописью)
1.3. сохранение цены товара прописью, указанная пользователем
1.4. список товаров

2. Страница со списком валют
2.1. общий список валют
2.2 просмотр конкретной валюты с историей (демонстрация использования angular.js 
   admin/views/currency/view.php)


============================
Структура модуля
-------------------

      controllers/        содержит контроллеры
          CurrencyController
          DefaultController
          GoodController
      migrations/         содержит миграции
      models/             содержит модели
          Client
          Goods
          Order
          OrderGoods
          Currency
          CurrencyValues
          
          AbstractStructure
          CurrencyStructure
          
          MoneyTrait
          
          Money
          MoneyUSD
          MoneyRUR
          MoneyEUr
      views/              содержит представления

Требования
------------
1. Yii2
2. В web/js/ добавить http://angular.min.js
3. В web/js/ добавить http://ng-table.min.js


Уcтановка
------------
1. В папку app/module добавить модуль admin

2. Прописать модуль admin в конфигурации
    'modules' => [
        'admin' => [
            'class' => 'app\module\admin\AdminModule',
        ],
     ],
3. Выполнить миграции модуля admin     

