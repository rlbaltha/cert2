<?php

namespace App\Controller;

use App\Entity\Application;
use App\Form\ApplicationType;
use App\Repository\ApplicationRepository;
use App\Service\Emailer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/application")
 */
class ApplicationController extends AbstractController
{
    /**
     * @Route("/", name="application_index", methods={"GET"})
     */
    public function index(ApplicationRepository $applicationRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $years = $this->getDoctrine()->getManager()->getRepository('App:Year')->findAllDesc();
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
        $years = $this->getDoctrine()->getManager()->getRepository('App:Year')->findAll();
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
        $user = $this->getDoctrine()->getManager()->getRepository('App:User')->findOneByUsername($username);
        $application = new Application();
        $application->setUser($user);
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $application->setUser($user);
            $entityManager = $this->getDoctrine()->getManager();
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
        $user = $this->getDoctrine()->getManager()->getRepository('App:User')->findOneByUsername($username);
        $user->setProgress('Checklist');
        $portfolio = 'https://ctlsites.uga.edu/sustainability-' . $user->getFirstName() . $user->getLastName();
        $user->setPortfolio(strtolower($portfolio));
        $application->setStatus('Approved');
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->persist($application);
        $this->getDoctrine()->getManager()->flush();

        $emailer->sendEmail('application_approve', $user, $user->getEmail());

        $emailer->sendEmail('create_portfolio', $user, 'christopher.pfeifer@uga.edu');

        $message = 'The application was approved, the student was sent an email, and an email was sent requesting the creation of a portfolio.';
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
            $this->getDoctrine()->getManager()->flush();

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
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($application);
            $entityManager->flush();
        }

        return $this->redirectToRoute('application_index');
    }
}
