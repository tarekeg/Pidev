<?php
namespace Users\UsersBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Users\UsersBundle\Entity\Users;

class UtilisateursData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $utilisateur1 = new Users();
        $utilisateur1->setUsername('tarek');
        $utilisateur1->setEmail('tarek@gmail.com');
        $utilisateur1->setEnabled(1);
        $utilisateur1->setPassword($this->container->get('security.encoder_factory')->getEncoder($utilisateur1)->encodePassword('tarek', $utilisateur1->getSalt()));
        $manager->persist($utilisateur1);
        
        $utilisateur2 = new Users();
        $utilisateur2->setUsername('chiheb');
        $utilisateur2->setEmail('chiheb@gmail.com');
        $utilisateur2->setEnabled(1);
        $utilisateur2->setPassword($this->container->get('security.encoder_factory')->getEncoder($utilisateur2)->encodePassword('chiheb', $utilisateur2->getSalt()));
        $manager->persist($utilisateur2);
        
        $utilisateur3 = new Users();
        $utilisateur3->setUsername('akrem');
        $utilisateur3->setEmail('akrem@gmail.com');
        $utilisateur3->setEnabled(1);
        $utilisateur3->setPassword($this->container->get('security.encoder_factory')->getEncoder($utilisateur3)->encodePassword('akrem', $utilisateur3->getSalt()));
        $manager->persist($utilisateur3);
        
        $utilisateur4 = new Users();
        $utilisateur4->setUsername('amine');
        $utilisateur4->setEmail('amine@gmail.com');
        $utilisateur4->setEnabled(1);
        $utilisateur4->setPassword($this->container->get('security.encoder_factory')->getEncoder($utilisateur4)->encodePassword('amine', $utilisateur4->getSalt()));
        $manager->persist($utilisateur4);
         
        $utilisateur5 = new Users();
        $utilisateur5->setUsername('khalil');
        $utilisateur5->setEmail('khalil@gmail.com');
        $utilisateur5->setEnabled(1);
        $utilisateur5->setPassword($this->container->get('security.encoder_factory')->getEncoder($utilisateur5)->encodePassword('khalil', $utilisateur5->getSalt()));
        $manager->persist($utilisateur5);
        
        $manager->flush();
        
        $this->addReference('utilisateur1', $utilisateur1);
        $this->addReference('utilisateur2', $utilisateur2);
        $this->addReference('utilisateur3', $utilisateur3);
        $this->addReference('utilisateur4', $utilisateur4);
        $this->addReference('utilisateur5', $utilisateur5);
    }
    
    public function getOrder()
    {
        return 5;
    }
}