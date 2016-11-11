<?php

namespace AppBundle\EventListener;
use Oneup\UploaderBundle\Event\PostPersistEvent;

class UploadListener {

    public function __construct() {
        // construc here
        // for eg object manager
    }

    public function onOneupUploaderPostPersist(PostPersistEvent $event) {
        $response = $event->getResponse();

        $file = $event->getFile();

        //break here, otherwise default script will continue
        header('Content-Type: application/json');
        header('HTTP/1.1  200 OK');

        print(json_encode(
            array(
                'filename' => $file->getFileName(),
                'status' => 'success'
            )
        ));

        // function name is camel case of oneup_uploader.post_persist event name (if not specify method)
        exit();
    }
}
