<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/load", name="load_products", methods={"POST"})
     */
    public function load(Request $request, EntityManagerInterface $em){
        
        // Get the JSON payload from the request
        $jsonData = json_decode($request->getContent(), true);

        if(is_null($jsonData)){
            return new JsonResponse(['error' => 'Invalid Json payload'], Response::HTTP_BAD_REQUEST);

        }
        foreach($jsonData as $productData){
            // Create a new Product entity
            $product = new  Product();
            $product->setSku($productData['sku']);
            $product->setProductName($productData['product_name']);
            $product->setDescription($productData['description']);
            
            $product->setCreatedAt(new \DateTime());
            $product->setUpdatedAt(new \DateTime());

            $em->persist($product);
        }
        // Flush changes into DB
        $em->flush();
        return new JsonResponse(['message' => 'Products loaded successfully'], Response::HTTP_OK);

    }

    /**
     * @Route("/product/update", name="products_update", methods={"PUT"})
     */
    public function update(Request $request, EntityManagerInterface $em){
        
        // Get the JSON payload from the request        
        $jsonData = json_decode($request->getContent(), true);

        if(is_null($jsonData)){
            return new JsonResponse(['error' => 'Invalid Json payload'], Response::HTTP_BAD_REQUEST);

        }

        // Iterate through the payload and update Records
        foreach ($jsonData as $productData) {
            $sku = $productData['sku'];
        
            // Retrieve the product entity based on the SKU
            $product = $em->getRepository(Product::class)->findOneBy(['sku' => $sku]);
        
            if ($product) {
                // Update allowed fields: ProductName, Description
                $product->setProductName($productData['product_name']);
                $product->setDescription($productData['description']);
                // Set the updatedAt field
                $product->setUpdatedAt(new \DateTime());
                
                $em->flush();

                $responseArray[] = [
                    'sku' => $sku, 
                    'status' => 'updated', 
                    'updated_at' => $product->getUpdatedAt()->format('Y-m-d H:i:s')
                ];

            } else {
                // SKU not found
                $responseArray[] = [
                    'sku' => $sku,
                    'status' => 'error',
                    'message' => 'SKU not found'
                ];
            }
        }
        $response = new JsonResponse($responseArray);
        return $response;
    }

    /**
     * @Route("/product/list", name="products_list", methods={"GET"})
     */
    public function list(EntityManagerInterface $em){
        $products = $em->getRepository(Product::class)->findAll();
        $productArray = [];

        foreach ($products as $product) {
            $productArray[] = [
                'id' => $product->getId(),
                'sku' => $product->getSku(),
                'product_name' => $product->getProductName(),
                'description' => $product->getDescription(),
                'created_at' => $product->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $product->getUpdatedAt()->format('Y-m-d H:i:s'),
            ];
        }

        // Create a JsonResponse with the product data
        $response = new JsonResponse($productArray);

        return $response;
    }
}
