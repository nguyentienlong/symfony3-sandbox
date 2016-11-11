<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DemoController extends Controller
{
    /**
     * @Route("/upload", name= "upload_file")
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function uploadFileAction(Request $request)
    {
        return $this->render('demo/upload.html.twig');
    }
}
