### Project 
##### Order Restful Service [case-file](https://github.com/atikla/path-case/blob/master/Php%20Developer%20-%20Coding%20Challenge.docx.pdf)

### Setup project environment
- you can run this command after clone git repository
- to clone repository you can use this command:
- ``git clone git@github.com:atikla/path-case.git ./path-case && cd path-case ``
- after clone repository you have to run those two command to build your environment on docker
- ``docker-compose up -d --build``
- ``docker-compose exec php /bin/bash bin/install.sh``
- when commands done you will have running project with php8, nginx, mysql@8, phpmyadmin in your localhost
- project: ``http://localhost:8080/``
- mysql: ``http://localhost:8878/``
- phpmyadmin: ``http://localhost:8879/``

### Project Routes
- you can find project route in table below

| Name                | Method | Path                    | description                            |
|:--------------------|:-------|:------------------------|:---------------------------------------|
| api_order_list      | GET    | /api/order/             | list all order belong to auth user     |
| api_order_show      | GET    | /api/order/{orderCode}/ | show order that belong to auth user    |
| api_order_store     | POST   | /api/order/             | store order to database                |
| api_order_update    | PUT    | /api/order/{orderCode}/ | update exist order that belong to user |
| api_product_list    | GET    | /api/product/           | list all exist products                |
| api_user_register   | POST   | /api/user/register/     | register new user                      |
| api_login_check     | POST   | /api/login_check        | login user and get JWT token           |


### Postman Collection and Collection environment
- you can find postman and environment collections [here](https://github.com/atikla/path-case/tree/master/postman_collection)
- you can find postman api doc from this [link](https://documenter.getpostman.com/view/10527589/UVyysCHx)

