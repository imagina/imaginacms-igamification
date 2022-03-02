# imaginacms-igamification

## Install
```bash
composer require imagina/igamification-module=v8.x-dev
```

## Enable the module
```bash
php artisan module:enable Igamification
```

## Migrations
```bash
php artisan module:migrate Igamification
```

## Events

### ActivityWasCompleted
Add in your Module when your considered that process is completed for logged user

```bash
use Modules\Igamification\Events\ActivityWasCompleted;

$systemNameActivity = "system-name-example";
event(new ActivityWasCompleted($systemNameActivity));
```

### ActivityIsIncomplete
Add in your Module when your considered that process is removed for logged user

```bash
use Modules\Igamification\Events\ActivityIsIncompleted;

$systemNameActivity = "system-name-example";
event(new ActivityIsIncompleted($systemNameActivity));
```
