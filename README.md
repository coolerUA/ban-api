Интерфейс блокировки IP на шлюзе, для предотвращения попадания трафика на сервера за шлюзом.

Принцип работы.

1) На клиенте собирается список адресов для блокировки (путем анализирования логов веб-сервера).

Подготавливается файл списка, либо можно использовать конвеер предварительно удостоверившись в 
том, что данные будут приходить в конвеер формата "IP$" (знак доллара в конце строки), либо 
любой другой удобный делиметер, который необходимо изменить в файле inc/fund_db.php в функции
function put($content){ $c=explode("$",$content, -1);
и index.php

2) Отправка на сервер путем PUT запроса.
Пример:
```bash
$ cat -E ip_list  |grep -v "^$" | curl -X PUT http://api-ban.dummy.net/`echo admin@dummy.net |base64`/`echo "bad boys"|base64`/ --data @-
```
Где:
```
ip_list
```
файл со списком



```
http://api-ban.dummy.net/
```
адрес сервера



```
echo admin@dummy.net |base64
```
ключ авторизации



```
echo "bad boys"|base64
```
комментарий


3) Блокировка на шлюзе скриптом.
Пример:
```bash
$ /sbin/ipset -q --flush && for i in `curl -X GET http://api-ban.dummy.net/\`echo admin@dummy.net|base64\`/`; do /sbin/ipset -A BAN $i;done
```

Авторизация клиента по ключу + source.IP.
Добавление нового ключа клиента:
```
INSERT INTO  `users` (`userid` ,`key` ,`userip` ,`comments` ,`enable`)VALUES (NULL , 'YWRtaW5AZHVtbXkubmV0Cg==', '10.11.12.13',  'user admin@dummy.net from 10.11.12.13',  '1');
```
