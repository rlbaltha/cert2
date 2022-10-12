<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Checklist;

class DataController extends AbstractController
{
    /**
     * @Route("/data", name="data")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_INTERN');
        $countByMajor = $this->getDoctrine()->getManager()->getRepository(User::class)->countByMajor();
        $countBySchool = $this->getDoctrine()->getManager()->getRepository(User::class)->countBySchool();
        $countByProgress = $this->getDoctrine()->getManager()->getRepository(User::class)->countByProgress();
        $countByGrad = $this->getDoctrine()->getManager()->getRepository(User::class)->countByGrad();

        $countByAnchor = $this->getDoctrine()->getManager()->getRepository(Checklist::class)->countByAnchor();
        $countBySphere1 = $this->getDoctrine()->getManager()->getRepository(Checklist::class)->countBySphere1();
        $countBySphere2 = $this->getDoctrine()->getManager()->getRepository(Checklist::class)->countBySphere2();
        $countBySphere3 = $this->getDoctrine()->getManager()->getRepository(Checklist::class)->countBySphere3();
        $countBySeminar = $this->getDoctrine()->getManager()->getRepository(Checklist::class)->countBySeminar();


        return $this->render('data/index.html.twig', [
            'countByMajor' => $countByMajor,
            'countBySchool' => $countBySchool,
            'countByProgress' => $countByProgress,
            'countByGrad' => $countByGrad,
            'countByAnchor' => $countByAnchor,
            'countBySphere1' => $countBySphere1,
            'countBySphere2' => $countBySphere2,
            'countBySphere3' => $countBySphere3,
            'countBySeminar' => $countBySeminar,
        ]);
    }
}
