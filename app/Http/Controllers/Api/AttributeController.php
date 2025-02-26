<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Services\AttributeService;
use Illuminate\Http\Request;
use App\Http\Requests\Attribute\StoreAttributeRequest;

class AttributeController extends Controller
{
    protected $attributeService;

    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }

    public function index()
    {
        $attributes = $this->attributeService->getAllAttributes();
        
        return response()->json([
            'status' => 'success',
            'data' => $attributes
        ]);
    }

    public function store(StoreAttributeRequest $request)
    {
        $attribute = $this->attributeService->create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Attribute created successfully',
            'data' => $attribute
        ], 201);
    }

    public function show(Attribute $attribute)
    {
        return response()->json([
            'status' => 'success',
            'data' => $attribute
        ]);
    }

    public function update(Request $request, Attribute $attribute)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255|unique:attributes,name,' . $attribute->id,
            'type' => 'sometimes|string|in:text,number,date,boolean',
        ]);

        $attribute = $this->attributeService->update($attribute, $validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Attribute updated successfully',
            'data' => $attribute
        ]);
    }

    public function destroy(Attribute $attribute)
    {
        $this->attributeService->delete($attribute);

        return response()->json([
            'status' => 'success',
            'message' => 'Attribute deleted successfully'
        ], 204);
    }
}
