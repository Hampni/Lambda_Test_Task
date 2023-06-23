
## Instalation of the project:

Make sure port 8000 is not busy. App is using standart .env file.

```bash
docker-compose -f docker-compose.prod.yml up --build -d
```
```bash
docker exec lambda-app php bin/console doctrine:migration:migrate --no-interaction
```
```bash
docker exec lambda-app php bin/console doctrine:fixtures:load --no-interaction --append
```

## For development purposes:

```bash
docker-compose -f docker-compose.dev.yml up --build -d
```

## You can find api docs here:
http://localhost:8000/api/

## To get product final price:

Request to:  `/api/product_price/{id}/{iso_code}`

Example: `/api/product_price/1/UA`

## Database structure:
![Database structure](./migrations/db_structure.png)
