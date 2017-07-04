<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

class DefaultController extends Controller
{
    /**
     * @Route("/form")
     * @param Request $request
     * @return Response
     */
    public function formAction(Request $request)
    {
        $form = $this->createForm(UserType::class, null, [
            'method' => $request->getMethod(),
        ]);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return new Response(json_encode($this->getFormErrors($form)), 400);
        }

        return new Response('Success');
    }

    /**
     * @param FormInterface $form
     * @return array
     */
    private function getFormErrors(FormInterface $form)
    {
        $errors = [];
        foreach ($form as $name => $child) {
            /** @var FormInterface $child */
            if ($child->isValid()) {
                continue;
            }
            foreach ($child->getErrors() as $error) {
                $propertyPath = '';
                $cause = $error->getCause();
                if ($cause instanceof ConstraintViolation) {
                    $propertyPath = $cause->getPropertyPath();
                    $propertyPath = preg_replace('/^children\[([a-zA-z]*)\]\.data/', "$1", $propertyPath);
                    $propertyPath = preg_replace('/^data\[([^]]+)\](.*)?$/', "$1$2", $propertyPath);
                    $propertyPath = preg_replace('/^data\./', '', $propertyPath);
                }
                $errors[$propertyPath] = $error->getMessage();
            }
        }

        return $errors;
    }

    /**
     * @Route("/yaml")
     * @param Request $request
     * @return Response
     */
    public function yamlAction(Request $request)
    {
        $user = new User();

        if ($request->get('name')) {
            $user->name = $request->get('name');
        }

        if ($request->get('age')) {
            $user->age = $request->get('age');
        }

        $errors = $this->get('validator')->validate($user);

        if (count($errors) > 0) {
            return new Response(json_encode($this->getYamlErrors($errors)), 400);
        }

        return new Response('Success');
    }

    /**
     * @param ConstraintViolationList $errorList
     * @return array
     */
    private function getYamlErrors(ConstraintViolationList $errorList)
    {
        $errors = [];
        foreach ($errorList as $error) {
            $errors[$error->getPropertyPath()] = $error->getMessage();
        }

        return $errors;
    }
}
