<?php

namespace Ecommerce\EcommerceBundle\Controller;

use Ecommerce\EcommerceBundle\Entity\Produits;
use Ecommerce\EcommerceBundle\Form\RechercheType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class produitsController extends Controller
{
    public function categoriesAction($categorie)
    {
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('EcommerceBundle:Produits')->ByCategorie($categorie);

        $categorie = $em->getRepository('EcommerceBundle:Categories')->find($categorie);
        if (!$categorie) throw $this->createNotFoundException('La page n\'existe pas.');

        return $this->render('EcommerceBundle:Default/produits/layout:produits.html.twig',array('produits' => $produits));


    }
    public function produitsAction(Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $findproduits = $em->getRepository('EcommerceBundle:Produits')->findBy(array('disponible'=> 1));
        if ($session->has('panier'))
            $panier = $session->get('panier');
        else
            $panier = false;

        $produits  = $this->get('knp_paginator')->paginate($findproduits,$request->query->getInt('page', 1), 3);

        return $this->render('EcommerceBundle:Default/produits/layout:produits.html.twig',array('produits' => $produits,'panier'=>$panier));
    }

    public function presentationAction(Request $request,$id)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('EcommerceBundle:Produits')->find($id);
        if (!$produit) throw $this->createNotFoundException('La page n\'existe pas.');
        if ($session->has('panier'))
            $panier = $session->get('panier');
        else
            $panier = false;



        return $this->render('EcommerceBundle:Default/produits/layout:presentation.html.twig',array('produit' => $produit, 'panier'=>$panier));
    }

    public function rechercheAction()
    {
        $form = $this->createForm(RechercheType::class);
        return $this->render('@Ecommerce/Default/Recherche/modulesUsed/recherche.html.twig',array('form' => $form->createView()));
    }
    public function rechercheTraitementAction(Request $request)
    {
        $form = $this->createForm(RechercheType::class);
        if($request->isMethod('Post'))
        {
            $form->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            $produits = $em->getRepository('EcommerceBundle:Produits')->recherche($form['recherche']->getData());
        }
        else {
            throw $this->createNotFoundException('Le produit n\'existe pas.');
        }
        return $this->render('@Ecommerce/Default/produits/layout/produits.html.twig',array('produits' => $produits));
    }
    public function searchAjaxAction(Request $request){
        
        if ($request->isXmlHttpRequest()){
            $nom=$request->get('nom');
            $em=$this->getDoctrine();
            $produits=$em->getRepository(Produits::class)
                ->recherche($nom);
            return $this->render('@Ecommerce/Default/produits/layout/produits-list.html.twig', array(
                'produits' => $produits,
          ));
        }
       return $this->render('@Ecommerce/Default/Recherche/layout/rechercheajax.html.twig', array());
    }


}
