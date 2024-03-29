<?php

namespace App\Controller;

use App\Entity\Checklist;
use App\Entity\User;
use App\Form\ChecklistType;
use App\Repository\ChecklistRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


/**
 * @Route("/checklist")
 */
class ChecklistController extends AbstractController
{
    /** @var ManagerRegistry */
    private ManagerRegistry $doctrine;

    private $security;

    public function __construct(ManagerRegistry $doctrine, Security $security)
    {
        $this->doctrine = $doctrine;
        $this->security = $security;
    }


    /**
     * @Route("/", name="checklist_index", methods={"GET"})
     */
    public function index(ChecklistRepository $checklistRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('checklist/index.html.twig', [
            'checklists' => $checklistRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="checklist_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $username = $this->getUser()->getUsername();
        $user = $this->doctrine->getManager()->getRepository(User::class)->findOneByUsername($username);

        $checklist = new Checklist();
        $checklist->setUser($user);
        $form = $this->createForm(ChecklistType::class, $checklist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $checklist->setUser($user);
            $user->setProgress('Checklist');
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($checklist);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_show', ['id' => $checklist->getUser()->getId()]);
        }

        return $this->render('checklist/new.html.twig', [
            'checklist' => $checklist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="checklist_show", methods={"GET"})
     */
    public function show(Checklist $checklist): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('checklist/show.html.twig', [
            'checklist' => $checklist,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="checklist_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Checklist $checklist): Response
    {
        $form = $this->createForm(ChecklistType::class, $checklist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->doctrine->getManager()->flush();

            if ($this->security->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('user_show', ['id' => $checklist->getUser()->getId()]);
            }
            else {
                return $this->redirectToRoute('profile');
            }

        }

        return $this->render('checklist/edit.html.twig', [
            'checklist' => $checklist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="checklist_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Checklist $checklist): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$checklist->getId(), $request->request->get('_token'))) {
            $entityManager = $this->doctrine->getManager();
            $entityManager->remove($checklist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('checklist_index');
    }
}
