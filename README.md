# Diplom_Communal_paymants

ПОСТАНОВКА ЗАДАЧИ
Представляю вашему вниманию мой дипломный проект: Средство автоматизации «Система учета затрат на жилищно-коммунальное обслуживания населения»
На сегодняшний день компьютерные технологии прочно вошли в повседневную жизнь. Практически все предприятия оснащены компьютерами, доступом в интернет и т.д. Компьютеры позволяют ускорить процессы на предприятии, такие как: документооборот, поиск информации, формирование извещений и др.

Целью автоматизации является разработка функционала для автоматизированного учета затрат на жилищно-коммунальное обслуживание населения. Если называть простым языком – этой web-приложение для регистрация и контроль потребителей коммунальных услуг, показаний и формирование извещений.

В моём дипломном проекте были автоматизированы следующие функции:
1)Санкционированный доступ к данным.
2)Регистрация потребителей жилищно-коммунальных услуг.
3)Регистрация и хранение сведений об оказанных услугах.
4)Регистрация показаний индивидуальных приборов учета.
5)Формирование извещений для оплаты.

<!--
![Иллюстрация к проекту](https://github.com/jon/coolproject/raw/master/image/image.png)

![Image alt](https://github.com/{username}/{repository}/raw/{branch}/{path}/image.png) -->

{username} — ваш ник на ГитХабе;
{repository} — репозиторий где хранятся картинки;
{branch} — ветка репозитория;
{path} — путь к месту нахождения картинки.

<!-- Плакат 1 -->
![Image alt](https://github.com/vitas26072001/Diplom_Communal_paymants/raw/main/Photo/+ДП. Плакат. Постановка задачи.png)

Структура системы, web-приложения состроит из трех звеньев:
Клиентская часть
Серверная часть
Система управления базой данных.

Клиентская часть – это графический интерфейс, который отображается в браузере. Пользователь непосредственно взаимодействует с приложением именно через браузер, браузер в свою очередь отправляет HTTP-запросы серверной части. И так же получает ответ от сервера.
В клиентской части формируются такие окна как регистрации, авторизации, меню, вывода, изменения, добавления данных и др. (Показать) 
Клиентская часть разрабатывалась с помощью:
Язык HTML, CSS. Так как дипломный проект – это сайт, то, как и в любом другом сайте, используется язык HTML с каскадными таблицами стилей (CSS). 
Билиотека Bootstrap предназначена для придания сайтам изящности: существует свой набор классов для стандартных элементов, также разработана система вёрстки (резиновая или статическая).

Серверная часть – это основные функции программы, алгоритмы программы. Подробнее расскажу о функция на схеме. Серверная часть разрабатывалась при помощи следующих программных продуктов:
Язык программирования PHP. (рассказать про историю и про скорость работы с веб-приложениями).
Библиотека dompdf предназначена для формирования pdf документа. Использовалась при формировании извещений ЖКХ.

<!-- Плакат2 -->

Система управления базой данных выбрана МySQL. На данном этапе происходит выполнение запросов на выборку, добавление, обновление, удаление, суммирование и группировку и т.д. 
База данный реляционная в 3-й нормальной форме, состоит из четырнадцати таблиц связанных между собой связью один ко многим. 

<!-- Плакат БД -->

ФОРМАЛИЗАЦИЯ ОБЪЕКТА
Проанализировав всё, было решено разделить пользователей на две группы:
Потребитель – это пользователь, который зарегистрировался и вошёл в систему (права «Потребителя ЖКХ»). Ему доступны следующие функции: получение информации об услугах, адресе обслуживания, показаниях и договорах на поставку. Изменение данных потребителя, изменение пароля, добавление и изменение показаний.
Администратор – это пользователь, который зарегистрировался и вошёл в систему (права «Администратор»). Администратор управляет пользователями, всеми справочниками, формирует извещения и договоры и т.д.

<!-- !!!!!!!! -->
СХЕМА РАБОТЫ СИСТЕМЫ / РЕЗУЛЬТАТЫ ИСПЫТАНИЙ

ЭКОНОМИКА
Для созданной системы был произведен расчет экономического эффекта от разработки, результат которого отображен в разделе 4 ПЗ. Чистая прибыль разработчика составила 728 руб., при отпускной цене 4553 руб. и себестоимости 3642 руб.

ВЫВОДЫ:
В данном дипломном проекте было разработано web-приложение для упрощения работы коммунального предприятия. 
С технической стороны программа получилась легкой и удобной для использования. Данное приложение обеспечивает все поставленные задачи.
В отличии от продаваемых подобный программ, разработанное веб приложение имеет простой, понятный и современный пользовательский интерфейс, использует новейшие технологии, которые максимально ускорят работу приложения, а также являются полностью бесплатными.
В дальнейшем данное приложение может быть модифицировано и изменено для более многофункциональной деятельности.

Спасибо за внимание.
