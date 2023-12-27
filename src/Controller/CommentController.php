<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Comment;

#[Route('/comment', name: 'app_comment_')]
class CommentController extends AbstractController
{
    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function index(Comment $comment, Request $request, EntityManagerInterface $entityManager): Response
    {

        if(($this->getUser() === $comment->getAuthor() || $this->isGranted('ROLE_ADMIN'))
            && $this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))){
            $entityManager->remove($comment);
            $entityManager->flush();
            $this->addFlash('danger', 'Comment has been removed');
        }
        return $this->redirectToRoute('program_episode_show', [
            'programSlug' => $comment->getEpisode()->getSeason()->getProgram()->getSlug(),
            'seasonId' => $comment->getEpisode()->getSeason()->getId(),
            'episodeSlug' => $comment->getEpisode()->getSlug()
        ], Response::HTTP_SEE_OTHER);
    }
}
