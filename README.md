# hellocse-test-technique

## Project Structure
 - app : Presentation logic
 - docker : files used in `compose.yml`
 - src : core logic

## JWT

You must generate jwt secret key to start using it

```bash
php artisan jwt:secret
```

## Files

if you want to display uploaded file with `asset()`, create symbolic link :
```bash
php artisan storage:link
```

## Run
You can use serve :  
```bash
php artisan serve
```

Or docker :   
```bash
docker compose up
```

⚠️ Warning when using docker some commands will need to be run on the app service eg : 

```bash
docker compose exec app php artisan migrate
```

## Migration

```bash
php artisan migrate
```

## Quality

### csfix
https://github.com/PHP-CS-Fixer/PHP-CS-Fixer

```bash
composer csfix
```

### Tests
```bash
composer phpunit
```
