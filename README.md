# Symfony6 EventSourcing with Broadway
This short example shows how to create an event sourced User and to use it with Symfony Security
### Quick Start
This project runs with docker. To start the needed containers, simply use the command<br />`make start`

### Database
First of all, you need to set **DB_PASSWORD** env var.

Then change the **DATABASE_URL** var from .env with default params:
- user: root
- password: the **DB_PASSWORD** value

To create the database, you need to run the following command<br />
`docker exec -it s6es-php bash -c "bin/console doctrine:database:create" `<br />

### Event Store
To create the Event Store, you need to run the following command<br />
`docker exec -it s6es-php bash -c "bin/console broadway:event-store:create" `<br />

### User ReadModel
To create the mysql table of the user read model, you need to run the following command<br />
`docker exec -it s6es-php bash -c "bin/console broadway:read-model:create rm_user" `<br />

### Set the project host
In your `/etc/hosts` add `127.0.0.1 s6es.local`

### Create a new user
From a terminal, send the following POST request<br />
```
curl -X POST http://s6es.local:8181/api/users/register
-H 'Content-Type: application/json'
-d '{"username": "Test","password": "changeme!","email": "test@test.com","roles": ["ROLE_USER"]}'
```

The api should return a response as following<br />
`[{"uuid": "40927741-1dc6-4092-8f8f-29991a6829d0","username": "Test"}]`

In the database, you should see new lines in tables `events`, `rm_user` and `user` 

### Login
From a terminal, send the following GET request<br />
```
curl -X GET http://s6es.local:8181/api/login
-H 'Content-Type: application/json'
-d '{"password": "changeme!","username": "Test"}'
```

The api should return a response as following<br />
`{
"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2OTUxMzQ4OTMsImV4cCI6MTY5NTEzODQ5Mywicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiUm9iaW4ifQ.YF7wdlG2VgoqPor3jlt1jWcSgnlx0iLLlKuZ9iUysAf8xsP7J_uuRUirrO0INAq4nuiyuW0CTr-tDDO0B2SCSL4o7mg2PXCroA5EGpIwFFUmOAyUCZG0y_wa2rV4Xk31yQ0MLkQrcoDHcjdJgsx1mmJYTUrnk-nU9_Ht8qT85wlMfIO9Jib0laM9axPjgs-olkLBuN-XptJ4_jJuGWwrbucgO6DxRx6h_iHeS5y4JQtplDdtKXFNU1aTg2Iom3wSxtRhHBAV4G3dC61D1Gza7DSYmqkW-RunoNnQsdHUozlgV7UwwYQ8THfNDuQb9SWJTq5rqMFZsq51z_ziks3VpA"
}`