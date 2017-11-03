<?php

namespace Opnuc\OpnucOrktrack;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Opnuc\OpnucOrktrack\Events\OrktrackDownloadEvent;

class OrktrackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $record;

    /**
     * 新しいジョブインスタンスの生成
     * @param  Orktrack $record
     * @return void
     */
    public function __construct(Orktrack $record)
    {
        $this->record = $record;
    }

    /**
     * ジョブの実行
     * @return void
     */
    public function handle()
    {

        $config = [
            'raspberrypi' => [
                'host' => '192.168.xx.xx',
                'username' => 'username',
                'password' => 'password',
                'timeout' => 10,
            ],
        ];

        config(['remote.connections.raspberrypi' => $config['raspberrypi']]);

        // 保存先のディレクトリ名を決定
        $prefix = storage_path('app' . DIRECTORY_SEPARATOR . 'orktrack' . DIRECTORY_SEPARATOR);

        // 保存先のディレクトリが存在するか確認
        if(!\File::isDirectory($prefix)){
            // 存在しない場合は、ディレクトリを作成
            \File::makeDirectory($prefix);
        }

        // ローカル側のファイル名を決定
        $filaname = $prefix . $this->record['id'] . '.' . \File::extension($this->record['filename']);

        // SFTPで取得
        \SSH::into('raspberrypi')->get('/var/log/orkaudio/audio/' . $this->record['filename'], $filaname);

        echo 'Download Succeed.' . $this->record['filename'] . "\n";

        // SFTPでファイルを削除
        \SSH::into('raspberrypi')->delete('/var/log/orkaudio/audio/' . $this->record['filename']);

        echo 'Remote File Delete Succeed.' . $this->record['filename'] . "\n";

        // イベントを起こして、アプリケーション側に伝える
        event(new OrktrackDownloadEvent($this->record));

    }

    /**
     * 失敗したジョブの処理
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        var_dump($exception);
    }
}