# OpnUC OrkTrack Package

## 導入方法

### 設定

```.env
QUEUE_DRIVER=database
```

### キューテーブルのマイグレーション

```
# php artisan queue:table
# php artisan queue:failed-table
# php artisan migrate
```

### キューの実行

pm2などでデーモン化する必要があります。

```
# php artisan queue:work
```

