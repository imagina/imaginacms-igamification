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

## Seeder
```bash
php artisan module:seed Igamification
```

## Example Config Activies in a Module
```bash
'activities' => [
      [
        'system_name' => 'availability-organize',
        'title' => 'ibooking::activities.availability-organize.title',
        'status' => 1,
        'url' => 'ipanel/#/booking/resource/user/'
      ]
  ]
```

## Events

### Example adding event in Entity Module when this model is created
```bash
public $dispatchesEventsWithBindings = [
  'created' => [
        [
          'path' => 'Modules\Igamification\Events\ActivityWasCompleted',
          'extraData' => ['systemNameActivity' => 'system-name-example']
        ]
      ]
  ];
```

### ActivityWasCompleted
Add in your Module when your considered that process is completed for logged user

```bash
if (is_module_enabled("Igamification")) event(new \Modules\Igamification\Events\ActivityWasCompleted([
      'extraData' => [
        'systemNameActivity' => 'system-name-example'
      ]
  ])
);
```