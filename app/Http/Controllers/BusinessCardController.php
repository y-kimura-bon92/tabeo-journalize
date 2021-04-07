<?php

namespace App\Http\Controllers;

use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BusinessCardController extends Controller
{
    public function index() {

        return view('business_card.index');

    }

    public function extract(Request $request) {

        $imageAnnotator = new ImageAnnotatorClient();

    # annotate the image
    $image = file_get_contents($path);
    $response = $imageAnnotator->textDetection($image);
    $texts = $response->getTextAnnotations();

    printf('%d texts found:' . PHP_EOL, count($texts));
    foreach ($texts as $text) {
        print($text->getDescription() . PHP_EOL);

        # get bounds
        $vertices = $text->getBoundingPoly()->getVertices();
        $bounds = [];
        foreach ($vertices as $vertex) {
            $bounds[] = sprintf('(%d,%d)', $vertex->getX(), $vertex->getY());
        }
        print('Bounds: ' . join(', ', $bounds) . PHP_EOL);
    }

    $imageAnnotator->close();

    }
}