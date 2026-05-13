<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessProductJob;
use App\Models\ProcessingProfile;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller {

    public function index() {
        // Fetch paginated products for the authenticated user
        $products = Product::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create() {
        $profiles = ProcessingProfile::where('user_id', auth()->id())->get();
        return view('products.form', compact('profiles'));
    }

    public function store(Request $request)
    {
        // Validate that images is an array
//        $request->validate([
//            'products.*.name' => 'required|string|max:255',
//            'products.*.images' => 'required|array|min:1',
//            'products.*.images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120'
//            //'processing_profile_id' => 'required|exists:processing_profiles,id'
//        ]);

        $selectedProfileId = $request->input('processing_profile_id');

        foreach ($request->products as $item) {
            $productImages = [];

            // 2. Create a single Product record with the array of images
            $product = Product::create([
                'user_id' => auth()->id(),
                'name' => $item['name'] ?? 'Auto name',
                'status' => 'pending'
            ]);

            // 1. Process and store all images for this specific product
            if (!isset($item['images'])) {
                return redirect()->back()->withErrors(['error' => 'Missing uploaded images']);
            }
            foreach ($item['images'] as $image) {
                // Store in temp folder and collect the path
                if (!$image->isValid()) {
                    return redirect()->back()->withErrors(['error' => 'File upload failed: ' . $image->getErrorMessage()]);
                }
                $productImages[] = $image;
            }

            $images = [];
            foreach ($productImages as $image) {
                $imagePath = $image->store('original_images', 'public');

                $images[] = ProductImage::create([
                    'product_id'    => $product->id,
                    'original_path' => $imagePath,
                    'is_main'       => false
                ]);;
            }

            // 3. Dispatch Job with 3 arguments: the Product model, the array of images, and the profile ID
            // Note: We pass $imagePaths explicitly as requested
            ProcessProductJob::dispatch($product, $images, $selectedProfileId);
        }

        return redirect()->route('products.index')->with('success', 'Продуктите са добавени за обработка!');
    }
}
