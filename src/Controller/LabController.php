<?php

namespace App\Controller;

use App\Entity\Lab;
use App\Form\LabType;
use App\Repository\LabRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/lab")
 */
class LabController extends AbstractController
{
    /**
     * @Route("/", name="lab_index", methods={"GET"})
     */
    public function index(LabRepository $labRepository, UserRepository $userRepository): Response
    {

        return $this->render('lab/index.html.twig', [
            'labsTeacher' => $labRepository->findBy(['author'=>$userRepository->findOneBy(['username'=>'Cevantime'])]),
            'labs' => $this->isGranted('IS_AUTHENTICATED_FULLY') ? $labRepository->findBy(['author' => $this->getUser()]) : []
        ]);
    }

    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/new", name="lab_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $lab = new Lab();
        $form = $this->createForm(LabType::class, $lab);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lab->setAuthor($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lab);
            $entityManager->flush();

            return $this->redirectToRoute('lab_index');
        }

        return $this->render('lab/new.html.twig', [
            'lab' => $lab,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/preview/{id}", name="lab_preview", methods={"GET"})
     */
    public function preview(LabRepository $labRepository, $id = null): Response
    {
        $lab = $labRepository->find($id);
        if(!$lab) {
            $lab = new Lab();
        }
        return $this->render('lab/preview.html.twig', [
            'lab' => $lab,
        ]);
    }

    /**
     * @Route("/{id}", name="lab_show", methods={"GET"})
     */
    public function show(LabRepository $labRepository, $id = null): Response
    {
        $lab = $labRepository->find($id);
        if(!$lab) {
            $lab = new Lab();
        }
        return $this->render('lab/show.html.twig', [
            'lab' => $lab,
        ]);
    }

    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/{id}/edit", name="lab_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Lab $lab): Response
    {
        if($this->getUser() !== $lab->getAuthor()) {
            return $this->redirectToRoute('index');
        }
        $form = $this->createForm(LabType::class, $lab);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lab->setAuthor($this->getUser());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lab_index', [
                'id' => $lab->getId(),
            ]);
        }

        return $this->render('lab/edit.html.twig', [
            'lab' => $lab,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/live-preview", name="lab_live_preview", methods={"GET","POST"})
     */
    public function livePreview(Request $request): Response
    {
        $lab = new Lab();
        $form = $this->createForm(LabType::class, $lab);
        $form->handleRequest($request);
        return $this->render('lab/preview.html.twig', [
            'lab' => $lab
        ]);
    }
    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/{id}", name="lab_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Lab $lab): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lab->getId(), $request->request->get('_token'))) {
            if($this->getUser() !== $lab->getAuthor()) {
                return $this->redirectToRoute('index');
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lab);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lab_index');
    }
}
