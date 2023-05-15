<?php
declare(strict_types=1);


namespace App\Events;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\CanDo;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class PermissionActionEvent implements EventSubscriberInterface
{
    private UrlGeneratorInterface $urlGenerator;
    private TokenStorageInterface $tokenStorage;
    private RequestStack  $requestStack;

    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        TokenStorageInterface $tokenStorage,
        RequestStack  $requestStack
    ) {
        $this->urlGenerator = $urlGenerator;
        $this->tokenStorage = $tokenStorage;
        $this->requestStack = $requestStack;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => [
                ['onControllerExecute', 1],
            ],
        ];
    }

    /*
     * Check attribute isGranted with special argument to redirect
     * on given route with flash message and not retrun in 401 forbiden exeption
     */
    public function OnControllerExecute(ControllerEvent $event)
    {
        if (!$event->isMainRequest()) {
            return;
        }
        $attributes = $event->getControllerReflector()->getAttributes();

        if (!$attributes) {
            return;
        }
        foreach ($attributes as $attribute) {

            if ($attribute->getName() !== CanDo::class) {
                continue;
            }

            if (!$attribute->getArguments()) {
                continue;
            }

            $argument = $attribute->getArguments();

            if (!is_array($argument[0])) {
                continue;
            }

            $resultRoleCheck =  array_intersect($this->tokenStorage->getToken()->getUser()->getRoles(),$argument[0]);
            if(!empty($resultRoleCheck))
            {
                return ;
            }
            $routeName = $argument[1] ?? 'dashboard';
            $flashMessage = $argument[2] ?? 'you do not have permission to execute this action';

            $redirectUrl = $this->urlGenerator->generate($routeName);
            $this->requestStack->getSession()->getFlashBag()->add('danger', $flashMessage);
            $event->setController(fn() => new RedirectResponse($redirectUrl));
            $event->stopPropagation();
        }
    }
}
