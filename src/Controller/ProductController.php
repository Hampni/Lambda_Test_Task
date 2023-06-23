<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use App\Repository\LocaleRepository;
use App\Repository\CountryRepository;
use App\Repository\VatRateRepository;

class ProductController extends AbstractController
{
    #[Route('/api/product_price/{id}/{iso_code}', name: 'api_product_price', methods: ['GET'])]
    public function index(
        $id,
        $iso_code,
        ProductRepository $productRepository,
        LocaleRepository $localeRepository,
        CountryRepository $countryRepository,
        VatRateRepository $vatRateRepository
    ): JsonResponse
    {
        $locale = $localeRepository->findOneBy(['iso_code' => $iso_code]);
        $product = $productRepository->find($id);
        $country = $countryRepository->findOneBy(['locale' => $locale]);

        $vat = $vatRateRepository->findOneBy(['category' => $product->getCategory(), 'country' => $country]);
        $vatRate = $vat ? $vat->getRate() : "0";

        $productData = [
            'name' => $product->getName(),
            'category' => $product->getCategory()->getName(),
            'price' => $product->getPrice(),
            'vat_rate' => $vatRate,
            'final_price' => number_format($product->getPrice() * (1 + ($vatRate / 100)), 2, '.', ''),
        ];

        return new JsonResponse($productData);
    }
}
