This is Symfony 3 Sandbox
--------------
Run:
`composer install`
then
`php bin/console server:run`

Visit `http://127.0.0.1:8000/upload`


What I know to demo here:

1. `Event listener` vs `Subscriber`
2. Use bower (bowerrc) to manage front-end dependencies (web/assets/vendor)
3. Jquery file uploader
4. [Oneup bundle for file uploader](https://github.com/1up-lab/OneupUploaderBundle/blob/master/Resources/doc/index.md)

---
######1. Event listener vs Subscriber

######EventListener

In app/services.yml
```
app.listener.post_persist_event:
    class: AppBundle\EventListener\UploadListener
    tags:
        - {name: kernel.event_listener, event: oneup_uploader.post_persist} # implicit
        # - {name: kernel.event_listener, event: oneup_uploader.post_persist, method: handlerFunction} # explicit way
```
UploadListener.php file
```
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

```


######Subscriber

In `app/services.yml`
```
app.subscriber.post_persist_event
    class: AppBundle\EventSubscriber\UploadSubscriber
    tags:
        - { name: kernel.event_subscriber }
```

UploadSubscriber.php

```
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

```
