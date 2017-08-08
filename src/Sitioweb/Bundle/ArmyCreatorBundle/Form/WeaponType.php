<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\Type\FArm\EquipementDescriptionType as FArmEquipementDescriptionType;
use Sitioweb\Bundle\ArmyCreatorBundle\Form\Type\Warhammer\WeaponDescriptionType as WarhammerWeaponDescriptionType;

class WeaponType extends AbstractType
{
    /**
     * game
     *
     * @var Game
     * @access private
     */
    private $game;

    /**
     * __construct
     *
     * @param Game $game
     * @access public
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    /**
     * buildForm
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @access public
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, ['attr' => ['autofocus' => 'autofocus']])
            ->add('defaultPoints')
            ->add('defaultAuto', null, ['required' => false]);

        $builder = $this->addGameSpecifics($builder);

        if ($options['data']->getId()) {
             $builder->add('edit', SubmitType::class, ['attr' => ['class' => 'acButton acButtonBig']]);
        } else {
             $builder->add('create', SubmitType::class, ['attr' => ['class' => 'acButton acButtonBig']])
                 ->add('createAndAdd', SubmitType::class, ['attr' => ['class' => 'acButton acButtonBig']]);
        }
    }

    /**
     * setDefaultOptions
     *
     * @param OptionsResolverInterface $resolver
     * @access public
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\Weapon',
            'translation_domain' => 'forms'
        ));
    }

    /**
     * getName
     *
     * @access public
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'armycreator_weapontype';
    }

    /**
     * addGameSpecifics
     *
     * @access private
     * @return FormBuilderInterface
     */
    private function addGameSpecifics(FormBuilderInterface $builder)
    {
        switch ($this->game->getCode()) {
            case 'FArm':
                $builder->add('description', new FArmEquipementDescriptionType);
                break;
            default:
                $builder->add('description', new WarhammerWeaponDescriptionType);
                break;
        }


        return $builder;
    }
}
