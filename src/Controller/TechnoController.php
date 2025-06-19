<?php

namespace App\Controller;

use App\Entity\Techno;
use App\Form\TechnoForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TechnoController extends AbstractController
{
    #[Route('/techno/new', name: 'app_techno_new')]
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $techno = new Techno();
        $form = $this->createForm(TechnoForm::class, $techno);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($techno);
            $manager->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render('techno/new.html.twig', [
            'form' => $form,
        ]);
    }
}
