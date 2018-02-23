<?php

namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Ecommerce\EcommerceBundle\Entity\UtilisateursAdresses;
use Ecommerce\EcommerceBundle\Form\UtilisateursAdressesType;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\Validator\Constraints\DateTime;

class panierController extends Controller
{
    public function menuAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier'))
            $articles = 0;
        else
            $articles = count($session->get('panier'));

        return $this->render('EcommerceBundle:Default:panier/modulesUsed/panier.html.twig', array('articles' => $articles));
    }

    public function ajouterAction(Request $request,$id)
    {
        $session = $request->getSession();

        if (!$session->has('panier')) $session->set('panier',array());
        $panier = $session->get('panier');

        if (array_key_exists($id, $panier)) {
            if ($request->query->get('qte') != null) $panier[$id] = $request->query->get('qte');
            $this->get('session')->getFlashBag()->add('success','Quantité modifié avec succès');
        } else {
            if ($request->query->get('qte') != null)
                $panier[$id] = $request->query->get('qte');
            else
                $panier[$id] = 1;

            $this->get('session')->getFlashBag()->add('success','Article ajouté avec succès');
        }

        $session->set('panier',$panier);


        return $this->redirect($this->generateUrl('panier'));
    }
    public function supprimerAction(Request $request,$id)
    {
        $session = $request->getSession();
        $panier = $session->get('panier');

        if (array_key_exists($id, $panier))
        {
            unset($panier[$id]);
            $session->set('panier',$panier);
            $this->get('session')->getFlashBag()->add('success','Article supprimé avec succès');
        }

        return $this->redirectToRoute('panier');
    }
    public function panierAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier')) $session->set('panier', array());
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('EcommerceBundle:Produits')->findArray(array_keys($session->get('panier')));

        return $this->render('EcommerceBundle:Default:panier/layout/panier.html.twig', array('produits' => $produits,
            'panier' => $session->get('panier')));

    }
    public function adresseSuppressionAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EcommerceBundle:UtilisateursAdresses')->find($id);

        if ($this->container->get('security.token_storage')->getToken()->getUser() != $entity->getUtilisateur() || !$entity)

            return $this->redirectToRoute('livraison');

        $em->remove($entity);

        $em->flush();

        return $this->redirectToRoute('livraison');
    }

    public function livraisonAction(Request $request)

    {

        $utilisateur = $this->container->get('security.token_storage')->getToken()->getUser();

        $entity = new UtilisateursAdresses();

        $form = $this->createForm('Ecommerce\EcommerceBundle\Form\UtilisateursAdressesType',$entity);

         if($request->isMethod('Post'))
        {

            $form->handleRequest($request);
            if ($form->isValid() && $form->isSubmitted()) {
                $em = $this->getDoctrine()->getManager();
                $entity->setUtilisateur($utilisateur);
                $em->persist($entity);
                $em->flush();
                return $this->redirectToRoute('livraison');
            }
        }

        return $this->render('EcommerceBundle:Default:panier/layout/livraison.html.twig', array('utilisateur' => $utilisateur,
            'form' => $form->createView()));
    }

    public function setLivraisonOnSession(Request $request)
    {
        $session = $request->getSession();

        if (!$session->has('adresse')) $session->set('adresse',array());

        $adresse = $session->get('adresse');

        if ($request->request->get('livraison') != null && $request->request->get('facturation') != null)
        {
            $adresse['livraison'] = $request->get('livraison');

            $adresse['facturation'] = $request->get('facturation');

        } else {

            return $this->redirectToRoute('validation');
        }

        $session->set('adresse',$adresse);

        return $this->redirectToRoute('validation');
    }

    public function validationAction(Request $request)
    {
        if ($request->isMethod('POST'))
            $this->setLivraisonOnSession($request);

        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $adresse = $session->get('adresse');

        $produits = $em->getRepository('EcommerceBundle:Produits')->findArray(array_keys($session->get('panier')));
        $livraison = $em->getRepository('EcommerceBundle:UtilisateursAdresses')->find($adresse['livraison']);
        $facturation = $em->getRepository('EcommerceBundle:UtilisateursAdresses')->find($adresse['facturation']);

        return $this->render('EcommerceBundle:Default:panier/layout/validation.html.twig', array('produits' => $produits,
            'livraison' => $livraison,
            'facturation' => $facturation,
            'panier' => $session->get('panier')));
    }

    public function pdfAction (Request $request)
    {
        $date = new DateTime();
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $adresse = $session->get('adresse');

        $produits = $em->getRepository('EcommerceBundle:Produits')->findArray(array_keys($session->get('panier')));
        $livraison = $em->getRepository('EcommerceBundle:UtilisateursAdresses')->find($adresse['livraison']);
        $facturation = $em->getRepository('EcommerceBundle:UtilisateursAdresses')->find($adresse['facturation']);


        $html = $this->renderView('@Ecommerce/Default/panier/layout/pdf.html.twig', array(
                'date' => $date,
                'produits' => $produits,
                'livraison' => $livraison,
                'facturation' => $facturation,
                'panier' => $session->get('panier')));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="file.pdf"'
            )
        );
    }


}
