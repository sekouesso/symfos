<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\CategoryType;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogueController extends AbstractController
{
    /**
     * @Route("/", name="catalogue")
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('catalogue/index.html.twig', [
            'controller_name' => 'CatalogueController',
        ]);
    }

    /**
     * @Route("/product/new", name="add_product")
     * @Route("/product/edit/{id}",name="edit_product")
     */
    public function createProduct(Product $product=null, Request $request, EntityManagerInterface $manager)
    {

        if(!$product){
            $product = new Product();
        }
        

        $form = $this->createForm(ProductType::class,$product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if(!$product->getId()){
                $product->setCreatedAt(new \DateTime());
            }

            $manager->persist($product);
            $manager->flush();

          return $this->redirectToRoute('show_product_id',[
                'id'=> $product->getId()
            ]);
        }


        return $this->render(
         'catalogue/create.html.twig',[
         'formProduct'=> $form->createView(),
         'editMode'=>$product->getId() !==null
         ]
        );
    }

 
    /**
     * @Route("/category/new", name="add_category")
     */
    public function createCategory(Request $request, EntityManagerInterface $manager)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class,$category);

         $form->handleRequest($request);
         dump($category);

         if($form->isSubmitted() && $form->isValid()){
             $manager->persist($category);
             $manager->flush();

             return  $this->redirectToRoute('getAllCategories');
         }

        return $this->render('catalogue/createCategory.html.twig',[
              'formCategory'=> $form->createView()
        ]);
    }

    /**
     * @Route("/category/getAllCategories", name="getAllCategories")
     */
    public function categories(Request $request,CategoryRepository $category,ProductRepository $product, PaginatorInterface $paginator)
    {
        $products=$product->findAll();
        $products = $paginator->paginate(
            $products, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            4/*limit per page*/
        );
        return $this->render('catalogue/categories.html.twig',[
           'categories' => $category->findAll() ,
           'products' => $products
        ]);
    }

    /**
     * @Route("/category/{id}", name= "show_product")
     */
    public function show(Category $category)
    {
        return $this->render('catalogue/show.html.twig',
        [
            'category'=>$category
        ]
    
    );
    }

    /**
     * @Route("/product/{id}", name="show_product_id")
     */
    public function getProduct(Product $product)    
    {
       return $this->render('catalogue/show.product.html.twig',[
           'product'=> $product
       ]);
    }

}