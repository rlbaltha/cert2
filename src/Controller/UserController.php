<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Year;
use App\Form\ProfileType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\Emailer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /** @var ManagerRegistry */
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $years = $this->doctrine->getManager()->getRepository(Year::class)->findAllDesc();
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'years' => $years
        ]);
    }

    /**
     * @Route("/{progress}/find", name="user_find", methods={"GET"})
     */
    public function find(UserRepository $userRepository, string $progress): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $years = $this->doctrine->getManager()->getRepository(Year::class)->findAllDesc();
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findBy(['progress' => $progress], ['gradyear' => 'DESC']),
            'years' => $years
        ]);
    }

    /**
     * @Route("/{term}/{year}/findByDate", name="user_findbydate", methods={"GET"})
     */
    public function findByDate(UserRepository $userRepository, string $year, string $term): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $years = $this->doctrine->getManager()->getRepository(Year::class)->findAllDesc();
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findByDate($year, $term),
            'years' => $years
        ]);
    }

    /**
     * @Route("/{level}//findByLevel", name="user_findbylevel", methods={"GET"})
     */
    public function findByLevel(UserRepository $userRepository, string $level): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $years = $this->doctrine->getManager()->getRepository(Year::class)->findAllDesc();
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findByLevel($level),
            'years' => $years
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profile", name="profile", methods={"GET"})
     */
    public function profile(): Response
    {
        $username = $this->getUser()->getUsername();
        $user = $this->doctrine->getManager()->getRepository(User::class)->findOneByUsername($username);

        if ($user->getLastName() == null) {
            return $this->redirectToRoute('user_profile_edit', ['id' => $user->getId()]);
        }
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/inactive", name="user_inactive", methods={"GET"})
     */
    public function inactive(User $user, Emailer $emailer): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $user->setProgress('Inactive');
        $this->doctrine->getManager()->persist($user);
        $this->doctrine->getManager()->flush();

//        $emailer->sendEmail('inactive', $user, $user->getEmail());

        $message = 'The student was marked Inactive and sent an email.';
        $this->addFlash('notice', $message);

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/alumni", name="user_alumni", methods={"GET"})
     */
    public function alumni(User $user, Emailer $emailer): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $user->setProgress('Alumni');
        $this->doctrine->getManager()->persist($user);
        $this->doctrine->getManager()->flush();

//        $emailer->sendEmail('alumni', $user, $user->getEmail());

        $message = 'The student was marked Alumni and sent an email.';
        $this->addFlash('notice', $message);

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/graduating", name="user_graduating", methods={"GET"})
     */
    public function graduating(User $user, MailerInterface $mailer): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $user->setProgress('Graduating');
        $this->doctrine->getManager()->persist($user);
        $this->doctrine->getManager()->flush();

        $message = 'The student was listed as graduating.';
        $this->addFlash('notice', $message);

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/show", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->doctrine->getManager()->flush();
            return $this->redirectToRoute('profile');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit_profile", name="user_profile_edit", methods={"GET","POST"})
     */
    public function edit_profile(Request $request, User $user, Emailer $emailer): Response
    {
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->doctrine->getManager()->flush();
            $username = $user->getUsername();
            $user = $this->doctrine->getManager()->getRepository(User::class)->findOneByUsername($username);

//            $emailer->sendEmail('edit_profile', $user, $user->getEmail());

            return $this->redirectToRoute('profile');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->doctrine->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
