<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use AppBundle\Entity\Category;
use AppBundle\Entity\User;

class RecipeType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', HiddenType::class)
                ->add('title')
                ->add('ingredients')
                ->add('directions')
//                ->add('image')
                ->add('imageFile', FileType::class)
//                ->add('image', VichImageType::class, [
//                    'required' => false,
//                    'allow_delete' => true,
//                    'download_label' => '...',
//                    'download_uri' => true,
//                    'image_uri' => true,
//                    'imagine_pattern' => '...',
//                ])
                ->add('rate')
                ->add('isPublic')
                ->add('createdAt')
                ->add('updatedAt')
                ->add('user', EntityType::class, array(
                    'class' => User::class,
                    'query_builder' => function(EntityRepository $repository) {
                        $queryBuilder = $repository->createQueryBuilder('u');
                        return $queryBuilder;
                    },
                    'choice_label' => 'nickname',
                    'placeholder' => '--Choice--',
                ))
                ->add('category', EntityType::class, array(
                    'class' => Category::class,
                    'query_builder' => function(EntityRepository $repository) {
                        $queryBuilder = $repository->createQueryBuilder('c');
                        return $queryBuilder;
                    },
                    'choice_label' => 'name',
                    'placeholder' => '--Choice--',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Recipe'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_recipe';
    }

}
