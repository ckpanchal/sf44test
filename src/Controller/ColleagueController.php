<?php

namespace App\Controller;

use App\Entity\Colleague;
use App\Form\ColleagueType;
use App\Repository\ColleagueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * @Route("/colleague")
 */
class ColleagueController extends AbstractController
{
    /**
     * @Route("/", name="colleague_index", methods={"GET"})
     */
    public function index(ColleagueRepository $colleagueRepository): Response
    {
        return $this->render('colleague/index.html.twig', [
            'colleagues' => $colleagueRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="colleague_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $colleague = new Colleague();
        $form = $this->createForm(ColleagueType::class, $colleague);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($colleague);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Data successfully created.'
            );

            return $this->redirectToRoute('colleague_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('colleague/new.html.twig', [
            'colleague' => $colleague,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="colleague_show", methods={"GET"})
     */
    public function show(Colleague $colleague): Response
    {
        return $this->render('colleague/show.html.twig', [
            'colleague' => $colleague,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="colleague_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Colleague $colleague, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ColleagueType::class, $colleague);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($colleague);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Data successfully updated.'
            );

            return $this->redirectToRoute('colleague_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('colleague/edit.html.twig', [
            'colleague' => $colleague,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="colleague_delete", methods={"POST"})
     */
    public function delete(Request $request, Colleague $colleague, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$colleague->getId(), $request->request->get('_token'))) {
            $entityManager->remove($colleague);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Data successfully deleted.'
            );
        }

        return $this->redirectToRoute('colleague_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/greeting-email/{id}", name="colleague_greeting_email", methods={"GET"})
     */
    public function sendEmail(MailerInterface $mailer, Colleague $colleague): Response
    {
        $email = (new TemplatedEmail())
                        ->from('admin@example.com')
                        ->to(new Address($colleague->getEmail()))
                        ->subject('Welcome To Symfony 4.4 Test!')
                        ->htmlTemplate('emails/welcome.html.twig')
                        ->context([
                            'expiration_date' => new \DateTime('+7 days'),
                            'colleague' => $colleague,
                        ]);

        $mailer->send($email);

        $this->addFlash(
            'success',
            'Mail successfully sent.'
        );

        return $this->redirectToRoute('colleague_index', [], Response::HTTP_SEE_OTHER);
    }
}
