<?php
namespace Users\UsersBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ecommerce\EcommerceBundle\Entity\UtilisateursAdresses;

class UtilisateursAdressesData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $adresse1 = new UtilisateursAdresses();
        $adresse1->setUtilisateur($this->getReference('utilisateur1'));
        $adresse1->setNom('El Ghoul');
        $adresse1->setPrenom('Tarek');
        $adresse1->setTelephone('22484842');
        $adresse1->setAdresse('21 rue de l ile d islande');
        $adresse1->setCp('1053');
        $adresse1->setPays('Tunisie');
        $adresse1->setVille('Tunis');
        $adresse1->setComplement('a cote de Olypmsky');
        $manager->persist($adresse1);
        
        $adresse2 = new UtilisateursAdresses();
        $adresse2->setUtilisateur($this->getReference('utilisateur3'));
        $adresse2->setNom('Berrich');
        $adresse2->setPrenom('chiheb');
        $adresse2->setTelephone('70039007');
        $adresse2->setAdresse('5 rue les jasmins');
        $adresse2->setCp('1070');
        $adresse2->setPays('Tunisie');
        $adresse2->setVille('Nabeul');
        $adresse2->setComplement('face à la plage');
        $manager->persist($adresse2);
        
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 6;
    }
}