# Change Environmental Variable

_This changes the value of an environmental variable. Please note if your variables are cached you will need to take
care of re-caching them if required. If running in production, without the --silent option passed, this will warn you
you're about to make changes_


## Usage

```bash
# Sets DB_HOST to 127.0.0.1
php artisan env:set DB_HOST 127.0.0.1 

# MY_VAR should contain nothing
php artisan env:set MY_VAR --blank 
 
# Sets DB_HOST to 127.0.0.1 but if production it will not warn you
php artisan env:set DB_HOST 127.0.0.1 --silent
```
