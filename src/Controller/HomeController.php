<?php

namespace App\Controller;

use App\Form\ContactForm;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        ProjectRepository $projectRepository,
        Request $request,
        MailerInterface $mailer
    ): Response {
        $projects = $projectRepository->findAll();

        $form = $this->createForm(ContactForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $email = (new Email())
                ->from($data['email'])
                ->to('contact@arthurperdreau.com')
                ->subject('Portfolio message de ' . $data['name'])
                ->text($data['message']);

            $mailer->send($email);
            $this->addFlash('success', 'Your message has been sent!');

            return $this->redirectToRoute('home', ['_fragment' => 'contact']);
        }

        return $this->render('home/index.html.twig', [
            'projects' => $projects,
            'contactForm' => $form->createView(),
        ]);
    }
}
