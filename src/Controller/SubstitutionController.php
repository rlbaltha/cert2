<?php

namespace App\Controller;

use App\Entity\Substitution;
use App\Form\SubstitutionType;
use App\Repository\SubstitutionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/substitution")
 */
class SubstitutionController extends AbstractController
{
    /**
     * @Route("/", name="substitution_index", methods={"GET"})
     */
    public function index(SubstitutionRepository $substitutionRepository): Response
    {
        return $this->render('substitution/index.html.twig', [
            'substitutions' => $substitutionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{status}/find", name="substitution_find", methods={"GET"})
     */
    public function find(SubstitutionRepository $substitutionRepositoryy, string $status): Response
    {
        return $this->render('substitution/index.html.twig', [
            'substitutions' => $substitutionRepositoryy->findBy(['status'=>$status]),
        ]);
    }
    /**
     * @Route("/new", name="substitution_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $substitution = new Substitution();
        $form = $this->createForm(SubstitutionType::class, $substitution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($substitution);
            $entityManager->flush();

            return $this->redirectToRoute('substitution_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('substitution/new.html.twig', [
            'substitution' => $substitution,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="substitution_show", methods={"GET"})
     */
    public function show(Substitution $substitution): Response
    {
        return $this->render('substitution/show.html.twig', [
            'substitution' => $substitution,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="substitution_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Substitution $substitution): Response
    {
        $form = $this->createForm(SubstitutionType::class, $substitution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('substitution_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('substitution/edit.html.twig', [
            'substitution' => $substitution,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="substitution_delete", methods={"POST"})
     */
    public function delete(Request $request, Substitution $substitution): Response
    {
        if ($this->isCsrfTokenValid('delete'.$substitution->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($substitution);
            $entityManager->flush();
        }

        return $this->redirectToRoute('substitution_index', [], Response::HTTP_SEE_OTHER);
    }
}
