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
        $request->validate([
            'products.*.name' => 'required|string|max:255',
            'products.*.images' => 'required|array|min:1',
            'products.*.images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
            'processing_profile_id' => 'required|integer|exists:processing_profiles,id',
        ]);

        $selectedProfileId = $request->input('processing_profile_id');

        // Verify profile belongs to authenticated user
        $profile = ProcessingProfile::find($selectedProfileId);
        if ($profile->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to use this processing profile');
        }

        foreach ($request->products as $item) {
            $productImages = [];

            // 2. Create a single Product record with the array of images
            $product = Product::create([
                'user_id' => auth()->id(),
                'processing_profile_id' => $selectedProfileId,
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
        }

        return redirect()->route('products.index')->with('success', 'Продуктите са добавени за обработка!');
    }

    public function show(Product $product) {
        if ($product->user_id !== Auth::id()) abort(403);

        return view('products.show', compact('product'));
    }

    public function edit(Product $product) {
        if ($product->user_id !== Auth::id()) abort(403);

        $profiles = ProcessingProfile::where('user_id', auth()->id())->get();
        return view('products.edit', compact('product', 'profiles'));
    }

    public function update(Request $request, Product $product) {
        if ($product->user_id !== Auth::id()) abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'processing_profile_id' => 'required|exists:processing_profiles,id',
        ]);

        $product->update($request->only(['name', 'description', 'processing_profile_id']));

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product) {
        if ($product->user_id !== Auth::id()) abort(403);

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
