# Backup Database

_This command takes a backup of your MYSQL database and stores it to a location of your choosing_

## Usage

```bash
php artisan database:backup [connection?] [--directory=] [--chmod=] [--abs]
```

```bash
## Backups the "mysql" database, mysql is the connection name defined in database.php under the connections key.
## This will be will be saved to the storage/db_backup folder
php database:backup mysql --directory=db_backup 

## This will save the backup to an absolute path provided
php database:backup mysql --directory=/Users/database/backups --abs

## This backups up to db_backup but gives the directory a chmod of 0660
php database:backup mysql --directory=db_backup --chmod=0660
```
