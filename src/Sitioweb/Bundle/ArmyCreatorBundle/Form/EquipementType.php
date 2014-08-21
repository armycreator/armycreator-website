<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed;

class EquipementType extends AbstractType
{
    /**
     * breed
     *
     * @var Breed
     * @access private
     */
    private $breed;

    /**
     * __construct
     *
     * @param Breed $breed
     * @access public
     */
    public function __construct(Breed $breed)
    {
        $this->breed = $breed;
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
        $builder->add('name', null, ['attr' => ['autofocus' => 'autofocus']]);
        $builder = $this->addDescription($builder);

        if ($options['data']->getId()) {
             $builder->add('edit', 'submit', ['attr' => ['class' => 'acButton acButtonBig']]);
        } else {
             $builder->add('create', 'submit', ['attr' => ['class' => 'acButton acButtonBig']])
                 ->add('createAndAdd', 'submit', ['attr' => ['class' => 'acButton acButtonBig']]);
        }
    }


    /**
     * setDefaultOptions
     *
     * @param OptionsResolverInterface $resolver
     * @access public
     * @return void
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sitioweb\Bundle\ArmyCreatorBundle\Entity\Equipement',
            'translation_domain' => 'forms'
        ));
    }

    /**
     * getName
     *
     * @access public
     * @return string
     */
    public function getName()
    {
        return 'armycreator_equipementtype';
    }

    /**
     * equipementTypeGuess
     *
     * @access private
     * @return FormBuilderInterface
     */
    private function addDescription(FormBuilderInterface $builder)
    {
        $builder->add('description', 'textarea', ['attr' => ['rows' => 5, 'cols' => 150], 'required' => false]);

        return $builder;
    }
}
