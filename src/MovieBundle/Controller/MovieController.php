<?php

namespace MovieBundle\Controller;

use MovieBundle\Entity\Movie;
use MovieBundle\Event\MovieCreatedEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class MovieController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
//        $entityManager = $this->get('doctrine.orm.default_entity_manager');
//        $movie         = new Movie('Titanic');
//        $entityManager->persist($movie);
//        $entityManager->flush();

        return $this->render('MovieBundle:Default:index.html.twig', [
            'say_hello' => 'hello world',
        ]);
    }

    /**
     * @Route("/movie/{id}", name="showMovie")
     */
    public function showMovieAction($id)
    {
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $repository    = $entityManager->getRepository('MovieBundle\Entity\Movie');
        $movie         = $repository->find($id);

        return $this->render('MovieBundle:Default:movie.html.twig', [
            'movie' => $movie->getName()
        ]);
    }

    /**
     * @Route("/movie", name="createMovie")
     */
    public function createMovieAction(Request $request)
    {
        $movie = new Movie();

        $form = $this->createFormBuilder($movie)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Save movie'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $movie = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();

            // Lanzamos evento
            $movieCreatedEvent = new MovieCreatedEvent($movie);
            $event = $this->get('event_dispatcher');
            $event->dispatch('movie.created', $movieCreatedEvent);

            return $this->redirectToRoute('listMovies');
        }

        return $this->render('MovieBundle:Default:createMovie.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/movies", name="listMovies")
     */
    public function listMoviesAction()
    {
        $movies = $this->getDoctrine()
            ->getRepository('MovieBundle\Entity\Movie')
            ->findAll();

        return $this->render('MovieBundle:Default:listMovies.html.twig', array(
            'movies' => $movies,
        ));
    }
}
