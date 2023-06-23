1. `docker-compose -f docker-compose.prod.yml up --build`
2. `docker exec testsymphony_app_1 php bin/console doctrine:migration:migrate --no-interaction `
3. `docker exec testsymphony_app_1 php bin/console doctrine:fixtures:load --no-interaction --append `

Go to http://localhost:8000/api/

Database structure:
![Database structure](./migrations/db_structure.png)
