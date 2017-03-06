<?php

namespace BlogBundle\Controller;

use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Post;

class BlogController extends Controller
{
    private $slugify;

    public function __construct()
    {
        $this->slugify = new Slugify();
    }

    public function blogAction()
    {
        $em    = $this->get('doctrine.orm.default_entity_manager');
        $posts = $em->getRepository('BlogBundle\Entity\Post')->findAll();

        return $this->render('BlogBundle:Blog:blog.html.twig', array(
            'posts' => $posts,
        ));
    }

    public function postAction($postSlug)
    {
        $em   = $this->get('doctrine.orm.default_entity_manager');
        $post = $em->getRepository('BlogBundle\Entity\Post')
            ->findOneBy(['slug' => $postSlug]);

        if (!$post) {
            throw $this->createNotFoundException(
                'No post found for this: ' . $postSlug
            );
        }

        return $this->render('BlogBundle:Blog:post.html.twig', array(
            'post' => $post
        ));
    }

    public function createPostAction(Request $request)
    {
        $post = new Post();

        $form = $this->createFormBuilder($post)
                ->add('title', TextType::class, array(
                'attr'  => array(
                    'class' => 'form-control'
                )
            ))
            ->add('description', TextareaType::class, array(
                'attr'  => array(
                    'class' => 'form-control'
                )
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Upload post!',
                'attr'  => array(
                    'class' => 'btn btn-success',
                    'style' => 'margin-top: 10px'
                )
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $post = $form->getData();
            $postTitle = $post->getTitle();

            // Add post slug
            $postSlug = $this->slugify->slugify($postTitle);
            $post->setSlug($postSlug);
            $post->setDatetime(date_create(date("Y-m-d H:i:s")));

            $em = $this->get('doctrine.orm.default_entity_manager');
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('blog_list');
        }

        return $this->render('BlogBundle:Blog:createPost.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
