<?php

namespace App\Controller;

use App\Entity\QCM;
use App\Form\QCMType;
use App\Repository\QCMRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/qcm")
 */
class QCMController extends AbstractController
{
    /**
     * @Route("/", name="q_c_m_index", methods={"GET"})
     */
    public function index(QCMRepository $qCMRepository): Response
    {
        return $this->render('qcm/index.html.twig', [
            'q_c_ms' => $qCMRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="q_c_m_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $qCM = new QCM();
        $form = $this->createForm(QCMType::class, $qCM);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($qCM);
            $entityManager->flush();

            return $this->redirectToRoute('q_c_m_index');
        }

        return $this->render('qcm/new.html.twig', [
            'q_c_m' => $qCM,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="q_c_m_show", methods={"GET"})
     */
    public function show(QCM $qCM): Response
    {
        return $this->render('qcm/show.html.twig', [
            'q_c_m' => $qCM,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="q_c_m_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, QCM $qCM): Response
    {
        $form = $this->createForm(QCMType::class, $qCM);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('q_c_m_index');
        }

        return $this->render('qcm/edit.html.twig', [
            'q_c_m' => $qCM,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="q_c_m_delete", methods={"POST"})
     */
    public function delete(Request $request, QCM $qCM): Response
    {
        if ($this->isCsrfTokenValid('delete'.$qCM->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($qCM);
            $entityManager->flush();
        }

        return $this->redirectToRoute('q_c_m_index');
    }

}
