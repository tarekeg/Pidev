<?php
namespace Ecommerce\EcommerceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ecommerce\EcommerceBundle\Entity\Media;

class MediaData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $media1 = new Media();
        $media1->setPath('https://www.belibe.be/4742-blb_large/bequille-en-aluminium.jpg');
        $media1->setAlt('Paramédical');
        $manager->persist($media1);
        
        $media2 = new Media();
        $media2->setPath('https://www.spengler.fr/15776-thickbox_default/stethoscope-magister-adulte-double-pavillon-noir.jpg');
        $media2->setAlt('Médical');
        $manager->persist($media2);

        $media3 = new Media();
        $media3->setPath('https://www.decathlon.fr/media/817/8172767/big_7f711e33972b430886c0c66d6bdcf52f.jpg');
        $media3->setAlt('Béquille');
        $manager->persist($media3);   
            
        $media4 = new Media();
        $media4->setPath('https://teleachat-7c18.kxcdn.com/6963-thickbox_default/pack-de-2-appareils-auditifs-rechargeable-acu-true-bonlpus.jpg');
        $media4->setAlt('Appareil Auditif');
        $manager->persist($media4);              
        
        $media5 = new Media();
        $media5->setPath('https://cdn.shopify.com/s/files/1/2157/3141/products/product-image-119618216_530x@2x.jpg?v=1516286769');
        $media5->setAlt('Oxygene Ratio');
        $manager->persist($media5);
        
        $media6 = new Media();
        $media6->setPath('https://www.consomed.fr/uploads/thumbnails/uploads/catalogue/vignette/880-vignette_720x520.jpg');
        $media6->setAlt('Heart Scan');
        $manager->persist($media6);
        
        $media7 = new Media();
        $media7->setPath('https://www.consomed.fr/uploads/thumbnails/uploads/catalogue/photo1/819-photo1_600x500.jpg');
        $media7->setAlt('Tensiomètre');
        $manager->persist($media7);
        
        $media8 = new Media();
        $media8->setPath('http://www.radiographie-medicale.fr/uploads/elfinder/appareil_scanner_radiologie.jpg');
        $media8->setAlt('Scanner');
        $manager->persist($media8);
        
        $manager->flush();
        
        $this->addReference('media1', $media1);
        $this->addReference('media2', $media2);
        $this->addReference('media3', $media3);
        $this->addReference('media4', $media4);
        $this->addReference('media5', $media5);        
        $this->addReference('media6', $media6);
        $this->addReference('media7', $media7);        
        $this->addReference('media8', $media8);
    }
    
    public function getOrder()
    {
        return 1;
    }
}