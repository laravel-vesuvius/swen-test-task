SWEN
========================

### Up and run
Up docker and move into php container
```
cd docker/
docker-compose up -d
docker-compose exec swn_php bash
```

Install composer dependencies
```
composer install
```

Run migrations
```
php bin/console doctrine:migrations:migrate
```

### Tests

Move into php container
```
cd docker/
docker-compose exec swn_php bash
```

Run migrations
```
php bin/console doctrine:migrations:migrate -e=test
```

Build generated code
```
codecept build
```

Run tests
```
codecept run
```
