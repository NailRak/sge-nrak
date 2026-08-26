<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AbstractBaseController extends AbstractController
{
   
// public function addInfoMessage($mensaje){
//     $this->addFlash(
//     'info',
//     '$mensaje'
// );
// }
 protected function addInfoMessage(
        string $message
    ): void
    {
        $this->addFlash(
            'info',
            $message
        );
    }

    protected function addWarnMessage(
        string $message
    ): void
    {
        $this->addFlash(
            'warning',
            $message
        );
    }

    protected function addErrorMessage(
        string $message
    ): void
    {
        $this->addFlash(
            'danger',
            $message
        );
    }
}
