<?php

namespace CMS\Controller;

use Framework\Controller\Controller;
use Framework\Exception\HttpNotFoundException;
use Blog\Model\Post;
use Framework\Validation\Validator;

/**
 * Class BlogController
 *
 * @package CMS\Controller
 * @author JuraZubach
 * @since 1.0
 */
class BlogController extends Controller
{
    /**
     * Edit post.
     *
     * @param $id
     * @return \Framework\Response\ResponseRedirect
     * @throws HttpNotFoundException
     * @throws \Framework\Exception\DatabaseException
     */
    public function editAction($id)
    {
        if ($this->getRequest()->isPost()) {
            try{
                $post = new Post();
                $date = new \DateTime();
                $post->id      = $tempPost->id;
                $post->title   = $this->getRequest()->post('title');
                $post->content = $this->getRequest()->post('content');
                $post->date    = $date->format('Y-m-d H:i:s');

                $validator = new Validator($post);
                if ($validator->isValid()) {
                    $post->edit($id);
                    return $this->redirect($this->generateRoute('home'), 'success', 'The post has been edit successfully');
                } else {
                    $error = $validator->getErrors();
                }
            } catch(DatabaseException $e){
                $error = $e->getMessage();
            }
        }

        $post = Post::find((int)$id);
        return $this->render('add.html',
            array('post' => $post, 'action' => '/posts/'. $id .'/edit', 'errors' => isset($error) ? $error : null));
    }

    /**
     * Delete from database.
     *
     * @param $id
     * @return \Framework\Response\ResponseRedirect
     * @throws HttpNotFoundException
     */
    public function deleteAction($id)
    {
        if ($post = Post::delete((int)$id)) {
            return $this->redirect($this->generateRoute('home'), 'success', 'The post has been delete successfully!');
        } else {
            throw new HttpNotFoundException('Page Not Found!');
        }
    }
}