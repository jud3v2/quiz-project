<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Question;
use App\Entity\Reponse;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'data' => $this->getDoctrine()
                ->getManager()
                ->getRepository(Categorie::class)
                ->findAll(),
        ]);
    }

    #[Route(path: 'quiz/{id}', name: 'get_quizz', methods: ['GET'])]
    public function get_categorie(Categorie $categorie): Response
    {
        $questions = $this->order_question(
            $this->getDoctrine()
                ->getRepository(Question::class)
                ->findBy(['idCategorie' => $categorie->getId()])
        );
        return $this->render('home/quiz.html.twig', [
            'number_of_question' => $categorie->getId(),
            'quiz_name' => $categorie->getName(),
            'data' => $categorie,
            'questions' => $questions,
            'responses' => $this->get_response($questions),
            'start' => array_key_first($questions),
            'end' => array_key_last($questions),
            'link_url' => $this->generateUrl('get_quiz_and_question_number', [
                'categorie' => $categorie->getId(),
                'question' => array_key_first($questions),
                'next' => array_key_first($questions),
                'end' => array_key_last($questions),
            ])
        ]);
    }

    #[Route(path: 'quiz/{categorie}/{question}/{next}/{end}', name: 'get_quiz_and_question_number', methods: ['GET', 'POST'])]
    public function get_categorie_question(Categorie $categorie, Question $question, $next, $end): Response
    {
        //TODO: Ajouter chaque question et reponse dans une session
        return $this->render('home/quiz.html.twig', [
            'data' => $categorie,
            'number_of_question' => $categorie->getId(),
            'quiz_name' => $categorie->getName(),
            'questions' => $question,
            'responses' => $this->getDoctrine()
                ->getRepository(Reponse::class)
                ->findBy(['idQuestion' => $question->getId()]),
            'next' => $next,
            'end' => $end
        ]);
    }

    /**
     * @param array $questions
     * @return array array of question
     */
    private function get_response(array $questions): array
    {
        $response = [];
        foreach ($questions as $question) {
            $response[$question->getId()] = $this->getDoctrine()
                ->getRepository(Reponse::class)
                ->findBy(['idQuestion' => $question->getId()]);
        }

        return $response;
    }

    /**
     * @param array $questions
     * @return array
     */
    private function order_question(array $questions): array
    {
        $data = [];
        for ($i = 0; $i < count($questions); $i++) {
            $data[$questions[$i]->getId()] = $questions[$i];
        }

        return $data;
    }
}
