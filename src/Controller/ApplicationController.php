<?php

namespace App\Controller;

use App\Entity\Application;
use App\Form\ApplicationType;
use App\Repository\ApplicationRepository;
use App\Service\Emailer;
use App\Entity\User;
use App\Entity\Year;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/application")
 */
class ApplicationController extends AbstractController
{
    /** @var ManagerRegistry */
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
    /**
     * @Route("/", name="application_index", methods={"GET"})
     */
    public function index(ApplicationRepository $applicationRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $years = $this->doctrine->getManager()->getRepository(Year::class)->findAllDesc();
        return $this->render('application/index.html.twig', [
            'applications' => $applicationRepository->findAll(),
            'status' => 'All',
            'years' => $years
        ]);
    }


    /**
     * @Route("/{status}/find", name="application_find", methods={"GET"})
     */
    public function find(ApplicationRepository $applicationRepository, string $status): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $years = $this->doctrine->getManager()->getRepository(Year::class)->findAll();
        if ($status == 'All') {
            return $this->render('application/index.html.twig', [
                'applications' => $applicationRepository->findAll(),
                'status' => 'All',
                'years' => $years
            ]);
        }
        else {
            return $this->render('application/index.html.twig', [
                'applications' => $applicationRepository->findByStatus($status),
                'status' => $status,
                'years' => $years
            ]);
        }

    }

    /**
     * @Route("/new", name="application_new", methods={"GET","POST"})
     */
    public function new(Request $request, Emailer $emailer): Response
    {
        $username = $this->getUser()->getUsername();
        $user = $this->doctrine->getManager()->getRepository(User::class)->findOneByUsername($username);
        $application = new Application();
        $application->setUser($user);
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $application->setUser($user);
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($application);
            $entityManager->flush();

            $emailer->sendEmail('application', $user, 'scdirector@uga.edu');

            return $this->redirectToRoute('user_show', ['id' => $application->getUser()->getId()]);
        }

        return $this->render('application/new.html.twig', [
            'application' => $application,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/application_approve", name="application_approve", methods={"GET"})
     */
    public function approve(Application $application, Emailer $emailer): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $username = $application->getUser()->getUsername();
        $user = $this->doctrine->getManager()->getRepository(User::class)->findOneByUsername($username);
        $user->setProgress('Checklist');
        $portfolio = 'https://ctlsites.uga.edu/sustainability-' . $user->getFirstName() . $user->getLastName();
        $user->setPortfolio(strtolower($portfolio));
        $application->setStatus('Approved');
        $this->doctrine->getManager()->persist($user);
        $this->doctrine->getManager()->persist($application);
        $this->doctrine->getManager()->flush();

        $emailer->sendEmail('application_approve', $user, $user->getEmail());

//        $emailer->sendEmail('create_portfolio', $user, 'christopher.pfeifer@uga.edu');

        $message = 'The application was approved and the student was sent an email';
        $this->addFlash('notice', $message);

        return $this->redirectToRoute('user_show', ['id' => $application->getUser()->getId()]);
    }

    /**
     * @Route("/{id}/edit", name="application_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Application $application, Emailer $emailer): Response
    {
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);
        $user = $application->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $this->doctrine->getManager()->flush();

            $emailer->sendEmail('application', $user, 'scdirector@uga.edu');
            return $this->redirectToRoute('user_show', ['id' => $application->getUser()->getId()]);
        }

        return $this->render('application/edit.html.twig', [
            'application' => $application,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="application_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Application $application): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$application->getId(), $request->request->get('_token'))) {
            $entityManager = $this->doctrine->getManager();
            $entityManager->remove($application);
            $entityManager->flush();
        }

        return $this->redirectToRoute('application_index');
    }
}
