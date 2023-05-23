<?php

declare(strict_types=1);


namespace App\Controller\Setting;


use App\Form\SettingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\LocaleSwitcher;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;


final class SettingController extends AbstractController
{
    private TranslatorInterface $t;
    private LocaleSwitcher $localeSwitcher;

    public function __construct(TranslatorInterface $t, LocaleSwitcher $localeSwitcher)
    {
        $this->t = $t;
        $this->localeSwitcher = $localeSwitcher;
    }

    public function index(Request $request): Response
    {
        $form = $this->createForm(SettingType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $langage = $form->get('language')->getData();
            if ($request->getLocale() !== $langage) {
                $this->localeSwitcher->setLocale($langage);
            }
        }

//        dd($request->getLocale());

        return $this->render('Pages/Setting/setting.html.twig', [
            'breadcrumbs' => [
                ['data' => ['name' => $this->t->trans('settings', domain: 'general')]],
            ],
            'setting_form' => $form,
        ]);
    }

}
