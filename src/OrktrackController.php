<?php

namespace Opnuc\OpnucOrktrack;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Input;
use \Carbon\Carbon;

class OrktrackController extends BaseController
{
    public function command()
    {

        switch(Input::get('type')){
            case 'init':
                return 'class=simpleresponse success=true comment=Init_OK.';
                break;
            case 'tape':
                // type=tape
                // recid=20171005_164623_CEMC
                // stage=ready
                // captureport=CEMC
                // timestamp=1507189583
                // filename=2017%2F10%2F05%2F16%2F20171005_164623_CEMC.wav
                // localparty=0xxxxxxxxx
                // localentrypoint=
                // remoteparty=03xxxxxxxx
                // direction=out
                // duration=179
                // service=orkaudio-raspberrypi
                // localip=192.168.x.x
                // remoteip=192.168.x.x
                // nativecallid=0xxxxxxxxxx@192.168.xx.x
                if(Input::get('stage') === 'ready'){
                    $record = new Orktrack();

                    $record->recid = Input::get('recid');
                    $record->status = 1;
                    $record->timestamp = Input::get('timestamp');
                    $record->filename = Input::get('filename');
                    $record->localparty = Input::get('localparty');
                    $record->remoteparty = Input::get('remoteparty');
                    $record->duration = Input::get('duration');
                    $record->hostname = Input::get('hostname');

                    $record->save();
                    dispatch(new OrktrackJob($record));
                }
                return 'class=simpleresponse success=true comment=OK.';
                break;
            default:
                return 'class=simpleresponse success=false comment=invalid_type.';
                break;
        }

    }
}