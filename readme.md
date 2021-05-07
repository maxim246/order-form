<h1>Задание</h1>

Нужно сделать форму оформления заказа для сайта (Некоторое подобие заказа ГФ).
Для оформления заказа клиент должен:
1. указать телефон и имя
2. выбрать тариф
3. выбрать первый день доставки (из возможных для данного тарифа) и адрес
После оформления заказа в БД должна появиться запись о заказе и клиенте (если
такого клиента не было до этого) .
Все указанные клиентом данные должны быть сохранены.
Все заказы с одним номером телефона должны привязаться к одному клиенту в БД.
Клиентов с одинаковым номером телефона не должно быть в БД.
Тарифы предварительно занесены в БД, у каждого тарифа есть название, цена, и дни
по которым он может доставляться.
Требования
Бэк: PHP, с фреймворком laravel
БД: mysql, postgresql
Фронт: верстка bootstrap, все данные через ajax, оформление заказа без перезагрузки
страницы.

Описание:
В форму заказа вводятся данные. 
<p align="center"><img src="https://github.com/maxim246/order-form/blob/vendor/public/images/main.png" width="400"></p>
Выбирается тариф, отправляется аякс запрос на сервер для получения запрещённых дней для каждого тарифа для валидации даты на фронте.
<p align="center"><img src="https://github.com/maxim246/order-form/blob/vendor/public/images/forbiddenDays.png" width="400"></p>
Динамически изменяются запрещённые даты в календаре.
<p align="center"><img src="https://github.com/maxim246/order-form/blob/vendor/public/images/calendar.png" width="400"></p>
Затем в форму адреса вводится адрес в произвольном формате. Аяксом отрабатывает запрос к серверу, сервер получает запрос через плагин Dadata.
Варианты адресов динамически отрисовываются. Затем можно выбрать конкретный адрес, нажав на него.

Создаём заказ.
