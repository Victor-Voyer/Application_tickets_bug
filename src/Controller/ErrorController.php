<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\HttpKernel\Exception\TimeoutException;
use Twig\Environment;

class ErrorController extends AbstractController
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function show(\Throwable $exception): Response
    {
        $statusCode = 500;
        $template = 'error/500.html.twig';

        if ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
            
            switch ($statusCode) {
                case 404:
                    $template = 'error/404.html.twig';
                    break;
                case 403:
                    $template = 'error/403.html.twig';
                    break;
                case 400:
                    $template = 'error/400.html.twig';
                    break;
                case 503:
                    $template = 'error/503.html.twig';
                    break;
                case 408:
                    $template = 'error/408.html.twig';
                    break;
                default:
                    $template = 'error/500.html.twig';
                    break;
            }
        }

        return new Response(
            $this->twig->render($template),
            $statusCode
        );
    }
    #[Route('/error/404', name: 'app_error_404')]
    public function error404(): Response
    {
        return $this->render('error/404.html.twig');
    }

    #[Route('/error/500', name: 'app_error_500')]
    public function error500(): Response
    {
        return $this->render('error/500.html.twig');
    }

    #[Route('/error/403', name: 'app_error_403')]
    public function error403(): Response
    {
        return $this->render('error/403.html.twig');
    }

    #[Route('/error/400', name: 'app_error_400')]
    public function error400(): Response
    {
        return $this->render('error/400.html.twig');
    }

    #[Route('/error/503', name: 'app_error_503')]
    public function error503(): Response
    {
        return $this->render('error/503.html.twig');
    }

    #[Route('/error/408', name: 'app_error_408')]
    public function error408(): Response
    {
        return $this->render('error/408.html.twig');
    }

    #[Route('/error/test', name: 'app_error_test')]
    public function errorTest(): Response
    {
        return $this->render('error/test.html.twig');
    }
}
