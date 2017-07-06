<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function indexAction()
    {
        return new Response('Success');
    }

    /**
     * @Route("/category/")
     * @Method({"POST"})
     * @param Request $request
     * @return Response
     */
    public function categoryAction(Request $request)
    {
        $category = new Category();

        if ($request->get('name')) {
            $category->name = $request->get('name');
        }

        $errors = $this->get('validator')->validate($category);

        if (count($errors)) {
            return new Response($this->getErrors($errors), 400);
        }

        return new Response('Success');
    }

    /**
     * @Route("/user/")
     * @Method({"POST"})
     * @param Request $request
     * @return Response
     */
    public function userAction(Request $request)
    {
        $form = $this->get('form.factory')->createNamed('', UserType::class, null, [
            'method' => $request->getMethod(),
        ]);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return new Response($this->getFormErrors($form), 400);
        }

        return new Response('Success');
    }

    /**
     * @param ConstraintViolationList $errorList
     * @return string
     */
    protected function getErrors(ConstraintViolationList $errorList)
    {
        $errors = [];

        foreach ($errorList as $error) {
            $errors[$error->getPropertyPath()][] = $error->getMessage();
        }

        foreach ($errors as $key => $error) {
            $errors[$key] = implode(' ', $error);
        }

        return implode(PHP_EOL, $errors);
    }

    /**
     * @param FormInterface $form
     * @return string
     */
    protected function getFormErrors(FormInterface $form)
    {
        $errors = [];

        foreach ($form->getErrors(true) as $key => $error) {
            $errors[$error->getOrigin()->getName()][] = $error->getMessage();
        }

        foreach ($errors as $key => $error) {
            $errors[$key] = implode(' ', $error);
        }

        return implode(PHP_EOL, $errors);
    }
}
