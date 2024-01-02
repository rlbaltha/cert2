<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/course")
 */
class CourseController extends AbstractController
{
    /** @var ManagerRegistry */
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    /**
     * @Route("/", name="course_index", methods={"GET"})
     */
    public function index(CourseRepository $courseRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_INTERN');
        return $this->render('course/index.html.twig', [
            'courses' => $courseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/list/{level}/{sphere}", name="course_find", methods={"GET"})
     */
    public function findByType(CourseRepository $courseRepository, string $level, string $sphere): Response
    {
        $sphere = ucwords($sphere);
        $level = ucwords($level);
        return $this->render('course/index.html.twig', [
            'courses' => $courseRepository->findByType($sphere, $level),
        ]);
    }

    /**
     * @Route("/new", name="course_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_INTERN');
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($course);
            $entityManager->flush();

            return $this->redirectToRoute('course_index');
        }

        return $this->render('course/new.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="course_show", methods={"GET"})
     */
    public function show(Course $course): Response
    {
        $this->denyAccessUnlessGranted('ROLE_INTERN');
        return $this->render('course/show.html.twig', [
            'course' => $course,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="course_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Course $course): Response
    {
        $this->denyAccessUnlessGranted('ROLE_INTERN');
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->doctrine->getManager()->flush();

            return $this->redirectToRoute('course_index');
        }

        return $this->render('course/edit.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="course_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Course $course): Response
    {
        $this->denyAccessUnlessGranted('ROLE_INTERN');
        if ($this->isCsrfTokenValid('delete'.$course->getId(), $request->request->get('_token'))) {
            $entityManager = $this->doctrine->getManager();
            $entityManager->remove($course);
            $entityManager->flush();
        }

        return $this->redirectToRoute('course_index');
    }
}
