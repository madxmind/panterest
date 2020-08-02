<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Form\PinType;
use App\Repository\PinRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PinController extends AbstractController
{
    /**
     * @Route("/", name="app_home", methods={"GET"})
     * @param  PinRepository $pinRepository
     * @return Response
     */
    public function index(PinRepository $pinRepository): Response
    {
        return $this->render('pin/index.html.twig', [
            'pins' => $pinRepository->findBy([], ['createdAt' => 'DESC']),
        ]);
    }

    /**
     * @Route("/pin/create", name="app_pin_create", methods={"GET", "POST"})
     * @param  Request $request
     * @return Response
     */
    public function create(Request $request, UserRepository $userRepository): Response
    {
        $pin = new Pin;
        $form = $this->createForm(PinType::class, $pin)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pin->setUser($userRepository->findOneBy([]));
            $this->getDoctrine()->getManager()->persist($pin);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Pin successfully created!');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('pin/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/pin/{id<[0-9]+>}", name="app_pin_show", methods={"GET"})
     * @param  Pin $pin
     * @return Response
     */
    public function show(Pin $pin): Response
    {
        return $this->render('pin/show.html.twig', [
            'pin' => $pin,
        ]);
    }

    /**
     * @Route("/pin/{id<[0-9]+>}/update", name="app_pin_update", methods={"GET", "PUT"})
     * @param  Pin $pin
     * @param  Request $request
     * @return Response
     */
    public function update(Pin $pin, Request $request, UserRepository $userRepository): Response
    {
        $form = $this->createForm(PinType::class, $pin, ['method' => 'PUT'])->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pin->setUser($userRepository->findOneBy([]));
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Pin successfully updated!');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('pin/update.html.twig', [
            'pin' => $pin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/pin/{id<[0-9]+>}", name="app_pin_delete", methods={"DELETE"})
     * @param  Pin $pin
     * @return Response
     */
    public function delete(Pin $pin, Request $request): Response
    {
        if ($this->isCsrfTokenValid('pin_deletion_' . $pin->getId(), $request->request->get('csrf_token'))) {
            $this->getDoctrine()->getManager()->remove($pin);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('info', 'Pin successfully deleted!');
        }

        return $this->redirectToRoute('app_home');
    }
}
