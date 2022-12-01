<?php
namespace App\Controller\Admin;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('admin/produit')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_admin_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('admin/produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProduitRepository $produitRepository): Response
    {
        //Creation de variable produit a partir de l'entité class(Produit)
        $produit = new Produit();
        //Creation d'un formulaire a partir de class ProduitType
        //La methode createForm prend en compte trois parametre (string $type, mixed $data = null, array $options = [])
        //Le premier parametre est obligatoire et les deux autres optionelle 
        //Avec une valeure de retour de type
        $form = $this->createForm(ProduitType::class, $produit);
        //Pour traiter les données du formulaire
         //La methode handleRequest prend en compte 1 parametre (mixed $request = null)
        //Le premier parametre est optionelle 
        //Avec une valeure de retour de type
        /*Inspecte la requête donnée et appelle {@link submit()} si le formulaire a été soumis.
        * En interne, la demande est transmise au réseau configuré
        * Instance {@link RequestHandlerInterface}, qui détermine s'il faut
        * soumettre ou non le formulaire.*/
       

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             // on vérifie qu'un fichier a été téléversé
             $fichier = $form->get("photo")->getData();
             if( $fichier ){
                 // on récupère le nom du fichier 
                 $nomFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                 // La classe AsciiSlugger va remplacer les caractères spéciaux par des caractères autorisés dans les URL
                 $slugger = new AsciiSlugger();
                 $nomFichier = $slugger->slug($nomFichier);
                 // La fonction PHP 'uniquid' va générer un string unique sur le serveur
                 $nomFichier .= "_" . uniqid();
                 // on rajoute l'extension du nom de fichier original
                 $nomFichier .= "." . $fichier->guessExtension();
                 // on copie le fichier dans le dossier public/images avec le nouveau nom de fichier 
                 $fichier->move("images", $nomFichier);
 
                 $produit->setPhoto($nomFichier);
             }
 
             // Enregistre les données du produit en BDD
           
            $produitRepository->save($produit, true);

            return $this->redirectToRoute('app_admin_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('admin/produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if( $fichier = $form->get("photo")->getData() ){
                $nomFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                $slugger = new AsciiSlugger();
                $nomFichier = $slugger->slug($nomFichier);
                $nomFichier .= "_" . uniqid();
                $nomFichier .= "." . $fichier->guessExtension();
                $fichier->move("images", $nomFichier);

                if( $produit->getPhoto() ){
                    $fichier = $this->getParameter("image_directory") . $produit->getPhoto();
                    if( file_exists($fichier) ){
                        unlink($fichier);
                    } 
                 }                    
                $produit->setPhoto($nomFichier);
            }
            $produitRepository->save($produit, true);

            return $this->redirectToRoute('app_admin_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $produitRepository->remove($produit, true);
        }

        return $this->redirectToRoute('app_admin_produit_index', [], Response::HTTP_SEE_OTHER);
    }
}
