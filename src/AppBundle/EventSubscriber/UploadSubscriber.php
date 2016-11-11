<?php

namespace AppBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Oneup\UploaderBundle\Event\PostPersistEvent;

class UploadSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            'oneup_uploader.post_persist' => array(
                array('handler1', 10),
                //array('handler2', 5)
            )
        );
    }

    /**
     * handler for oneup_uploader.post_persist event
     *
     * @param  PostPersistEvent $event
     * @return mixed
     */
    public function handler1(PostPersistEvent $event) {
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

        exit();
    }

    // public function handler2() {
    //     die('2');
    //     print('event handler2');
    // }
}
