<?php

namespace App\Controller;

use App\Entity\Substitution;
use App\Form\SubstitutionType;
use App\Repository\SubstitutionRepository;
use App\Repository\UserRepository;
use App\Service\Emailer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('substitution/index.html.twig', [
            'substitutions' => $substitutionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{status}/find", name="substitution_find", methods={"GET"})
     */
    public function find(SubstitutionRepository $substitutionRepositoryy, string $status): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('substitution/index.html.twig', [
            'substitutions' => $substitutionRepositoryy->findBy(['status'=>$status]),
        ]);
    }
    /**
     * @Route("/{checklist_id}/new", name="substitution_new", methods={"GET","POST"})
     */
    public function new(Request $request, string $checklist_id): Response
    {
        $checklist = $this->getDoctrine()->getManager()->getRepository('App:Checklist')->find($checklist_id);
        $substitution = new Substitution();
        $substitution->setChecklist($checklist);
        $form = $this->createForm(SubstitutionType::class, $substitution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($substitution);
            $entityManager->flush();

            return $this->redirectToRoute('profile', [], Response::HTTP_SEE_OTHER);
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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('substitution/show.html.twig', [
            'substitution' => $substitution,
        ]);
    }

    /**
     * @Route("/{id}/substitution_approve", name="substitution_approve", methods={"GET"})
     */
    public function approve(String $id, Emailer $emailer): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $substitution = $this->getDoctrine()->getManager()->getRepository('App:Substitution')->find($id);
        $substitution->setStatus('Approved');
        $this->getDoctrine()->getManager()->persist($substitution);
        $this->getDoctrine()->getManager()->flush();
        $user = $substitution->getChecklist()->getUser();
        $emailer->sendEmail('substitution_approve', $user, $user->getEmail());
        return $this->redirectToRoute('user_show', ['id' => $user->getId()]);
    }

    /**
     * @Route("/{id}/substitution_deny", name="substitution_deny", methods={"GET"})
     */
    public function deny(String $id, Emailer $emailer): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $substitution = $this->getDoctrine()->getManager()->getRepository('App:Substitution')->find($id);
        $substitution->setStatus('Denied');
        $this->getDoctrine()->getManager()->persist($substitution);
        $this->getDoctrine()->getManager()->flush();
        $user = $substitution->getChecklist()->getUser();
        $emailer->sendEmail('substitution_deny', $user, $user->getEmail());
        return $this->redirectToRoute('user_show', ['id' => $user->getId()]);
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
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$substitution->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($substitution);
            $entityManager->flush();
        }

        return $this->redirectToRoute('substitution_index', [], Response::HTTP_SEE_OTHER);
    }
}
