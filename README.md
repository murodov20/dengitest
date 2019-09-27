# Test project for "Dengi.Srazu"
---

## Requirements

Minimum requirements:

- Apache2
- PHP7
- Mysql 5.7

## Installation
- Clone project
- Install composer dependencies
- Configure apache2 configurations for backend & api entry points
- Run `init`
- Create new database and edit db config: `/common/config/main-local.php`
- Set `api_base_url` property in `/console/config/params-local.php`. For example: `'api_base_url' => 'http://mytest.yii/api'`
- Migrate
  ```php
  yii migrate
  ```
- Run `yii prepare/install`. This command will generate api user and some settings
- Need 2 cron commands for queue (This is nonpro solution. If you want to professional sln, you need run queue with `supervisor` or `systemd`):
```
* * * * * /usr/bin/php /path/to/project/yii execute-payments
* * * * * /usr/bin/php /path/to/project/yii queue/listen 60
```

Two microservices here:
- Console application as Client
- Api application as API server