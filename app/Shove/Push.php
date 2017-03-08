<?php

namespace App\Shove;

use Illuminate\Support\Facades\Facade;

class Push extends Facade
{

    const MIME_IMAGE = "image";
    const MIME_REPORT = "report";
    const MIME_DOCUMENT = "document";
    const MIME_OBJECT = "object";
    const MIME_EMBED = "embed";
    const MIME_MEDIA = "media";
    const MIME_FONT = "font";
    const MIME_SCRIPT = "script";
    const MIME_SERVICEWORKER = "serviceworker";
    const MIME_WORKER = "worker";
    const MIME_STYLE = "style";
    const MIME_MANIFEST= "manifest";
    const MIME_XSLT = "xslt";

    protected $pushables = [];


    public function push($resource, $mime="")
    {
        $this->pushables[$resource] = $mime;
    }

    public function getPushables()
    {
        return $this->pushables;
    }

    public function clear()
    {
        $this->pushables = [];
    }

    protected static function getFacadeAccessor() { return 'push'; }

}