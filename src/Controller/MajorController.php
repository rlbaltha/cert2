<?php

namespace App\Controller;

use App\Entity\Major;
use App\Form\MajorType;
use App\Repository\MajorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/major")
 */
class MajorController extends AbstractController
{
    /** @var ManagerRegistry */
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
    /**
     * @Route("/", name="major_index", methods={"GET"})
     */
    public function index(MajorRepository $majorRepository): Response
    {
        return $this->render('major/index.html.twig', [
            'majors' => $majorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="major_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $major = new Major();
        $form = $this->createForm(MajorType::class, $major);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($major);
            $entityManager->flush();

            return $this->redirectToRoute('major_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('major/new.html.twig', [
            'major' => $major,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="major_show", methods={"GET"})
     */
    public function show(Major $major): Response
    {
        return $this->render('major/show.html.twig', [
            'major' => $major,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="major_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Major $major): Response
    {
        $form = $this->createForm(MajorType::class, $major);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->doctrine->getManager()->flush();

            return $this->redirectToRoute('major_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('major/edit.html.twig', [
            'major' => $major,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="major_delete", methods={"POST"})
     */
    public function delete(Request $request, Major $major): Response
    {
        if ($this->isCsrfTokenValid('delete'.$major->getId(), $request->request->get('_token'))) {
            $entityManager = $this->doctrine->getManager();
            $entityManager->remove($major);
            $entityManager->flush();
        }

        return $this->redirectToRoute('major_index', [], Response::HTTP_SEE_OTHER);
    }
}
