<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Post;

class BlogController extends Controller
{
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
            ->add('slug', TextType::class)
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Upload post!'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $post = $form->getData();

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
