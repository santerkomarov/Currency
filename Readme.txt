Выполнение задания на позицию Web-разработчик II.

1. Создал базу данных MySQL с таблицей currency с колонками: valuteID, numCode, сharCode, name, value, date. 
2. Заполнил таблицу данными (bd.php) с сайта http://www.cbr.ru/development/SXML/ за 30 дней.
3. Создал страницу авторизации (entrance.php). Авторизация по логину и паролю. Учетные данные статичные, пароль без хеширования. Логин: Boss,  пароль: MainAdmin.
4. Страница просмотра валют по дате (currencies.php) доступна после авторизации. Проверка авторизации с SESSION.
5. На этой странице доступен просмотр данных валют на выбранную из селектора дату.
6. Создал страницу для получения данных с API методом GET (api.php). Доступные дата запроса от 01/04/2022 до 02/03/2022 включительно. 
   Пример запроса: .../api.php?date=20/03/2022 . Ответ в json формате. При выходе из диапазона дат или неверного написания даты (символ вместо цифры) возвращается ошибка с описанием.
7. Просмотр результата задания на странице: http://santerdg.beget.tech/currency/index.php . API - http://santerdg.beget.tech/currency/api.php?date=03/03/2022 .