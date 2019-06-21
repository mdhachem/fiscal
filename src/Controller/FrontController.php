<?php

namespace App\Controller;

use App\Repository\QuizRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="front")
     */
    public function index()
    {
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/home", name="home")
     */
    public function home(QuizRepository $quizRepository)
    {

        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Access not allowed');

        return $this->render('front/index.html.twig', ['quizzes' => $quizRepository->findAll()]);
    }
}
