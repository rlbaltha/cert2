<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataController extends AbstractController
{
    /**
     * @Route("/data", name="data")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_INTERN');
        $countByMajor = $this->getDoctrine()->getManager()->getRepository('App:User')->countByMajor();
        $countBySchool = $this->getDoctrine()->getManager()->getRepository('App:User')->countBySchool();
        $countByProgress = $this->getDoctrine()->getManager()->getRepository('App:User')->countByProgress();
        $countByGrad = $this->getDoctrine()->getManager()->getRepository('App:User')->countByGrad();

        $countByAnchor = $this->getDoctrine()->getManager()->getRepository('App:Checklist')->countByAnchor();
        $countBySphere1 = $this->getDoctrine()->getManager()->getRepository('App:Checklist')->countBySphere1();
        $countBySphere2 = $this->getDoctrine()->getManager()->getRepository('App:Checklist')->countBySphere2();
        $countBySphere3 = $this->getDoctrine()->getManager()->getRepository('App:Checklist')->countBySphere3();
        $countBySeminar = $this->getDoctrine()->getManager()->getRepository('App:Checklist')->countBySeminar();


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
