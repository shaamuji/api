## _Lumen store rest api_




## Configration
update .env file or copy.env.example. with your database values.


## Installation and run
Install the dependencies and devDependencies and start the server.

```sh
composer install
php artisan migrate
php artisan db:seed
```


## Endpoints Doc

NOTE: make you default header values as following
Content-Type: application/json
Accept: application/json

import postman collection link:
https://www.getpostman.com/collections/d5125709e101c7f417ea
#### General Endpoints

| PATH | METHOD | DESC |
| ------ | ------ | ------ |
| api/login | POST | for login and get jwt |
| api/logout | POST| for logout and clear jwt token |
| api/logout | POST | for sign up as a merchanct or as a client  |


#### Admin Endpoints

| PATH | METHOD | DESC |
| ------ | ------ | ------ |
| api/stores | POST | create new store |
| api/products | POST | create product |
| api/products/{id} | PUT | update product |
| api/orders/{id} | PUT| update order state  |


#### Client Endpoints

| PATH | METHOD | DESC |
| ------ | ------ | ------ |
| api/products | GET | Show products to user |
| api/cart-items | POST | add or update product with quantity to cart |
| api/cart-items | GET | show cart detail |
| api/orders/{id} | GET | show order details |
| api/orders | POST| sumbit the order from the cart |



### Example Scenario

after running seeder you can login by dummy merch account (email: merch@store.com,password:123456) as merchant account or (email: client@store.com,password:123456) as a client account. the other option is to register yourself


1 - login service

| PATH | Headers | METHOD | BODY | RESPONSE |
| ------ | ------ | ------ | ------ | ------ |
| api/login | default | POST |{"email":"merch@store.com","password":"123456"}| {"status": "success", "user": { .... }, "authorisation": {  "token": "eyJ0e...","type": "bearer"}}|


save jwt token

2- add store
| PATH | Headers | METHOD | BODY  |
| ------ | ------ | ------ | ------ |
| api/stores | Bearer $token | POST |{"store_title":"store_title","description":"description description","vat_perentage":2,"shipping_cost":10}|


3- create product
| PATH | Headers | METHOD | BODY |
| ------ | ------ | ------ | ------ |
| api/products | Bearer $token | POST |{"title":"prood 1","description":"prood1","derice":11.5,"is_vat_included":true}|





4 - add to cart 

| PATH | Headers | METHOD | BODY  |
| ------ | ------ | ------ | ------ |
| api/cart-items | Bearer $token | POST|{"product_id":2,"quantity":55}|


5 - submit and checkout

| PATH | Headers | METHOD | BODY  |
| ------ | ------ | ------ | ------  |
| api/orders | Bearer $token | POST |--|