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

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Event\RandomProductDisplayEvent;
use App\Repository\SubCategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    #[Route('/')]
    public function indexNoLocale(): Response
    {
        return $this->redirectToRoute('app_home', ['_locale' => 'en']);
    }
    /**
     * Displays the homepage with a paginated list of products and all available categories.
     *
     * @param ProductRepository        $productRepository  The repository to fetch products from the database.
     * @param CategoryRepository       $categoryRepository The repository to fetch categories from the database.
     * @param Request                  $request            The current HTTP request.
     * @param PaginatorInterface       $paginator          The paginator service to paginate the products.
     * @param EventDispatcherInterface $eventDispatcher    The event dispatcher service to handle events.

     * @return Response Renders the homepage with the paginated list of products and categories.
     */
    #[Route('/{_locale<%app.supported_locales%>}/', name: 'app_home', methods: ['GET'])]
    public function index(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        Request $request,
        PaginatorInterface $paginator,
        EventDispatcherInterface $eventDispatcher
    ): Response {
        return $this->renderHome(
            $productRepository,
            $categoryRepository,
            $request,
            $paginator,
            $eventDispatcher
        );
    }

    /**
     * Renders the homepage with paginated products and categories.
     *
     * @param ProductRepository        $productRepository  The repository to fetch products from the database.
     * @param CategoryRepository       $categoryRepository The repository to fetch categories from the database.
     * @param Request                  $request            The current HTTP request.
     * @param PaginatorInterface       $paginator          The paginator service to paginate the products.
     * @param EventDispatcherInterface $eventDispatcher    The event dispatcher service to handle events.
     *
     * @return Response Renders the homepage view.
     */
    private function renderHome(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        Request $request,
        PaginatorInterface $paginator,
        EventDispatcherInterface $eventDispatcher
    ): Response {
        $sort = $request->query->get('sort');
        $filters = $request->query->get('filter');

        $data = $this->getData($productRepository, $sort, $filters);

        $products = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            12
        );

        $randomProduct = $data[array_rand($data)];
        $event = new RandomProductDisplayEvent($randomProduct);
        $eventDispatcher->dispatch($event, RandomProductDisplayEvent::NAME);

        return $this->render(
            'home/index.html.twig',
            [
                'products' => $products,
                'categories' => $categoryRepository->findAll(),
                'sort' => $sort,
                'filters' => $filters,
            ]
        );
    }

    /**
     * Fetches data based on sorting and filtering criteria.
     *
     * @param ProductRepository $productRepository The repository to fetch products from the database.
     * @param string|null       $sort              The sorting criterion (null for no sorting).
     * @param string|null       $filters           The filtering criterion (null for no filters).
     *
     * @return array The fetched data based on the provided criteria.
     */
    private function getData(
        ProductRepository $productRepository,
        ?string $sort,
        ?string $filters
    ) {
        if ($filters === 'bestseller') {
            return $productRepository->findBestSellers();
        } elseif ($sort === 'desc') {
            return $productRepository->findBy([], ['price' => 'DESC']);
        } elseif ($sort === 'asc') {
            return $productRepository->findBy([], ['price' => 'ASC']);
        } else {
            $products =  $productRepository->findAll();
            shuffle($products);
            return $products;
        }
    }

    /**
     * Provides a random product as JSON data.
     *
     * This endpoint returns a random product from the database, including its ID, name, description, price, and image URL.
     *
     * @param ProductRepository $productRepository The repository used to fetch products from the database.
     *
     * @return JsonResponse A JSON response containing the details of a random product.
    */
    #[Route('/{_locale<%app.supported_locales%>}/random-product', name: 'random_product_route', methods: ['GET'])]
    public function getRandomProduct(
        ProductRepository $productRepository
    ): JsonResponse {

        return $this->json(
            [
            'id' => $productRepository->findOneBy([])->getId(),
            'name' => $productRepository->findOneBy([])->getName(),
            'description' => $productRepository->findOneBy([])->getDescription(),
            'price' => $productRepository->findOneBy([])->getPrice(),
            'image' => $productRepository->findOneBy([])->getImage(),
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
    #[Route('/{_locale<%app.supported_locales%>}/product/{id}/show', name: 'app_show', methods: ['GET'])]
    public function show(
        Product $product,
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository
    ): Response {
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
    #[Route('/{_locale<%app.supported_locales%>}/product/subcategory/{id}/filter', name: 'app_home_product_filter', methods: ['GET'])]
    public function filter(
        $id,
        SubCategoryRepository $subCategoryRepository,
        CategoryRepository $categoryRepository
    ): Response {
        $subCategory = $subCategoryRepository->find($id);
        $products = $subCategory->getProducts();
        return $this->render(
            'home/filter.html.twig',
            [
                'products' => $products,
                'subCategory' => $subCategory,
                'categories' => $categoryRepository->findAll()
            ]
        );
    }

    /**
     * Filters and displays products from a specified category and its subcategories.
     *
     * This endpoint fetches products from the given category and all its subcategories, shuffles them, and renders
     * them in a template. It also passes the current category and all categories to the view.
     *
     * @param int                $id                 The ID of the category to filter products from.
     * @param CategoryRepository $categoryRepository The repository used to fetch categories and products from the database.
     *
     * @return Response         A rendered view showing products from the specified category and its subcategories.
    */
    #[Route('/{_locale<%app.supported_locales%>}/category/{id}/filter', name: 'app_category_product_filter', methods: ['GET'])]
    public function filterCategories(
        Category $category,
        CategoryRepository $categoryRepository
    ): Response {
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