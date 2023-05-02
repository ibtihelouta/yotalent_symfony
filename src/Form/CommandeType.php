<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Service\CartService;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Gregwar\CaptchaBundle\Validator\Constraints\Captcha;
use Symfony\Component\Validator\Constraints\NotBlank;






class CommandeType extends AbstractType
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('NomClient', TextType::class, [
            'mapped' => true, // associe le champ au champ NomClient de l'entité Commande
        ])
        ->add('PrenomClient', TextType::class, [
            'mapped' => true, // associe le champ au champ PrenomClient de l'entité Commande
        ])
        ->add('adresse')
        ->add('date_com', DateType::class)
        ->add('panier', HiddenType::class)
        ->add('prix_total', HiddenType::class, [
            'data' => $this->cartService->getPrixTotal(),
        ])
        ->add('captcha', CaptchaType::class, array(
            'constraints' => array(
                new NotBlank(array('message' => 'Veuillez saisir le code captcha.')),
            ),
        ))
    ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
