<?php

namespace App\Controller;

use App\Entity\Checklist;
use App\Entity\Substitution;
use App\Form\SubstitutionType;
use App\Repository\SubstitutionRepository;
use App\Service\Emailer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/substitution")
 */
class SubstitutionController extends AbstractController
{
    /** @var ManagerRegistry */
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
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
        $checklist = $this->doctrine->getManager()->getRepository(Checklist::class)->find($checklist_id);
        $substitution = new Substitution();
        $substitution->setChecklist($checklist);
        $form = $this->createForm(SubstitutionType::class, $substitution);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->doctrine->getManager();
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
        $substitution = $this->doctrine->getManager()->getRepository(Substitution::class)->find($id);
        $substitution->setStatus('Approved');
        $this->doctrine->getManager()->persist($substitution);
        $this->doctrine->getManager()->flush();
        $user = $substitution->getChecklist()->getUser();
//        $emailer->sendEmail('substitution_approve', $user, $user->getEmail());

        $message = 'The substitution was marked approved and the student sent an email.';
        $this->addFlash('notice', $message);

        return $this->redirectToRoute('user_show', ['id' => $user->getId()]);
    }

    /**
     * @Route("/{id}/substitution_deny", name="substitution_deny", methods={"GET"})
     */
    public function deny(String $id, Emailer $emailer): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $substitution = $this->doctrine->getManager()->getRepository(Substitution::class)->find($id);
        $substitution->setStatus('Denied');
        $this->doctrine->getManager()->persist($substitution);
        $this->doctrine->getManager()->flush();
        $user = $substitution->getChecklist()->getUser();
        $emailer->sendEmail('substitution_deny', $user, $user->getEmail());

        $message = 'The substitution was denied and the student sent an email.';
        $this->addFlash('notice', $message);

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
            $this->doctrine->getManager()->flush();

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
            $entityManager = $this->doctrine->getManager();
            $entityManager->remove($substitution);
            $entityManager->flush();
        }

        return $this->redirectToRoute('substitution_index', [], Response::HTTP_SEE_OTHER);
    }
}
