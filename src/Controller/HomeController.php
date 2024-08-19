<?php

/**
 * HomeController
 *
 * Manages the home page and product listings, including filtering by subcategory.
 *
 * @category Controllers
 * @package  App\Controller\Home
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 */

namespace App\Controller;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\SubCategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * HomeController
 *
 * Manages the home page and product listings, including filtering by subcategory.
 *
 * @category Controllers
 * @package  App\Controller\Home
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 */
class HomeController extends AbstractController
{
    /**
     * Displays the homepage with a paginated list of products and all available categories.
     *
     * @param ProductRepository  $productRepository  The repository to fetch products from the database.
     * @param CategoryRepository $categoryRepository The repository to fetch categories from the database.
     * @param Request            $request            The current HTTP request.
     * @param PaginatorInterface $paginator          The paginator service to paginate the products.

     * @return Response Renders the homepage with the paginated list of products and categories.
     */
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        Request $request,
        PaginatorInterface $paginator
    ): Response {
        $sort = $request->query->get('sort');
        if ($sort === 'desc') {
            $data = $productRepository->findBy([], ['price' => 'DESC']);
        } elseif ($sort === 'asc') {
            $data = $productRepository->findBy([], ['price' => 'ASC']);
        } else {
            $data = $productRepository->findAll();
            shuffle($data);
        }
        $products = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            12
        );
        return $this->render(
            'home/index.html.twig',
            [
                'products' => $products,
                'categories' => $categoryRepository->findAll(),
                'sort' => $sort
            ]
        );
    }

    /**
     * Shows a single product along with other recently added products and all available categories.
     *
     * @param Product            $product            The product to display.
     * @param ProductRepository  $productRepository  The repository to fetch products from the database.
     * @param CategoryRepository $categoryRepository The repository to fetch categories from the database.

     * @return Response Renders the product details along with other recent products and categories.
     */
    #[Route('/product/{id}/show', name: 'app_show', methods: ['GET'])]
    public function show(Product $product, ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
    {
        $lastProducts = $productRepository->findBy([], ['id' => 'DESC'], limit: 4);
        return $this->render(
            'home/show.html.twig',
            [
                'products' => $product,
                'lastProducts' => $lastProducts,
                'categories' => $categoryRepository->findAll()
            ]
        );
    }

    /**
     * Filters products by a specific subcategory.
     *
     * @param mixed                 $id                    The ID of the subcategory to filter products by.
     * @param SubCategoryRepository $subCategoryRepository The repository to fetch subcategories from the database.
     * @param CategoryRepository    $categoryRepository    The repository to fetch categories from the database.

     * @return Response Renders the filtered list of products along with the selected subcategory and all available categories.
     */
    #[Route('/product/subcategory/{id}/filter', name: 'app_home_product_filter', methods: ['GET'])]
    public function filter($id, SubCategoryRepository $subCategoryRepository, CategoryRepository $categoryRepository): Response
    {
        $products = $subCategoryRepository->find($id)->getProducts();
        $subCategory = $subCategoryRepository->find($id);
        return $this->render(
            'home/filter.html.twig',
            [
                'products' => $products,
                'subCategory' => $subCategory,
                'categories' => $categoryRepository->findAll()
            ]
        );
    }

    #[Route('/category/{id}/filter', name: 'app_category_product_filter', methods: ['GET'])]
    public function filterCategories($id, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->find($id);
        $products = [];
        foreach ($category->getSubCategories() as $subCategory) {
            foreach ($subCategory->getProducts() as $product) {
                $products[] = $product;
            }
        }
        shuffle($products);
        return $this->render(
            'home/filterCategory.html.twig',
            [
                'products' => $products,
                'category' => $category,
                'categories' => $categoryRepository->findAll()
            ]
        );
    }
}
