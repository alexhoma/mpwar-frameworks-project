<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Post;
use Cocur\Slugify\Slugify;
use BlogBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller
{
    private $slugify;

    public function __construct()
    {
        $this->slugify = new Slugify();
    }

    /**
     * Shows post list / home blog
     */
    public function blogAction()
    {
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $posts         = $entityManager->getRepository('BlogBundle\Entity\Post')->findAll();

        return $this->render('BlogBundle:Blog:blog.html.twig', array(
            'posts' => $posts,
        ));
    }

    /**
     * Shows post detail
     */
    public function postAction($postSlug)
    {
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $post          = $entityManager
            ->getRepository('BlogBundle\Entity\Post')
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

    /**
     * Create new post or show form
     */
    public function createPostAction(Request $request)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
//            $this->createFormBuilder($post)
//            ->add('title', TextType::class, array(
//                'attr' => array(
//                    'class' => 'form-control'
//                )
//            ))
//            ->add('description', TextareaType::class, array(
//                'attr' => array(
//                    'class' => 'form-control'
//                )
//            ))
//            ->add('save', SubmitType::class, array(
//                'label' => 'Upload post!',
//                'attr' => array(
//                    'class' => 'btn btn-success',
//                    'style' => 'margin-top: 10px'
//                )
//            ))
//            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $post      = $form->getData();
            $postTitle = $post->getTitle();

            // Add post slug
            $postSlug = $this->slugify->slugify($postTitle);
            $post->setSlug($postSlug);
            $post->setDatetime(date_create(date("Y-m-d H:i:s")));

            $entityManager = $this->get('doctrine.orm.default_entity_manager');
            $entityManager->persist($post);
            $entityManager->flush();

            $request
                ->getSession()
                ->getFlashBag()
                ->add('success', 'Post created successfully!');

            return $this->redirectToRoute('blog_list');
        }

        return $this->render('BlogBundle:Blog:createPost.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
