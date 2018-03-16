# Yii2 seeds controller

### Installation

```php
composer require sonrac/yii2-seeds
```

or add to your `composer.json` in `require` section

```
"sonrac/yii2-seeds": "~1.0"
```

### Usages

Add to console application config map seed's controller

```
'controllerMap' => [
    ...
    'seed' => [
        'class' => 'sonrac\seeds\SeedsController'
    ],
    ...
]
```

Now you may run 3 commands: 

* `yii seed/run SeedClassName`

This command will be start seed from SeedClassName

Class name is required for action

* `yii seed/run-group seed/name/space`

This command will be start all seed migration from given namespace

Namespace is required for action

* `yii seed/run-all`

This command will be run all seeds from all defined in controller namespaces

### SeedsController options

| option | type | description |
| ------ | ---- | ----------- |
| seedNameSpaces | array | Seeds namespaces. Usages whe you run `run-all` action |

### Seed definition

Seed class must be extended from `sonrac\seeds\Seed` or implemented from `sonrac\seeds\ISeed

### Seed structure

Seed must be has `run` method for seeds running.

Also, you may declare protected method `getData` which returned seed array (or return data from require another php-file) and set public property $_tableName or $modelClass.

Which define $_tableName seed running in batch insert mode

Which define $modelClass and class name extends from \yii\db\ActiveRecord all data saving with model

#### `sonrac\seed\Seed` Options

| option | type | description |
| ------ | ---- | ----------- |
| _tableName | string | Seed table name |
| modelClass | string | Seed model class |
| controller | \yii\console\Controller|null | Current running controller |
| runModelValidation | bool | If you are using saving with model, you can disable/enable model validation during save |
| db | string | DB connection name. If is null usin Yii::$app->db component |
| _controller | \yii\console\Controller|null | Current running controller |


### Tests 

* Copy `phpunit.xml.dist` to `phpunit.xml`
* Run phpunit