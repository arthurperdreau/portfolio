<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Project;
use App\Form\ImageForm;
use App\Form\ProjectForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjectController extends AbstractController
{
    #[Route('/project/new', name: 'app_project_new')]
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $project=new Project();
        $form=$this->createForm(ProjectForm::class , $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($project);
            $manager->flush();
            return $this->redirectToRoute('post_image', ['id'=>$project->getId()], );
        }
        return $this->render('project/new.html.twig', [
            'form'=>$form,
        ]);
    }

    #[Route('/project/addimage/{id}', name: 'post_image')]
    public function addImage(Project $project, Request $request, EntityManagerInterface $manager): Response
    {
//        if (!$this->getUser()) {
//            return $this->redirectToRoute('app_login');
//        }
//        if (!in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
//            return $this->redirectToRoute('app_login');
//        }

        $image = new Image();
        $form = $this->createForm(ImageForm::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image->setProject($project);
            $manager->persist($image);
            $manager->flush();

            return $this->redirectToRoute('post_image', ['id' => $project->getId()]);
        }

        return $this->render('project/image.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/product/remove-image/{id}', name: 'remove_image')]
    public function removeImage(Image $image, EntityManagerInterface $manager): Response
    {
//        if(!$this->getUser()){
//            return $this->redirectToRoute('app_login');
//        }
//        if (!in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
//            return $this->redirectToRoute('app_login');
//        }


        $projectId = $image->getProject()->getId();

        $manager->remove($image);
        $manager->flush();

        return $this->redirectToRoute('post_image', ['id' => $projectId]);
    }
}
