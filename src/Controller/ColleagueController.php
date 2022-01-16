<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ColleagueController extends AbstractController
{
    /**
     * @Route("/colleague", name="colleague")
     */
    public function index(): Response
    {
        return $this->render('colleague/index.html.twig', [
            'controller_name' => 'ColleagueController',
        ]);
    }
}
