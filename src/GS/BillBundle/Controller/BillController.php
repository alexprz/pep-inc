<?php

namespace GS\BillBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use GS\BillBundle\Entity\Bill;
use GS\BillBundle\Form\BillType;
use GS\BillBundle\Form\BillPayType;

use Symfony\Component\HttpFoundation\File\File;

/**
 * @IsGranted("ROLE_TREASURER", message="Seulement pour les Trez...")
 */
class BillController extends Controller
{
    public function viewAllAction()
    {
        $billList = $this->getDoctrine()->getManager()->getRepository('GSBillBundle:Bill')->findAll();

        return $this->render('GSBillBundle:Bill:view_all.html.twig', array(
            'billList' => $billList
        ));
    }

    public function viewAction($id)
    {
        $bill = $this->getDoctrine()->getManager()->getRepository('GSBillBundle:Bill')->find($id);

        return $this->render('GSBillBundle:Bill:view.html.twig', array(
            'bill' => $bill
        ));
    }

    public function editAction(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getManager();
        $repoBillState = $em->getRepository('GSBillBundle:BillState');
        $repoBillType = $em->getRepository('GSBillBundle:BillType');
        $repoPaymentMean = $em->getRepository('GSBillBundle:PaymentMeans');


        if($id == null){
            $bill = new Bill();
            $titre = "Ajouter une facture";
        }
        else {
            $bill = $em->getRepository('GSBillBundle:Bill')->find($id);
            $titre = "Éditer une facture";
            // if($bill->getBillPdf() != "")
                // $bill->setBillPdf(new File($this->getParameter('bill_directory').'/'.$bill->getBillPdf()));
        }

        $form = $this->createForm(BillType::class, $bill);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $bill->setUser($this->getUser());

            $file = $bill->getBillPdf();
            if($file != null){
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

                $file->move(
                    $this->getParameter('bill_directory'),
                    $fileName
                );
                $bill->setBillPdf($fileName);
            }

            $em->persist($bill);
            $em->flush();

            return $this->redirectToRoute('gs_bill_view', array(
                'id' => $bill->getId()
            ));
        }

        return $this->render('GSBillBundle:Bill:edit.html.twig', array(
            'form' => $form->createView(),
            'title' => $titre,
            'idBillType1' => $repoBillType->findByName('Facture de vente')[0]->getId(),
            'idBillType2' => $repoBillType->findByName('Refacturation')[0]->getId(),
            'idBillStatePaid' => $repoBillState->findByName('Payée')[0]->getId()
        ));
    }

    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }

    public function confirmDeleteAction($id)
    {
        return $this->render('GSBillBundle:Bill:delete.html.twig', array(
            'id' => $id
        ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $bill = $em->getRepository('GSBillBundle:Bill')->find($id);
        $em->remove($bill);
        $em->flush();

        return $this->redirectToRoute('gs_bill_view_all');
    }

    // public function payAction($id)
    // {
    //     $em = $this->getDoctrine()->getManager();
        // $bill = $em->getRepository('GSBillBundle:Bill')->find($id);
        // $payedState = $em->getRepository('GSBillBundle:BillState')->findByName('Payée');
        // $bill->setBillState($payedState[0]);
    //     $bill->setPaymentDate(new \DateTime("now", new \DateTimeZone("EUROPE/Paris")));
    //     $em->persist($bill);
    //     $em->flush();
    //
    //     return $this->redirectToRoute('gs_bill_view', array('id' => $id));
    //
    // }
    public function payAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $bill = $em->getRepository('GSBillBundle:Bill')->find($id);
        $bill->setPaymentDate(new \DateTime("now", new \DateTimeZone("EUROPE/Paris")));

        $form = $this->createForm(BillPayType::class, $bill);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $payedState = $em->getRepository('GSBillBundle:BillState')->findByName('Payée');
            $bill->setBillState($payedState[0]);

            $em->persist($bill);
            $em->flush();

            return $this->redirectToRoute('gs_bill_view', array(
                'id' => $bill->getId()
            ));
        }

        return $this->render('GSBillBundle:Bill:pay.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function abortAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $bill = $em->getRepository('GSBillBundle:Bill')->find($id);
        $cancelledState = $em->getRepository('GSBillBundle:BillState')->findByName('Annulée');
        $bill->setBillState($cancelledState[0]);
        $em->persist($bill);
        $em->flush();

        return $this->redirectToRoute('gs_bill_view', array('id' => $id));

    }

    public function returnAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $bill = $em->getRepository('GSBillBundle:Bill')->find($id);
        $cancelledState = $em->getRepository('GSBillBundle:BillState')->findByName('Émise');
        $bill->setPaymentDate(null);
        $bill->setBillState($cancelledState[0]);
        $em->persist($bill);
        $em->flush();

        return $this->redirectToRoute('gs_bill_view', array('id' => $id));

    }

}
