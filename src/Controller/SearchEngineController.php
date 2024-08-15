<?php

/**
 * SearchEngineController
 *
 * Handles search engine functionality by querying the database for products
 * based on a keyword and rendering the results.
 *
 * @category Controllers
 * @package  App\Controller\SearchEngine
 * @author   Your Name <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 */

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * SearchEngineController
 *
 * Handles search engine functionality by querying the database for products
 * based on a keyword and rendering the results.
 *
 * @category Controllers
 * @package  App\Controller\SearchEngine
 * @author   Your Name <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 */
class SearchEngineController extends AbstractController
{
    /**
     * Searches for products based on a keyword.
     *
     * @param Request           $request           The current HTTP request containing the search query.
     * @param ProductRepository $productRepository The repository to fetch products from the database.

     * @return Response Renders the search results page with the found products and the original search term.
     */
    #[Route('/search/engine', name: 'app_search_engine', methods: ['GET'])]
    public function index(Request $request, ProductRepository $productRepository): Response
    {
        if ($request->isMethod('GET')) {
            $data = $request->query->all();
            $word = $data['word'];
            $results = $productRepository->searchEngine($word);
        }
        return $this->render(
            'search_engine/index.html.twig',
            [
                'products' => $results,
                'word' => $word
            ]
        );
    }
}
