## Как запустить

1. Сконируйте себе приложение - **```git clone git@github.com:i3bepb/test_bgs.git```**

2. Перейдите в папку приложения и подтяните также submodule **cd test_bgs && git submodule init && git submodule update**

3. Скопируйте файл .env.example в корне проект в .env - **cp .env.example .env**. Поправьте переменные **MY_USER**, **MY_USER_ID** в **.env** на вашего текущего пользователя на хосте, в момент сборки контейнера будет создан такой же пользователь в контейнерах, чтобы затем при монтировании файлов в контейнер в нем уже был такой же пользователь.

4. Запустите из корня скрипт **./up.sh** 

## Инструкции по работе с API

Для проверки api я использовал postman из него же сформировал документацию по имеющимся методам api. [Ссылка на документацию](https://documenter.getpostman.com/view/6148437/T1DqfwEz) 

### <span style="color:gray">Тестовое задание</span>

<span style="color:gray">Создать API-приложение для управления участниками мероприятия.</span>

<span style="color:gray">Участник содержит поля имя/фамилия/email и привязан к мероприятию</span>

<span style="color:gray">Мероприятие содержит поля название/дата проведения/город (для них api не требуется)</span>

<span style="color:gray">Возможности</span>

1. <span style="color:gray">Добавлять/получать/изменять/удалять участников через http запрос</span>

2. <span style="color:gray">Фильтрация данных при запросе (возвращать только участников определенного мероприятия)</span>

<span style="color:gray">Требования</span>

1. <span style="color:gray">Использование фреймворка lumen/laravel (можно использовать любые дополнительные пакеты)</span>

2. <span style="color:gray">Доступ к API закрыт напрямую</span>

3. <span style="color:gray">Должны быть unit тесты (все покрывать необязательно)</span>

4. <span style="color:gray">Формат возвращаемых данных - json</span>

5. <span style="color:gray">Мероприятия уже существуют в базе при запуске приложения</span>

6. <span style="color:gray">При успешном создании нового участника эмулируется отправка email через очередь (можно писать в лог)</span>

7. <span style="color:gray">Участник уникален по email</span>

<span style="color:gray">Результат</span>

<span style="color:gray">Ссылка на git-репозиторий, содержащий приложение, инструкции для его запуска, инструкции по работе с API</span>

<span style="color:gray">Дополнительное задание (необязательно)</span>

<span style="color:gray">Приложение и его составляющие запускаются внутри docker контейнеров</span>
